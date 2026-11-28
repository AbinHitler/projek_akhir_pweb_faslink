@extends('layouts.app')
@section('title', 'Serah Terima')
@section('heading', 'Serah Terima Fasilitas')
@section('subheading', 'Catat penyerahan fasilitas kepada peminjam.')

@section('content')
@php $fac = collect(config('faslink.facilities'))->keyBy('slug'); $rows = collect(config('faslink.loans'))->where('status', 'approved'); @endphp
<div class="card-soft table-responsive">
  <table class="table align-middle">
    <thead><tr><th>Kode</th><th>Peminjam</th><th>Fasilitas</th><th>Jadwal</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      @forelse($rows as $l)
        <tr>
          <td>#{{ $l['kode'] }}</td><td>{{ $l['pemohon'] }}</td><td>{{ $fac[$l['fasilitas']]['nama'] }}@if($fac[$l['fasilitas']]['jenis'] === 'barang') ({{ $l['jumlah'] }} unit)@endif</td><td>{{ $l['tgl'] }} · {{ $l['waktu'] }}</td>
          <td><span class="status approved">Disetujui</span></td>
          <td><button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#handoverModal" data-kode="#{{ $l['kode'] }}" data-peminjam="{{ $l['pemohon'] }}">Catat Serah Terima</button></td>
        </tr>
      @empty
        <tr class="table-empty"><td colspan="6">Tidak ada fasilitas yang menunggu serah terima.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="modal fade" id="handoverModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
    <form class="demo-form" novalidate data-success="Serah terima tercatat (simulasi).">
      <div class="modal-header"><h5 class="modal-title">Catat Serah Terima <span data-bind="kode"></span></h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
      <div class="modal-body">
        <label class="form-label" for="hPetugas">Petugas yang menyerahkan <span class="req">*</span></label><input class="form-control mb-3" id="hPetugas" required value="{{ config('faslink.admin.nama') }}">
        <label class="form-label" for="hPeminjam">Peminjam yang menerima</label><input class="form-control mb-3" id="hPeminjam" data-bind="peminjam" readonly>
        <label class="form-label" for="hWaktu">Tanggal dan waktu <span class="req">*</span></label><input type="datetime-local" class="form-control mb-3" id="hWaktu" required>
        <label class="form-label" for="hKondisi">Kondisi awal fasilitas</label><select class="form-select mb-3" id="hKondisi"><option>Baik</option><option>Rusak</option></select>
        <label class="form-label" for="hCatatan">Catatan / dokumentasi</label><textarea class="form-control" id="hCatatan" rows="2"></textarea>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary" type="submit">Simpan Catatan</button></div>
    </form>
  </div></div>
</div>
@endsection
