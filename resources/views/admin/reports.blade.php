@extends('layouts.app')
@section('title', 'Laporan dan Statistik')
@section('heading', 'Laporan & Statistik')
@section('subheading', 'Pantau transaksi dan penggunaan fasilitas kampus.')

@section('content')
@php
    $tren = config('faslink.tren');
    $labels = collect(range(11, 0))->map(fn ($i) => \Carbon\Carbon::now()->startOfMonth()->subMonths($i)->locale('id')->isoFormat('MMM'))->values();
    $top = [['Ruang Seminar', 24], ['Proyektor', 18], ['Aula Serbaguna', 12]];
    $fac = collect(config('faslink.facilities'))->keyBy('slug'); $label = config('faslink.status');
@endphp
<div class="d-flex justify-content-end mb-3 no-print"><button class="btn btn-outline-primary" onclick="window.print()"><i class="bi bi-printer me-1"></i>Cetak Laporan</button></div>
<div class="row g-3 mb-3">
  @foreach([['45', 'Total Transaksi', 'blue', 'bi-receipt'], ['32', 'Disetujui', 'green', 'bi-check2-square'], ['3', 'Terlambat', 'amber', 'bi-alarm'], ['2', 'Kerusakan / Kehilangan', 'cream', 'bi-exclamation-triangle']] as $s)
    <div class="col-sm-6 col-xl-3"><div class="stat-tile"><span class="stat-icon {{ $s[2] }}"><i class="bi {{ $s[3] }}"></i></span><div><strong>{{ $s[0] }}</strong><small>{{ $s[1] }}</small></div></div></div>
  @endforeach
</div>

<form class="card-soft mb-3 demo-form no-print" novalidate data-validate="validateRange" data-success="Filter diterapkan (simulasi).">
  <div class="row g-2 align-items-end">
    <div class="col-md-4"><label class="form-label" for="dari">Dari tanggal</label><input type="date" class="form-control" id="dari" name="dari" required><div class="invalid-feedback">Pilih tanggal awal.</div></div>
    <div class="col-md-4"><label class="form-label" for="sampai">Sampai tanggal</label><input type="date" class="form-control" id="sampai" name="sampai" required><div class="invalid-feedback">Pilih tanggal akhir yang tidak lebih awal dari tanggal awal.</div></div>
    <div class="col-md-4"><button class="btn btn-primary w-100" type="submit">Terapkan Filter</button></div>
  </div>
</form>

<div class="row g-3 mb-3">
  <div class="col-lg-7"><div class="card-soft h-100"><div class="section-head"><h3>Tren Peminjaman</h3><select class="form-select form-select-sm w-auto no-print" id="rangeSel" aria-label="Rentang bulan"><option value="6">6 Bulan</option><option value="12" selected>12 Bulan</option></select></div>
    <div class="chart-wrap" data-chart data-range="#rangeSel" data-count="12" data-values="{{ json_encode($tren) }}" data-labels="{{ json_encode($labels) }}"></div></div></div>
  <div class="col-lg-5"><div class="card-soft h-100"><h3>Fasilitas Paling Sering Dipinjam</h3>
    @foreach($top as $t)<div class="bar-row"><div class="top"><b>{{ $t[0] }}</b><span>{{ $t[1] }} kali</span></div><div class="progress"><div class="progress-bar" style="width:{{ round($t[1] / $top[0][1] * 100) }}%"></div></div></div>@endforeach
  </div></div>
</div>

<div class="card-soft table-responsive">
  <h3>Rekap Transaksi</h3>
  <table class="table align-middle">
    <thead><tr><th>Kode</th><th>Pemohon</th><th>Fasilitas</th><th>Tanggal Pinjam</th><th>Status</th></tr></thead>
    <tbody>@foreach(config('faslink.loans') as $l)<tr><td>#{{ $l['kode'] }}</td><td>{{ $l['pemohon'] }}</td><td>{{ $fac[$l['fasilitas']]['nama'] }}</td><td>{{ $l['tgl'] }}</td><td><span class="status {{ $l['status'] }}">{{ $label[$l['status']] }}</span></td></tr>@endforeach</tbody>
  </table>
</div>
@endsection
