@extends('layouts.app')
@section('title', 'Verifikasi & Persetujuan')
@section('heading', 'Verifikasi & Persetujuan')
@section('subheading', 'Periksa dan proses pengajuan fasilitas.')

@section('content')
@php
    $f = collect(config('faslink.facilities'))->firstWhere('slug', $l['fasilitas']);
    $label = config('faslink.status');
    $can = $l['status'] === 'pending';
    $pending = collect(config('faslink.loans'))->where('status', 'pending')->count();
@endphp
<div class="row g-3">
  <div class="col-lg-7">
    <div class="card-soft">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-1">
        <h2 class="fs-4 fw-bold m-0" style="color:var(--navy-dark)">#{{ $l['kode'] }}</h2>
        <span class="status {{ $l['status'] }}" id="loanStatus">{{ $label[$l['status']] }}</span>
      </div>
      <p class="muted">Pengajuan oleh: {{ $l['pemohon'] }}</p>
      <dl class="info-table single">
        <dt><i class="bi bi-building"></i>Fasilitas</dt><dd>{{ $f['nama'] }}@if($f['jenis'] === 'barang') ({{ $l['jumlah'] }} unit)@endif</dd>
        <dt><i class="bi bi-calendar3"></i>Tanggal</dt><dd>{{ $l['tgl'] }}</dd>
        <dt><i class="bi bi-clock"></i>Waktu</dt><dd>{{ $l['waktu'] }}</dd>
        <dt><i class="bi bi-bullseye"></i>Tujuan</dt><dd>{{ $l['tujuan'] }}</dd>
        <dt><i class="bi bi-diagram-3"></i>Organisasi</dt><dd>{{ $l['org'] }}</dd>
        <dt><i class="bi bi-people"></i>Peserta</dt><dd>{{ $l['peserta'] }} orang</dd>
        <dt><i class="bi bi-telephone"></i>Kontak</dt><dd>{{ $l['kontak'] }}</dd>
        <dt><i class="bi bi-send"></i>Diajukan</dt><dd>{{ $l['diajukan'] }}</dd>
      </dl>
      <hr>
      <h3>Dokumen</h3>
      <div class="document-row"><i class="bi bi-file-earmark-pdf"></i>Proposal_Kegiatan.pdf <a href="#" onclick="faslinkToast('Unduh berkas belum tersedia di mode demo.','secondary');return false;"><i class="bi bi-download me-1"></i>Download</a></div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card-soft" id="verifyBox">
      <h3>Keputusan</h3>
      <div class="approval-track mb-3">
        <div class="track-step {{ $can ? 'active' : 'done' }}"><span>{!! $can ? '1' : '<i class="bi bi-check-lg"></i>' !!}</span><b>Verifikasi</b></div>
        <div class="track-step {{ in_array($l['status'], ['approved', 'in-use', 'completed']) ? 'done' : ($l['status'] === 'rejected' ? 'bad' : '') }}"><span>2</span><b>Persetujuan</b></div>
      </div>
      @if($can)
        <label class="form-label" for="adminNote">Catatan admin</label>
        <textarea class="form-control" id="adminNote" rows="4" maxlength="300" placeholder="Wajib diisi jika menolak atau meminta revisi..."></textarea>
        <div class="invalid-feedback d-none" id="noteMsg">Catatan wajib diisi untuk menolak atau meminta revisi.</div>
        <div class="d-flex flex-wrap gap-2 justify-content-end mt-3">
          <button type="button" class="btn-danger-soft" data-decision="rejected"><i class="bi bi-x-lg me-1"></i>Tolak</button>
          <button type="button" class="btn btn-outline-primary btn-sm" data-decision="revision">Minta Revisi</button>
          <button type="button" class="btn btn-primary btn-sm" data-decision="approved"><i class="bi bi-check-lg me-1"></i>Setujui</button>
        </div>
      @else
        <p class="muted mb-0">Pengajuan ini sudah diproses (status: {{ $label[$l['status']] }}) sehingga tidak dapat diputuskan ulang.</p>
      @endif
      <hr>
      <a class="text-link" href="{{ route('admin.loans') }}"><i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Pengajuan</a>
      @if($pending)<span class="muted small float-end">{{ $pending }} menunggu verifikasi</span>@endif
    </div>
  </div>
</div>
@endsection
