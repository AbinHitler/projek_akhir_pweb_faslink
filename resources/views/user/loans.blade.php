@extends('layouts.app')

@section('title', 'Pengajuan Saya')
@section('heading', 'Pengajuan Saya')

@section('content')
<div class="page-intro">
    <div>
        <h1>Pengajuan Saya</h1>
        <p class="muted">Pantau status pengajuan peminjaman fasilitasmu.</p>
    </div>

    <a class="btn btn-primary" href="{{ route('user.loan.create') }}">
        <i class="bi bi-plus-lg me-1"></i>Buat Pengajuan
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="filter-pills mb-3">
    <button class="active" data-status-filter="all">Semua</button>
    <button data-status-filter="pending">Menunggu</button>
    <button data-status-filter="approved">Disetujui</button>
    <button data-status-filter="rejected">Ditolak</button>
    <button data-status-filter="completed">Selesai</button>
</div>

<div class="panel table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Kegiatan</th>
                <th>Fasilitas</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody id="loanRows">
            @forelse($loans as $loan)
                <tr data-status="{{ $loan->status }}">
                    <td>{{ $loan->code }}</td>
                    <td>{{ $loan->activity_name }}</td>
                    <td>{{ $loan->facility_name }}</td>
                    <td>{{ $loan->start_at->format('d M Y H:i') }}</td>

                    <td>
                        <span class="status {{ $loan->status }}">
                            {{ [
                                'pending' => 'Menunggu',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan'
                            ][$loan->status] ?? ucfirst($loan->status) }}
                        </span>
                    </td>

                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('user.loan.detail', $loan->id) }}">
                                Detail
                            </a>

                            @if($loan->status === 'pending')
                                <a href="{{ route('user.loan.edit', $loan->id) }}">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('user.loan.destroy', $loan->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin membatalkan pengajuan ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline-danger">
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Belum ada pengajuan. Klik “Buat Pengajuan” untuk memulai.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($loans->hasPages())
        <div class="p-3">
            {{ $loans->links() }}
        </div>
    @endif
</div>
@endsection
