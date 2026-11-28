@extends('layouts.app')
@section('title', 'Daftar Pengajuan')
@section('heading', 'Daftar Pengajuan')
@section('subheading', 'Pantau seluruh pengajuan yang dikirim mahasiswa.')

@section('content')
@php $fac = collect(config('faslink.facilities'))->keyBy('slug'); $label = config('faslink.status'); @endphp
<div class="card-soft" data-filter-scope>
  <div class="row g-2 mb-3">
    <div class="col-md-7"><div class="search-box"><i class="bi bi-search"></i><input class="form-control" data-filter-search placeholder="Cari kode, pemohon, atau kegiatan..." aria-label="Cari pengajuan"></div></div>
    <div class="col-md-5"><select class="form-select" data-filter-select="status" aria-label="Filter status"><option value="all">Semua status</option>@foreach($label as $k => $t)<option value="{{ $k }}">{{ $t }}</option>@endforeach</select></div>
  </div>
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>Kode</th><th>Pemohon</th><th>Kegiatan</th><th>Fasilitas</th><th>Tanggal Pinjam</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
        @foreach(config('faslink.loans') as $l)
          <tr data-filter-item data-group="all" data-status="{{ $l['status'] }}" data-text="{{ $l['kode'] }} {{ $l['pemohon'] }} {{ $l['kegiatan'] }} {{ $fac[$l['fasilitas']]['nama'] }}">
            <td>#{{ $l['kode'] }}</td><td>{{ $l['pemohon'] }}</td><td>{{ $l['kegiatan'] }}</td><td>{{ $fac[$l['fasilitas']]['nama'] }}</td><td>{{ $l['tgl'] }}</td>
            <td><span class="status {{ $l['status'] }}">{{ $label[$l['status']] }}</span></td>
            <td><a class="btn-view" href="{{ route('admin.verification', $l['kode']) }}">{{ $l['status'] === 'pending' ? 'Verifikasi' : 'Lihat' }}</a></td>
          </tr>
        @endforeach
        <tr class="table-empty" data-filter-empty style="display:none"><td colspan="7">Pengajuan tidak ditemukan.</td></tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
