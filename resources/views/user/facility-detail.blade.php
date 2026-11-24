<<<<<<< HEAD
@extends('layouts.app')
@section('title','Detail Fasilitas')
@section('heading','Detail Fasilitas')
@section('content')
<a class="back-link" href="{{ route('user.catalog') }}"><i class="bi bi-arrow-left"></i> Kembali ke katalog</a>
<div class="panel mt-3"><div class="d-flex justify-content-between align-items-start"><div><span class="badge text-bg-light">{{ ucfirst($facility->type) }}</span><h2 class="mt-2">{{ $facility->name }}</h2></div><span class="badge text-bg-success">Aktif</span></div><hr>
<dl class="row mb-0"><dt class="col-sm-3">Lokasi / Gedung induk</dt><dd class="col-sm-9">{{ $facility->type==='ruangan' ? ($facility->parent?->name ?? '-') : ($facility->location ?: '-') }}</dd>
@if($facility->type==='ruangan')<dt class="col-sm-3">Kapasitas</dt><dd class="col-sm-9">{{ $facility->capacity }} orang</dd>@endif
@if($facility->type==='barang')<dt class="col-sm-3">Stok tersedia</dt><dd class="col-sm-9">{{ $facility->available_stock }} dari {{ $facility->stock_total }} unit</dd>@endif
<dt class="col-sm-3">Kondisi</dt><dd class="col-sm-9">{{ ucfirst($facility->condition) }}</dd><dt class="col-sm-3">Deskripsi</dt><dd class="col-sm-9">{{ $facility->description ?: 'Tidak ada deskripsi.' }}</dd></dl>
</div>
@endsection
=======
@extends('layouts.app') @section('title','Detail Fasilitas') @section('heading','Detail Fasilitas')
@section('content')<a class="back-link" href="{{ route('user.catalog') }}"><i class="bi bi-arrow-left"></i> Kembali ke katalog</a><div class="panel mt-3"><div class="row g-4"><div class="col-lg-5"><div class="facility-placeholder detail-art"><i class="bi bi-easel"></i></div></div><div class="col-lg-7"><span class="status approved">Tersedia</span><h1 class="mt-3">Aula Serbaguna</h1><p class="muted">Gedung Rektorat · Area Kampus</p><p>Aula untuk kegiatan seminar, rapat, dan acara organisasi mahasiswa.</p><div class="detail-facts"><div><small>Kapasitas</small><b>200 orang</b></div><div><small>Kondisi</small><b>Baik</b></div><div><small>Jenis</small><b>Ruangan</b></div><div><small>Jadwal</small><b>Senin–Minggu</b></div></div><a class="btn btn-primary mt-4" href="{{ route('user.loan.create') }}">Ajukan Peminjaman <i class="bi bi-arrow-right ms-2"></i></a></div></div></div>@endsection
>>>>>>> origin/main
