@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')
@section('heading', 'Dashboard')

@section('content')
<div class="welcome-row simple-welcome">
  <div>
    <h1>Halo, Budi Santoso</h1>
    <p class="muted">Cari fasilitas kampus dan ajukan peminjaman untuk kegiatanmu.</p>
  </div>
  <a class="btn btn-primary" href="{{ route('user.catalog') }}">Lihat Fasilitas</a>
</div>

<div class="simple-intro mb-4">
  <h2>Peminjaman fasilitas kampus</h2>
  <p>Temukan gedung, ruangan, atau barang yang kamu butuhkan. Ajukan peminjaman secara online dan pantau statusnya melalui halaman pengajuan.</p>
  <a href="{{ route('user.catalog') }}" class="text-link">Buka katalog fasilitas <i class="bi bi-arrow-right"></i></a>
</div>

<div class="panel">
  <div class="section-heading mt-0">
    <h3>Pengajuan terbaru</h3>
    <a href="{{ route('user.loans') }}">Lihat semua</a>
  </div>

  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Kegiatan</th>
          <th>Tanggal</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>#PJ-001</td>
          <td>Seminar Nasional Teknologi</td>
          <td>20 November 2026</td>
          <td><span class="status pending">Menunggu</span></td>
          <td><a href="{{ route('user.loans') }}">Detail</a></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
