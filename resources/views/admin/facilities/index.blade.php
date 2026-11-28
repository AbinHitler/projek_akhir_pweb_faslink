@extends('layouts.app')
@section('title', 'Kelola Fasilitas')
@section('heading', 'Kelola Fasilitas')
@section('subheading', 'Kelola data gedung, ruangan, barang, kategori, stok, dan kondisi.')

@section('content')
@php
    $items = collect(config('faslink.facilities'));
    // Fasilitas yang masih dipakai pengajuan aktif tidak boleh dihapus.
    $inUse = collect(config('faslink.loans'))->whereIn('status', ['pending', 'approved', 'in-use'])->pluck('fasilitas')->unique()->all();
@endphp
<div data-filter-scope>
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div class="filter-pills">
      <button type="button" class="active" data-filter-pill="all">Semua</button>
      <button type="button" data-filter-pill="gedung">Gedung</button>
      <button type="button" data-filter-pill="ruangan">Ruangan</button>
      <button type="button" data-filter-pill="barang">Barang</button>
    </div>
    <a class="btn btn-primary" href="{{ route('admin.facilities.create') }}"><i class="bi bi-plus-lg me-1"></i>Tambah Fasilitas</a>
  </div>
  <div class="card-soft">
    <div class="row g-2 mb-3">
      <div class="col-md-7"><div class="search-box"><i class="bi bi-search"></i><input class="form-control" data-filter-search placeholder="Cari nama, lokasi, atau kategori..." aria-label="Cari fasilitas"></div></div>
      <div class="col-md-5"><select class="form-select" data-filter-select="status" aria-label="Filter status"><option value="all">Semua status</option><option value="Aktif">Aktif</option><option value="Tidak Aktif">Tidak Aktif</option></select></div>
    </div>
    <div class="table-responsive">
      <table class="table align-middle">
        <thead><tr><th>Fasilitas</th><th>Jenis</th><th>Lokasi / Induk</th><th>Kapasitas / Stok</th><th>Kondisi</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
          @foreach($items as $f)
            @php $locked = in_array($f['slug'], $inUse); $kc = ['Baik' => 'ok', 'Rusak' => 'bad', 'Pemeliharaan' => 'warn'][$f['kondisi']]; @endphp
            <tr data-filter-item data-group="{{ $f['jenis'] }}" data-status="{{ $f['status'] }}" data-text="{{ $f['nama'] }} {{ $f['lokasi'] }} {{ $f['kategori'] }}">
              <td><div class="d-flex align-items-center gap-2"><img src="{{ asset('img/' . $f['img']) }}" alt="" style="width:46px;height:32px;object-fit:cover;border-radius:6px"><div><b>{{ $f['nama'] }}</b><div class="muted small">{{ $f['kategori'] }}</div></div></div></td>
              <td>{{ ucfirst($f['jenis']) }}</td>
              <td>{{ $f['lokasi'] }}</td>
              <td>{{ $f['jumlah'] === null ? '-' : $f['jumlah'] . ($f['jenis'] === 'barang' ? ' unit' : ' orang') }}</td>
              <td><span class="status {{ $kc }}">{{ $f['kondisi'] }}</span></td>
              <td><span class="status {{ $f['status'] === 'Aktif' ? 'ok' : 'bad' }}">{{ $f['status'] }}</span></td>
              <td class="text-nowrap">
                <a class="btn-view" href="{{ route('admin.facilities.edit', $f['slug']) }}">Edit</a>
                <button type="button" class="btn-danger-soft ms-1" data-remove @if($locked) disabled title="Masih dipakai pengajuan aktif" @else data-danger="1" data-confirm="Hapus {{ $f['nama'] }}? Data fasilitas akan dihapus permanen." data-success="Fasilitas dihapus (simulasi)." @endif aria-label="Hapus {{ $f['nama'] }}"><i class="bi bi-trash3"></i></button>
              </td>
            </tr>
          @endforeach
          <tr class="table-empty" data-filter-empty style="display:none"><td colspan="7">Fasilitas tidak ditemukan.</td></tr>
        </tbody>
      </table>
    </div>
    <p class="muted small mt-3 mb-0"><i class="bi bi-info-circle me-1"></i>Fasilitas yang masih dipakai pengajuan berstatus Menunggu, Disetujui, atau Sedang Digunakan tidak dapat dihapus; ubah statusnya menjadi Tidak Aktif.</p>
  </div>
</div>
@endsection
