
@extends('layouts.app')

@section('title', 'Daftar Pengajuan')
@section('heading', 'Daftar Pengajuan')

@section('content')

<div class="page-intro">
    <div>
        <h1>Seluruh Pengajuan</h1>
        <p class="muted">Cari, filter, dan buka detail pengajuan peminjaman mahasiswa.</p>
    </div>
</div>

<div class="panel mb-3">
    <form method="GET" action="{{ route('admin.loans') }}">
        <div class="row g-2 align-items-end">
            <div class="col-lg-5">
                <label class="form-label">Cari pengajuan</label>
                <input type="search" name="keyword" class="form-control"
                    value="{{ request('keyword') }}"
                    placeholder="Kode, nama pemohon, atau kegiatan">
            </div>

            <div class="col-lg-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua status</option>
                    @foreach([
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan'
                    ] as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-2">
                <label class="form-label">Tanggal mulai</label>
                <input type="date" name="date" class="form-control"
                    value="{{ request('date') }}">
            </div>

            <div class="col-lg-2 d-flex gap-2">
                <button class="btn btn-primary flex-grow-1" type="submit">
                    Filter
                </button>
                <a href="{{ route('admin.loans') }}" class="btn btn-light">
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="panel table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Pemohon</th>
                <th>Kegiatan</th>
                <th>Fasilitas</th>
                <th>Jadwal</th>
                <th>Status</th>
                <th>Detail</th>
            </tr>
        </thead>

        <tbody>
            @forelse($loans as $loan)
                <tr>
                    <td><strong>{{ $loan->code }}</strong></td>
                    <td>{{ $loan->user->name ?? $loan->responsible_name }}</td>
                    <td>{{ $loan->activity_name }}</td>
                    <td>{{ $loan->facility_name }}</td>
                    <td>
                        {{ $loan->start_at->format('d M Y') }}<br>
                        <small class="text-muted">
                            {{ $loan->start_at->format('H:i') }} -
                            {{ $loan->end_at->format('H:i') }}
                        </small>
                    </td>
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
                        <a href="{{ route('admin.loan.detail', $loan->id) }}">
                            Buka detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        Belum ada pengajuan yang sesuai filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-3">
        {{ $loans->links() }}
    </div>
</div>

@endsection
