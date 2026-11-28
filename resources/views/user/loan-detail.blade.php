@extends('layouts.app')
@section('title', 'Detail Pengajuan ' . $l['kode'])
@section('back')<a class="back-link" href="{{ route('user.loans') }}"><i class="bi bi-arrow-left"></i> Kembali</a>@endsection

@section('content')
@php
    $f = collect(config('faslink.facilities'))->firstWhere('slug', $l['fasilitas']);
    $label = config('faslink.status');
    $s = $l['status'];
    // status tiap tahap: done | active | bad | '' (belum)
    $t2 = in_array($s, ['approved', 'in-use', 'completed']) ? 'done' : ($s === 'rejected' ? 'bad' : 'active');
    $t3 = in_array($s, ['approved', 'in-use', 'completed']) ? 'done' : '';
@endphp
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <h2 class="page-title fs-4 m-0">Detail Pengajuan #{{ $l['kode'] }}</h2>
  <span class="status {{ $s }}" id="loanStatus">{{ $label[$s] }}</span>
</div>

<div class="row g-3 mb-3">
  <div class="col-lg-6">
    <div class="card-soft h-100">
      <img src="{{ asset('img/' . $f['img']) }}" alt="{{ $f['nama'] }}" class="w-100 rounded-3 mb-3" style="aspect-ratio:16/8;object-fit:cover">
      <b>{{ $f['nama'] }}</b><div class="muted">{{ $f['lokasi'] }}@if($f['jenis'] === 'barang') · {{ $l['jumlah'] }} unit @endif</div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card-soft h-100">
      <h3>Informasi Peminjaman</h3>
      <dl class="info-table single mb-0">
        <dt><i class="bi bi-calendar3"></i>Tanggal</dt><dd>{{ $l['tgl'] }}</dd>
        <dt><i class="bi bi-clock"></i>Waktu</dt><dd>{{ $l['waktu'] }}</dd>
        <dt><i class="bi bi-bullseye"></i>Tujuan</dt><dd>{{ $l['tujuan'] }}</dd>
        <dt><i class="bi bi-flag"></i>Kegiatan</dt><dd>{{ $l['kegiatan'] }}</dd>
        <dt><i class="bi bi-diagram-3"></i>Organisasi</dt><dd>{{ $l['org'] }}</dd>
        <dt><i class="bi bi-people"></i>Peserta</dt><dd>{{ $l['peserta'] }} orang</dd>
        <dt><i class="bi bi-telephone"></i>Kontak</dt><dd>{{ $l['kontak'] }}</dd>
        <dt><i class="bi bi-send"></i>Diajukan</dt><dd>{{ $l['diajukan'] }}</dd>
      </dl>
    </div>
  </div>
</div>

<div class="card-soft mb-3">
  <h3>Alur Persetujuan</h3>
  <div class="approval-track">
    <div class="track-step done"><span><i class="bi bi-check-lg"></i></span><b>Pengajuan</b><small>Terkirim</small></div>
    <div class="track-step {{ $t2 }}"><span>{!! $t2 === 'done' ? '<i class="bi bi-check-lg"></i>' : ($t2 === 'bad' ? '<i class="bi bi-x-lg"></i>' : '2') !!}</span><b>Verifikasi Admin</b><small>{{ $t2 === 'done' ? 'Lolos' : ($t2 === 'bad' ? 'Ditolak' : ($s === 'revision' ? 'Perlu revisi' : 'Menunggu')) }}</small></div>
    <div class="track-step {{ $t3 }}"><span>{!! $t3 === 'done' ? '<i class="bi bi-check-lg"></i>' : '3' !!}</span><b>Persetujuan Akhir</b><small>{{ $t3 === 'done' ? 'Disetujui' : 'Belum diproses' }}</small></div>
  </div>
</div>

<div class="card-soft">
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
    <div class="flex-grow-1">
      <h3>Dokumen Pendukung</h3>
      <div class="document-row"><i class="bi bi-file-earmark-pdf"></i>Proposal_Kegiatan.pdf <a href="#" onclick="faslinkToast('Unduh berkas belum tersedia di mode demo.','secondary');return false;"><i class="bi bi-download me-1"></i>Download</a></div>
    </div>
  </div>
  @if($s === 'pending')
    <div class="text-end mt-3">
      <button type="button" class="btn-danger-soft" id="btnCancelLoan" data-danger="1" data-confirm="Batalkan pengajuan {{ $l['kode'] }}? Tindakan ini tidak dapat dibatalkan." data-success="Pengajuan dibatalkan (simulasi).">
        <i class="bi bi-trash3 me-1"></i>Batalkan Pengajuan
      </button>
    </div>
  @endif
</div>
@endsection
