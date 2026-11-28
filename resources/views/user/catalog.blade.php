@extends('layouts.app')
@section('title', 'Katalog Fasilitas')
@section('heading', 'Katalog Fasilitas')
@section('subheading', 'Cari fasilitas yang kamu butuhkan.')

@section('content')
@php $items = collect(config('faslink.facilities'))->where('status', 'Aktif'); @endphp
<div data-filter-scope>
  <div class="card-soft mb-3 p-3">
    <div class="search-box mb-3"><i class="bi bi-search"></i><input class="form-control" data-filter-search placeholder="Cari fasilitas..." aria-label="Cari fasilitas"></div>
    <div class="filter-pills">
      <button type="button" class="active" data-filter-pill="all">Semua</button>
      <button type="button" data-filter-pill="gedung">Gedung</button>
      <button type="button" data-filter-pill="ruangan">Ruangan</button>
      <button type="button" data-filter-pill="barang">Barang</button>
    </div>
  </div>

  <div class="row g-3">
    @foreach($items as $f)
      <div class="col-sm-6 col-xl-4" data-filter-item data-group="{{ $f['jenis'] }}" data-text="{{ $f['nama'] }} {{ $f['lokasi'] }} {{ $f['kategori'] }}">
        <div class="facility-card">
          <img src="{{ asset('img/' . $f['img']) }}" alt="{{ $f['nama'] }}">
          <div class="body">
            <div class="name"><span>{{ $f['nama'] }}</span>@if(! ($f['kondisi'] === 'Baik'))<span class="status warn">Tidak Tersedia</span>@endif</div>
            <div class="meta">@include('partials.facility-meta', ['f' => $f])</div>
            <div class="spacer"></div>
            <a class="btn-detail" href="{{ route('user.facility.detail', $f['slug']) }}">Lihat Detail <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="empty-state" data-filter-empty style="display:none"><i class="bi bi-search fs-3 d-block mb-2"></i>Fasilitas tidak ditemukan. Coba kata kunci atau filter lain.</div>
</div>
@endsection
