
@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')
@section('heading', 'Dashboard')

@section('content')

<div class="welcome-row">
    <div>
        <p class="eyebrow">SELAMAT DATANG KEMBALI</p>
        <h1>Halo, Budi Santoso! <span>✦</span></h1>
        <p class="muted">Temukan dan pinjam fasilitas kampus untuk kegiatanmu.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('user.catalog') }}">
        <i class="bi bi-search me-2"></i>Cari Fasilitas
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <span class="stat-icon blue"><i class="bi bi-buildings"></i></span>
            <div><strong>12</strong><small>Gedung tersedia</small></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <span class="stat-icon cream"><i class="bi bi-door-open"></i></span>
            <div><strong>48</strong><small>Ruangan tersedia</small></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <span class="stat-icon blue"><i class="bi bi-box-seam"></i></span>
            <div><strong>86</strong><small>Barang tersedia</small></div>
        </div>
    </div>
</div>

<div class="hero-panel">
    <div>
        <span class="eyebrow">PEMINJAMAN FASILITAS KAMPUS</span>
        <h2>Semua kebutuhan kegiatan kampus, dalam satu tempat.</h2>
        <p>Cari fasilitas, periksa ketersediaan, lalu ajukan peminjaman secara online.</p>
        <a class="btn btn-primary" href="{{ route('user.catalog') }}">
            Jelajahi Katalog
            <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>
    <div class="hero-art">
        <i class="bi bi-buildings"></i>
    </div>
</div>

<div class="section-heading">
    <div>
        <span class="eyebrow">PILIHAN UNTUKMU</span>
        <h3>Fasilitas populer</h3>
    </div>
    <a href="{{ route('user.catalog') }}">
        Lihat katalog <i class="bi bi-arrow-right"></i>
    </a>
</div>

<div class="row g-3">
    @foreach([
        ['Aula Serbaguna', 'Gedung Rektorat', '200 orang', 'bi-easel'],
        ['Ruang Seminar', 'Gedung Fakultas', '50 orang', 'bi-door-open'],
        ['Proyektor', 'Inventaris Barang', '16 unit', 'bi-projector']
    ] as $f)

    <div class="col-md-4">
        <div class="facility-mini">
            <div class="facility-placeholder">
                <i class="bi {{ $f[3] }}"></i>
            </div>
            <div class="p-3">
                <b>{{ $f[0] }}</b>
                <small>{{ $f[1] }} · {{ $f[2] }}</small>
                <a href="{{ route('user.catalog') }}">
                    Lihat detail <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    @endforeach
</div>

<div class="section-heading mt-4">
    <div>
        <span class="eyebrow">AKTIVITAS</span>
        <h3>Pengajuan terbaru</h3>
    </div>
    <a href="{{ route('user.loans') }}">
        Lihat semua <i class="bi bi-arrow-right"></i>
    </a>
</div>

<div class="panel table-responsive">
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Kegiatan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#PJ-001</td>
                <td>Seminar Nasional Teknologi</td>
                <td>20 Nov 2026</td>
                <td><span class="status pending">Menunggu</span></td>
                <td><a href="{{ route('user.loans') }}">Detail</a></td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
