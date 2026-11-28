@extends('layouts.app')
@section('title', 'Riwayat Persetujuan')
@section('heading', 'Riwayat Persetujuan')
@section('subheading', 'Catatan keputusan verifikasi dan persetujuan yang telah diproses.')

@section('content')
@php
    $by = collect(config('faslink.loans'))->keyBy('kode');
    // [kode, tahap, keputusan, kelas status, tanggal, catatan]
    $rows = [
        ['PJ-008', 'Persetujuan Akhir', 'Disetujui', 'approved', '11 Nov 2026', '-'],
        ['PJ-008', 'Verifikasi', 'Lolos', 'approved', '11 Nov 2026', 'Dokumen lengkap.'],
        ['PJ-002', 'Persetujuan Akhir', 'Disetujui', 'approved', '11 Nov 2026', '-'],
        ['PJ-002', 'Verifikasi', 'Lolos', 'approved', '11 Nov 2026', 'Dokumen lengkap.'],
        ['PJ-003', 'Verifikasi', 'Ditolak', 'rejected', '06 Nov 2026', 'Jadwal bentrok dengan kegiatan fakultas.'],
        ['PJ-005', 'Persetujuan Akhir', 'Disetujui', 'approved', '14 Nov 2026', '-'],
        ['PJ-005', 'Verifikasi', 'Lolos', 'approved', '13 Nov 2026', 'Dokumen lengkap.'],
        ['PJ-006', 'Persetujuan Akhir', 'Disetujui', 'approved', '15 Nov 2026', '-'],
        ['PJ-007', 'Verifikasi', 'Revisi', 'revision', '14 Nov 2026', 'Lampirkan surat izin organisasi.'],
    ];
@endphp
<div class="card-soft table-responsive" data-filter-scope>
  <div class="search-box mb-3" style="max-width:340px"><i class="bi bi-search"></i><input class="form-control" data-filter-search placeholder="Cari kode atau pemohon..." aria-label="Cari"></div>
  <table class="table align-middle">
    <thead><tr><th>Kode</th><th>Pemohon</th><th>Tahap</th><th>Keputusan</th><th>Petugas</th><th>Tanggal</th><th>Catatan</th></tr></thead>
    <tbody>
      @foreach($rows as $r)
        <tr data-filter-item data-group="all" data-text="{{ $r[0] }} {{ $by[$r[0]]['pemohon'] }}">
          <td>#{{ $r[0] }}</td><td>{{ $by[$r[0]]['pemohon'] }}</td><td>{{ $r[1] }}</td>
          <td><span class="status {{ $r[3] }}">{{ $r[2] }}</span></td><td>{{ config('faslink.admin.nama') }}</td><td>{{ $r[4] }}</td><td>{{ $r[5] }}</td>
        </tr>
      @endforeach
      <tr class="table-empty" data-filter-empty style="display:none"><td colspan="7">Data tidak ditemukan.</td></tr>
    </tbody>
  </table>
</div>
@endsection
