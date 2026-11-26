@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('heading', 'Dashboard Admin')

@section('content')
<div class="welcome-row simple-welcome">
  <div>
    <h1>Selamat datang, Admin</h1>
    <p class="muted">Berikut ringkasan aktivitas peminjaman fasilitas kampus.</p>
  </div>
  <a href="{{ route('admin.verification') }}" class="btn btn-primary">Periksa Pengajuan</a>
</div>

<div class="row g-3 mb-4">
  <div class="col-sm-6">
    <div class="stat-card simple-stat">
      <div><strong>45</strong><small>Total Pengajuan</small></div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="stat-card simple-stat">
      <div><strong>8</strong><small>Menunggu Verifikasi</small></div>
    </div>
  </div>
</div>

<div class="panel">
  <div class="section-heading mt-0">
    <h3>Pengajuan terbaru</h3>
    <a href="{{ route('admin.loans') }}">Lihat semua</a>
  </div>

  <div class="list-row">
    <div><b>#PJ-004 · Workshop Desain</b><small>Dinda Aulia · 20 November 2026</small></div>
    <span class="status pending">Menunggu</span>
  </div>
  <div class="list-row">
    <div><b>#PJ-003 · Rapat UKM</b><small>Raka Putra · 18 November 2026</small></div>
    <span class="status approved">Disetujui</span>
  </div>
</div>
@endsection
