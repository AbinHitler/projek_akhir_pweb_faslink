@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('heading', 'Selamat Datang, Admin!')
@section('subheading', 'Kelola peminjaman fasilitas kampus dengan mudah.')

@section('content')
@php
    $label = config('faslink.status');
    $fac = collect(config('faslink.facilities'))->keyBy('slug');
    $recent = collect(config('faslink.loans'))->sortByDesc(fn ($l) => $l['kode'])->take(4);
    $tren = config('faslink.tren');
    $labels = collect(range(11, 0))->map(fn ($i) => \Carbon\Carbon::now()->startOfMonth()->subMonths($i)->locale('id')->isoFormat('MMM'))->values();
@endphp
<div class="row g-3 mb-3">
  {{-- Angka ringkasan demo (statis); ganti dengan hasil query saat backend siap --}}
  <div class="col-md-4"><div class="stat-tile"><span class="stat-icon blue"><i class="bi bi-file-earmark-text"></i></span><div><strong>45</strong><small>Total Pengajuan</small></div></div></div>
  <div class="col-md-4"><div class="stat-tile"><span class="stat-icon green"><i class="bi bi-check2-square"></i></span><div><strong>32</strong><small>Disetujui</small></div></div></div>
  <div class="col-md-4"><div class="stat-tile"><span class="stat-icon amber"><i class="bi bi-hourglass-split"></i></span><div><strong>8</strong><small>Menunggu</small></div></div></div>
</div>

<div class="row g-3">
  <div class="col-xl-7">
    <div class="card-soft h-100">
      <div class="section-head"><h3>Statistik Peminjaman</h3>
        <select class="form-select form-select-sm w-auto" id="rangeSel" aria-label="Rentang bulan"><option value="3">3 Bulan</option><option value="6" selected>6 Bulan</option><option value="12">12 Bulan</option></select>
      </div>
      <div class="chart-wrap" data-chart data-range="#rangeSel" data-count="6" data-values="{{ json_encode($tren) }}" data-labels="{{ json_encode($labels) }}"></div>
    </div>
  </div>
  <div class="col-xl-5">
    <div class="card-soft h-100">
      <div class="section-head"><h3>Pengajuan Terbaru</h3><a href="{{ route('admin.loans') }}">Lihat Semua <i class="bi bi-chevron-right"></i></a></div>
      @foreach($recent as $l)
        <div class="list-row">
          <span class="ico"><i class="bi bi-calendar-check"></i></span>
          <div class="grow"><b>#{{ $l['kode'] }} · {{ $l['kegiatan'] }}</b><small>{{ $l['pemohon'] }} · {{ $l['tgl'] }}</small></div>
          <span class="status {{ $l['status'] }}">{{ $label[$l['status']] }}</span>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
