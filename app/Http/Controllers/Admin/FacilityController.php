<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\FacilityCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class FacilityController extends Controller
{
    public function index(Request $request): View
    {
        $facilities = Facility::with(['parent', 'category'])
            ->when($request->filled('type'), fn ($q) => $q->where('type', (string) $request->input('type')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', (string) $request->input('status')))
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.(string) $request->input('search').'%'))
            ->latest()->paginate(10)->withQueryString();

        return view('admin.facilities.index', [
            'facilities' => $facilities,
            'role' => 'admin',
            'counts' => [
                'gedung' => Facility::where('type', 'gedung')->count(),
                'ruangan' => Facility::where('type', 'ruangan')->count(),
                'barang' => Facility::where('type', 'barang')->count(),
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.facilities.form', [
            'role' => 'admin', 'facility' => new Facility(),
            'buildings' => Facility::where('type', 'gedung')->orderBy('name')->get(),
            'categories' => FacilityCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        Facility::create($data);
        return redirect()->route('admin.facilities')->with('success', 'Data fasilitas berhasil ditambahkan.');
    }

    public function edit(Facility $facility): View
    {
        return view('admin.facilities.form', [
            'role' => 'admin', 'facility' => $facility,
            'buildings' => Facility::where('type', 'gedung')->whereKeyNot($facility->id)->orderBy('name')->get(),
            'categories' => FacilityCategory::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Facility $facility): RedirectResponse
    {
        $facility->update($this->validatedData($request, $facility));
        return redirect()->route('admin.facilities')->with('success', 'Data fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility): RedirectResponse
    {
        if ($facility->type === 'gedung' && $facility->rooms()->exists()) {
            return back()->with('error', 'Gedung tidak dapat dihapus karena masih memiliki ruangan. Hapus atau pindahkan ruangannya terlebih dahulu.');
        }

        $facility->delete(); // Soft delete agar data historis tetap aman.
        return redirect()->route('admin.facilities')->with('success', 'Fasilitas berhasil dihapus dari daftar aktif.');
    }

    private function validatedData(Request $request, ?Facility $facility = null): array
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(['gedung', 'ruangan', 'barang'])],
            'name' => ['required', 'string', 'max:150'],
            'parent_id' => ['nullable', 'integer', 'exists:facilities,id'],
            'category_id' => ['nullable', 'integer', 'exists:facility_categories,id'],
            'location' => ['nullable', 'string', 'max:255'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'stock_total' => ['nullable', 'integer', 'min:0'],
            'stock_damaged' => ['nullable', 'integer', 'min:0'],
            'condition' => ['required', Rule::in(['baik', 'rusak', 'pemeliharaan'])],
            'status' => ['required', Rule::in(['aktif', 'tidak_aktif'])],
            'responsible' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
        ], [
            'name.required' => 'Nama fasilitas wajib diisi.',
            'parent_id.exists' => 'Gedung induk tidak ditemukan.',
            'stock_damaged.min' => 'Stok rusak tidak boleh kurang dari nol.',
        ]);

        if ($data['type'] === 'ruangan') {
            if (empty($data['parent_id'])) {
                throw \Illuminate\Validation\ValidationException::withMessages(['parent_id' => 'Pilih gedung induk untuk ruangan.']);
            }
            $parent = Facility::whereKey($data['parent_id'])->where('type', 'gedung')->first();
            if (!$parent || ($facility && $parent->id === $facility->id)) {
                throw \Illuminate\Validation\ValidationException::withMessages(['parent_id' => 'Ruangan harus terhubung ke gedung yang valid.']);
            }
        } else {
            $data['parent_id'] = null;
        }

        if ($data['type'] === 'barang') {
            $total = (int) ($data['stock_total'] ?? 0);
            $damaged = (int) ($data['stock_damaged'] ?? 0);
            if ($damaged > $total) {
                throw \Illuminate\Validation\ValidationException::withMessages(['stock_damaged' => 'Jumlah stok rusak tidak boleh melebihi stok total.']);
            }
            $data['capacity'] = null;
            $data['stock_total'] = $total;
            $data['stock_damaged'] = $damaged;
        } else {
            $data['stock_total'] = null;
            $data['stock_damaged'] = 0;
        }

        if ($data['type'] !== 'ruangan') $data['capacity'] = null;
        if ($data['type'] === 'gedung') $data['category_id'] = null;

        return $data;
    }
}
