@extends('layouts.app')
@section('title', 'Kerusakan dan Kehilangan')
@section('heading', 'Laporan Kerusakan / Kehilangan')
@section('subheading', 'Catat fasilitas yang rusak atau hilang agar ketersediaannya diperbarui.')

@section('content')
@php $opts = collect(config('faslink.facilities'))->where('jenis', '!=', 'gedung'); @endphp
<div class="d-flex justify-content-end mb-3"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#damageModal"><i class="bi bi-plus-lg me-1"></i>Buat Laporan</button></div>
<div class="card-soft table-responsive">
  <table class="table align-middle">
    <thead><tr><th>Kode Laporan</th><th>Fasilitas</th><th>Jenis Masalah</th><th>Tanggal</th><th>Status Penanganan</th></tr></thead>
    <tbody>
      <tr><td>#DG-001</td><td>Proyektor</td><td>Kerusakan</td><td>16 Nov 2026</td><td><span class="status pending">Dalam pemeriksaan</span></td></tr>
      <tr><td>#DG-002</td><td>Meja Lipat</td><td>Kehilangan</td><td>14 Nov 2026</td><td><span class="status completed">Selesai</span></td></tr>
    </tbody>
  </table>
</div>

<div class="modal fade" id="damageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
    <form class="demo-form" novalidate data-success="Laporan dibuat (simulasi).">
      <div class="modal-header"><h5 class="modal-title">Laporan Kerusakan / Kehilangan</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
      <div class="modal-body">
        <label class="form-label" for="dFas">Fasilitas terdampak <span class="req">*</span></label>
        <select class="form-select mb-3" id="dFas" required><option value="">Pilih fasilitas</option>@foreach($opts as $o)<option>{{ $o['nama'] }}</option>@endforeach</select>
        <label class="form-label" for="dJenis">Jenis masalah</label><select class="form-select mb-3" id="dJenis"><option>Kerusakan</option><option>Kehilangan</option></select>
        <label class="form-label" for="dDesk">Deskripsi masalah <span class="req">*</span></label><textarea class="form-control mb-3" id="dDesk" rows="3" required minlength="10"></textarea>
        <div class="invalid-feedback mb-2">Deskripsi wajib diisi (minimal 10 karakter).</div>
        <label class="form-label" for="dFoto">Foto bukti</label><input type="file" class="form-control" id="dFoto" accept="image/*">
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary" type="submit">Simpan Laporan</button></div>
    </form>
  </div></div>
</div>
@endsection
