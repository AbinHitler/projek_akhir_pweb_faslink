<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    private const BLOCKING_STATUSES = ['pending', 'approved'];

    public function create(): View
    {
        return view('user.loan-create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateLoan($request);

        $this->ensureScheduleAvailable(
            $validated['facility_name'],
            $validated['start_at'],
            $validated['end_at']
        );

        $loan = DB::transaction(function () use ($request, $validated) {
            $loan = Loan::create([
                'code' => 'PJ-' . now()->format('ymd') . '-' . Str::upper(Str::random(5)),
                'user_id' => Auth::id(),
                'activity_name' => $validated['activity_name'],
                'organization' => $validated['organization'] ?? null,
                'description' => $validated['description'],
                'responsible_name' => $validated['responsible_name'],
                'responsible_contact' => $validated['responsible_contact'],
                'participant_count' => $validated['participant_count'],
                'start_at' => $validated['start_at'],
                'end_at' => $validated['end_at'],
                'facility_name' => $validated['facility_name'],
                'quantity' => $validated['quantity'],
                'additional_notes' => $validated['additional_notes'] ?? null,
                'status' => 'pending',
            ]);

            $this->storeDocument($request, $loan);

            return $loan;
        });

        return redirect()->route('user.loans')
            ->with('success', 'Pengajuan berhasil dikirim dengan kode ' . $loan->code . '.');
    }

    public function index(): View
    {
        $query = Loan::with('documents')->latest();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        }

        $loans = $query->paginate(10)->withQueryString();

        return view('user.loans', compact('loans'));
    }

    public function show(Loan $loan): View
    {
        $this->ensureOwnerOrDemo($loan);
        $loan->load('documents');

        return view('user.loan-detail', compact('loan'));
    }

    public function edit(Loan $loan): View
    {
        $this->ensureOwnerOrDemo($loan);
        $this->ensurePending($loan);
        $loan->load('documents');

        return view('user.loan-edit', compact('loan'));
    }

    public function update(Request $request, Loan $loan): RedirectResponse
    {
        $this->ensureOwnerOrDemo($loan);
        $this->ensurePending($loan);

        $validated = $this->validateLoan($request);

        $this->ensureScheduleAvailable(
            $validated['facility_name'],
            $validated['start_at'],
            $validated['end_at'],
            (int) $loan->id
        );

        DB::transaction(function () use ($request, $validated, $loan) {
            $loan->update([
                'activity_name' => $validated['activity_name'],
                'organization' => $validated['organization'] ?? null,
                'description' => $validated['description'],
                'responsible_name' => $validated['responsible_name'],
                'responsible_contact' => $validated['responsible_contact'],
                'participant_count' => $validated['participant_count'],
                'start_at' => $validated['start_at'],
                'end_at' => $validated['end_at'],
                'facility_name' => $validated['facility_name'],
                'quantity' => $validated['quantity'],
                'additional_notes' => $validated['additional_notes'] ?? null,
            ]);

            $this->storeDocument($request, $loan, true);
        });

        return redirect()->route('user.loans')
            ->with('success', 'Pengajuan berhasil diperbarui.');
    }

    public function destroy(Loan $loan): RedirectResponse
    {
        $this->ensureOwnerOrDemo($loan);
        $this->ensurePending($loan);

        $loan->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return redirect()->route('user.loans')
            ->with('success', 'Pengajuan berhasil dibatalkan. Jadwal kembali tersedia.');
    }

    public function calendar(): View
    {
        return view('user.calendar');
    }

    public function calendarEvents(Request $request): JsonResponse
    {
        $query = Loan::query()
            ->whereIn('status', self::BLOCKING_STATUSES)
            ->when(
                $request->filled('facility_name'),
                function ($query) use ($request) {
                    $query->where(
                        'facility_name',
                        $request->string('facility_name')->toString()
                    );
                }
            );

        $events = $query->get()->map(function ($loan) {
            $approved = $loan->status === 'approved';

            return [
                'id' => $loan->id,
                'title' => $approved ? 'Terisi' : 'Menunggu',
                'start' => $loan->start_at->toIso8601String(),
                'end' => $loan->end_at->toIso8601String(),
                'backgroundColor' => $approved ? '#dc3545' : '#eab308',
                'borderColor' => $approved ? '#dc3545' : '#eab308',
                'textColor' => $approved ? '#ffffff' : '#212529',
                'display' => 'block',
            ];
        });

        return response()->json($events);
    }

    public function adminIndex(Request $request): View
    {
        $query = Loan::query()
            ->with(['documents', 'user'])
            ->latest();

        if ($request->filled('keyword')) {
            $keyword = $request->string('keyword')->toString();

            $query->where(function ($query) use ($keyword) {
                $query->where('code', 'like', "%{$keyword}%")
                    ->orWhere('responsible_name', 'like', "%{$keyword}%")
                    ->orWhere('activity_name', 'like', "%{$keyword}%")
                    ->orWhereHas('user', function ($userQuery) use ($keyword) {
                        $userQuery->where('name', 'like', "%{$keyword}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->string('status')->toString()
            );
        }

        if ($request->filled('date')) {
            $query->whereDate(
                'start_at',
                $request->string('date')->toString()
            );
        }

        $loans = $query->paginate(10)->withQueryString();

        return view('admin.loans', compact('loans') + ['role' => 'admin']);
    }

    public function adminShow(Loan $loan): View
    {
        $loan->load(['documents', 'user']);

        return view('admin.loan-detail', compact('loan') + ['role' => 'admin']);
    }

   public function downloadDocument(Loan $loan, int $document)
{
    $this->ensureOwnerOrDemo($loan);

    $documentData = $loan->documents()->findOrFail($document);
    $filePath = Storage::disk('local')->path($documentData->file_path);

    abort_unless(file_exists($filePath), 404, 'File dokumen tidak ditemukan.');

    return response()->download($filePath, $documentData->original_name);
}

public function adminDownloadDocument(Loan $loan, int $document)
{
    $documentData = $loan->documents()->findOrFail($document);
    $filePath = Storage::disk('local')->path($documentData->file_path);

    abort_unless(file_exists($filePath), 404, 'File dokumen tidak ditemukan.');

    return response()->download($filePath, $documentData->original_name);
}

    private function validateLoan(Request $request): array
    {
        return $request->validate([
            'activity_name' => ['required', 'string', 'max:150'],
            'organization' => ['nullable', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:5000'],
            'responsible_name' => ['required', 'string', 'max:150'],
            'responsible_contact' => ['required', 'string', 'max:30'],
            'participant_count' => ['required', 'integer', 'min:1', 'max:100000'],
            'start_at' => ['required', 'date', 'after_or_equal:now'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'facility_name' => ['required', 'string', 'max:150'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10000'],
            'document' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'additional_notes' => ['nullable', 'string', 'max:2000'],
        ], [
            'start_at.after_or_equal' => 'Tanggal dan jam mulai tidak boleh sebelum waktu sekarang.',
            'end_at.after' => 'Tanggal dan jam selesai harus setelah waktu mulai.',
            'document.max' => 'Ukuran dokumen maksimal 5 MB.',
            'document.mimes' => 'Dokumen harus berformat PDF, DOC, atau DOCX.',
        ]);
    }

    private function ensureScheduleAvailable(
        string $facilityName,
        string $startAt,
        string $endAt,
        ?int $ignoreLoanId = null
    ): void {
        $conflict = Loan::query()
            ->where('facility_name', $facilityName)
            ->whereIn('status', self::BLOCKING_STATUSES)
            ->where('start_at', '<', $endAt)
            ->where('end_at', '>', $startAt)
            ->when(
                $ignoreLoanId !== null,
                function ($query) use ($ignoreLoanId) {
                    $query->where('id', '!=', $ignoreLoanId);
                }
            )
            ->exists();

        if ($conflict) {
            throw ValidationException::withMessages([
                'start_at' => 'Jadwal fasilitas tersebut sudah terisi atau sedang menunggu persetujuan. Silakan pilih jam lain.',
            ]);
        }
    }

    private function ensurePending(Loan $loan): void
    {
        abort_unless(
            $loan->status === 'pending',
            403,
            'Pengajuan hanya bisa diedit atau dibatalkan ketika status masih Menunggu.'
        );
    }

    private function ensureOwnerOrDemo(Loan $loan): void
    {
        if (
            Auth::check()
            && (string) $loan->user_id !== (string) Auth::id()
        ) {
            abort(403, 'Kamu tidak memiliki akses ke pengajuan ini.');
        }
    }

    private function storeDocument(
        Request $request,
        Loan $loan,
        bool $replace = false
    ): void {
        if (!$request->hasFile('document')) {
            return;
        }

        if ($replace) {
            foreach ($loan->documents as $oldDocument) {
                Storage::disk('local')->delete($oldDocument->file_path);
                $oldDocument->delete();
            }
        }

        $file = $request->file('document');
        $path = $file->store('loan-documents', 'local');

        $loan->documents()->create([
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);
    }
}