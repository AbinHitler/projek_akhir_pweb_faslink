@extends('layouts.app')
@section('title', 'Pengembalian')
@section('heading', 'Pengembalian Fasilitas')
@section('subheading', 'Periksa kondisi fasilitas setelah digunakan.')

@section('content')
@php $fac = collect(config('faslink.facilities'))->keyBy('slug'); $rows = collect(config('faslink.loans'))->where('status', 'in-use'); @endphp
<div class="card-soft table-responsive">
  <table class="table align-middle">
    <thead><tr><th>Kode</th><th>Peminjam</th><th>Fasilitas</th><th>Jadwal</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      @forelse($rows as $l)
        <tr>
          <td>#{{ $l['kode'] }}</td><td>{{ $l['pemohon'] }}</td><td>{{ $fac[$l['fasilitas']]['nama'] }}@if($fac[$l['fasilitas']]['jenis'] === 'barang') ({{ $l['jumlah'] }} unit)@endif</td><td>{{ $l['tgl'] }} · {{ $l['waktu'] }}</td>
          <td><span class="status in-use">Sedang Digunakan</span></td>
          <td><button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#returnModal" data-kode="#{{ $l['kode'] }}">Proses Pengembalian</button></td>
        </tr>
      @empty
        <tr class="table-empty"><td colspan="6">Tidak ada fasilitas yang sedang dipinjam.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="modal fade" id="returnModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
    <form class="demo-form" novalidate data-validate="validateReturn" data-success="Pemeriksaan pengembalian tersimpan (simulasi).">
      <div class="modal-header"><h5 class="modal-title">Pemeriksaan Pengembalian <span data-bind="kode"></span></h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
      <div class="modal-body">
        <label class="form-label" for="rWaktu">Tanggal dan waktu pengembalian <span class="req">*</span></label><input type="datetime-local" class="form-control mb-3" id="rWaktu" required>
        <label class="form-label" for="rKondisi">Kondisi akhir fasilitas</label><select class="form-select mb-3" id="rKondisi" name="kondisi"><option>Baik</option><option>Rusak</option><option>Hilang</option></select>
        <label class="form-label" for="rCatatan">Catatan pemeriksaan <span class="muted fw-normal">(wajib jika Rusak/Hilang)</span></label><textarea class="form-control mb-3" id="rCatatan" name="catatan" rows="2"></textarea>
        <label class="form-label" for="rFoto">Foto dokumentasi</label><input type="file" class="form-control" id="rFoto" accept="image/*" data-preview="#nopreview">
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary" type="submit">Simpan Pengembalian</button></div>
    </form>
  </div></div>
</div>
<img id="nopreview" alt="" hidden>
@endsection
