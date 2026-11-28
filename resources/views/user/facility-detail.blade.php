@extends('layouts.app')
@section('title', $f['nama'])
@section('back')<a class="back-link" href="{{ route('user.catalog') }}"><i class="bi bi-arrow-left"></i> Kembali ke Katalog</a>@endsection

@section('content')
@php $ok = $f['status'] === 'Aktif' && $f['kondisi'] === 'Baik'; @endphp
<div class="detail-hero">
  <img src="{{ asset('img/' . $f['img']) }}" alt="{{ $f['nama'] }}">
  <div class="py-2 pe-2">
    <h1>{{ $f['nama'] }} @include('partials.facility-badge', ['f' => $f])</h1>
    <div class="info-line"><i class="bi bi-geo-alt"></i>{{ $f['jenis'] === 'gedung' ? 'Area ' . $f['lokasi'] : $f['lokasi'] }}</div>
    @if($f['jenis'] === 'ruangan')<div class="info-line"><i class="bi bi-people"></i>Kapasitas: {{ $f['jumlah'] }} orang</div>@endif
    @if($f['jenis'] === 'barang')<div class="info-line"><i class="bi bi-box-seam"></i>Stok: {{ $f['jumlah'] }} unit</div>@endif
    <p class="mt-3 mb-0 text-secondary">{{ $f['deskripsi'] }}</p>
  </div>
</div>

<div class="card-soft mb-3">
  <h3>Informasi Peminjaman</h3>
  <dl class="info-table single mb-0">
    <dt><i class="bi bi-calendar3"></i>Jadwal Tersedia</dt><dd>{{ $f['jadwal'] }}</dd>
    <dt><i class="bi bi-clock"></i>Waktu Maksimal</dt><dd>{{ $f['maks'] }}</dd>
    <dt><i class="bi bi-tag"></i>Kategori</dt><dd>{{ $f['kategori'] }}</dd>
    <dt><i class="bi bi-shield-check"></i>Kondisi</dt><dd>{{ $f['kondisi'] }}</dd>
    <dt><i class="bi bi-person-badge"></i>Penanggung Jawab</dt><dd>{{ $f['pic'] }}</dd>
  </dl>
</div>

@if($ok)
  <a class="btn btn-primary btn-block" href="{{ route('user.loan.create', ['fasilitas' => $f['slug']]) }}">Ajukan Peminjaman <i class="bi bi-arrow-right"></i></a>
@else
  <button class="btn btn-primary btn-block" disabled>Ajukan Peminjaman</button>
  <p class="text-center muted small mt-2 mb-0">Fasilitas ini sedang tidak dapat dipinjam ({{ $f['kondisi'] === 'Baik' ? 'tidak aktif' : strtolower($f['kondisi']) }}).</p>
@endif
@endsection
