@extends('layouts.app')
@section('title', 'Dashboard Mahasiswa')
@section('heading', 'Halo, ' . config('faslink.user.nama') . '! 👋')
@section('subheading', 'Selamat datang di FASLINK. Yuk, pinjam fasilitas kampus dengan mudah.')

@section('content')
@php
    $r = config('faslink.ringkasan');
    $fac = collect(config('faslink.facilities'))->keyBy('slug');
    $recent = collect(config('faslink.loans'))->where('pemohon', config('faslink.user.nama'))->take(3);
    $label = config('faslink.status');
@endphp
<div class="row g-3 mb-3">
  <div class="col-md-4"><div class="stat-tile"><span class="stat-icon blue"><i class="bi bi-bank"></i></span><div><strong>{{ $r['gedung'] }}</strong><small>Gedung</small></div></div></div>
  <div class="col-md-4"><div class="stat-tile"><span class="stat-icon cream"><i class="bi bi-door-open"></i></span><div><strong>{{ $r['ruangan'] }}</strong><small>Ruangan</small></div></div></div>
  <div class="col-md-4"><div class="stat-tile"><span class="stat-icon blue"><i class="bi bi-box-seam"></i></span><div><strong>{{ $r['barang'] }}</strong><small>Barang</small></div></div></div>
</div>

<div class="hero-panel mb-3">
  <div>
    <h2>Pinjam Fasilitas Kampus<br>Lebih Mudah dengan FASLINK!</h2>
    <p>Cari, ajukan, dan pantau peminjaman fasilitas kampus dalam satu sistem.</p>
    <a href="{{ route('user.catalog') }}" class="btn btn-primary">Cari Fasilitas <i class="bi bi-arrow-right ms-1"></i></a>
  </div>
  <img src="{{ asset('img/hero.svg') }}" alt="">
</div>

<div class="card-soft">
  <div class="section-head"><h3>Pengajuan Terbaru</h3><a href="{{ route('user.loans') }}">Lihat Semua <i class="bi bi-chevron-right"></i></a></div>
  @forelse($recent as $l)
    <div class="list-row">
      <span class="ico"><i class="bi bi-calendar-check"></i></span>
      <div class="grow"><b>Peminjaman {{ $fac[$l['fasilitas']]['nama'] }}</b><small>{{ $l['diajukan'] }}</small></div>
      <span class="status {{ $l['status'] }}">{{ $label[$l['status']] }}</span>
      <a class="text-link" href="{{ route('user.loan.detail', $l['kode']) }}" aria-label="Lihat detail {{ $l['kode'] }}"><i class="bi bi-chevron-right"></i></a>
    </div>
  @empty
    <div class="empty-state">Belum ada pengajuan. <a href="{{ route('user.catalog') }}">Cari fasilitas</a> untuk memulai.</div>
  @endforelse
</div>
@endsection
