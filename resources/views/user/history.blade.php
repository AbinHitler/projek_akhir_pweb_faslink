@extends('layouts.app')
@section('title', 'Riwayat Peminjaman')
@section('heading', 'Riwayat Peminjaman')
@section('subheading', 'Lihat seluruh riwayat peminjaman fasilitasmu.')

@section('content')
<div class="card-soft table-responsive" data-filter-scope>
  <div class="search-box mb-3" style="max-width:340px"><i class="bi bi-search"></i><input class="form-control" data-filter-search placeholder="Cari riwayat..." aria-label="Cari riwayat"></div>
  <table class="table align-middle">
    <thead><tr><th>No.</th><th>Tanggal</th><th>Fasilitas</th><th>Tujuan</th><th>Status</th></tr></thead>
    <tbody>
      @foreach(config('faslink.history') as $i => $h)
        <tr data-filter-item data-group="completed" data-text="{{ $h['kode'] }} {{ $h['fasilitas'] }} {{ $h['tujuan'] }}">
          <td>{{ $i + 1 }} <span class="muted">#{{ $h['kode'] }}</span></td><td>{{ $h['tgl'] }}</td><td>{{ $h['fasilitas'] }}</td><td>{{ $h['tujuan'] }}</td>
          <td><span class="status completed">Selesai</span></td>
        </tr>
      @endforeach
      <tr class="table-empty" data-filter-empty style="display:none"><td colspan="5">Riwayat tidak ditemukan.</td></tr>
    </tbody>
  </table>
</div>
@endsection
