@extends('layouts.app')
@section('title','Katalog Fasilitas')
@section('heading','Katalog Fasilitas')
@section('content')
<div class="page-intro"><div><h1>Katalog Fasilitas</h1><p class="muted">Lihat fasilitas kampus yang aktif dan dalam kondisi baik.</p></div></div>
<div class="panel">
<form method="GET" class="row g-2 mb-4"><div class="col-md-7"><input name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama fasilitas..."></div><div class="col-md-3"><select name="type" class="form-select"><option value="">Semua jenis</option>@foreach(['gedung'=>'Gedung','ruangan'=>'Ruangan','barang'=>'Barang'] as $key=>$label)<option value="{{ $key }}" @selected(request('type')===$key)>{{ $label }}</option>@endforeach</select></div><div class="col-md-2"><button class="btn btn-primary w-100">Cari</button></div></form>
<div class="row g-3">
@forelse($facilities as $facility)
<div class="col-md-6 col-xl-4"><div class="border rounded-3 p-3 h-100"><div class="d-flex justify-content-between mb-2"><span class="badge text-bg-light">{{ ucfirst($facility->type) }}</span><span class="badge text-bg-success">Tersedia</span></div><h5>{{ $facility->name }}</h5><p class="text-muted small mb-2">@if($facility->type==='ruangan'){{ $facility->parent?->name }}@else{{ $facility->location ?: 'Lokasi belum diisi' }}@endif</p>
@if($facility->type==='ruangan')<p class="small mb-3">Kapasitas: {{ $facility->capacity }} orang</p>@elseif($facility->type==='barang')<p class="small mb-3">Stok tersedia: {{ $facility->available_stock }} unit</p>@else<p class="small mb-3">{{ Str::limit($facility->description,80) }}</p>@endif
<a href="{{ route('user.facility.detail',$facility) }}" class="btn btn-outline-primary btn-sm">Lihat Detail</a></div></div>
@empty<div class="col-12"><div class="text-center text-muted py-5">Belum ada fasilitas yang tersedia.</div></div>@endforelse
</div>{{ $facilities->links() }}
</div>
@endsection
