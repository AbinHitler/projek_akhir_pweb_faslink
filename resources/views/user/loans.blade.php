@extends('layouts.app')
@section('title', 'Pengajuan Saya')
@section('heading', 'Pengajuan Saya')
@section('subheading', 'Pantau status pengajuan peminjamanmu di sini.')

@section('content')
@php
    $fac = collect(config('faslink.facilities'))->keyBy('slug');
    $mine = collect(config('faslink.loans'))->where('pemohon', config('faslink.user.nama'))->values();
    $label = config('faslink.status');
@endphp
<div data-filter-scope>
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div class="filter-pills">
      <button type="button" class="active" data-filter-pill="all">Semua</button>
      <button type="button" data-filter-pill="pending">Menunggu</button>
      <button type="button" data-filter-pill="approved">Disetujui</button>
      <button type="button" data-filter-pill="rejected">Ditolak</button>
      <button type="button" data-filter-pill="completed">Selesai</button>
    </div>
    <a class="btn btn-primary" href="{{ route('user.loan.create') }}"><i class="bi bi-plus-lg me-1"></i>Buat Pengajuan</a>
  </div>
  <div class="card-soft table-responsive">
    <table class="table align-middle">
      <thead><tr><th>No.</th><th>Tanggal</th><th>Fasilitas</th><th>Tujuan</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
        @foreach($mine as $i => $l)
          <tr data-filter-item data-group="{{ $l['status'] }}" data-text="{{ $l['kode'] }} {{ $fac[$l['fasilitas']]['nama'] }} {{ $l['tujuan'] }}">
            <td>{{ $i + 1 }} <span class="muted">#{{ $l['kode'] }}</span></td>
            <td>{{ $l['diajukan'] }}</td>
            <td>{{ $fac[$l['fasilitas']]['nama'] }}</td>
            <td>{{ $l['tujuan'] }}</td>
            <td><span class="status {{ $l['status'] }}">{{ $label[$l['status']] }}</span></td>
            <td><a class="btn-view" href="{{ route('user.loan.detail', $l['kode']) }}">Lihat</a></td>
          </tr>
        @endforeach
        <tr class="table-empty" data-filter-empty style="display:none"><td colspan="6">Tidak ada pengajuan dengan status ini.</td></tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
