@extends('layouts.app')
@section('title', 'Form Pengajuan Peminjaman')
@section('heading', 'Form Pengajuan Peminjaman')
@section('subheading', 'Lengkapi langkah-langkah berikut untuk mengajukan peminjaman.')

@section('content')
@php
    $all = collect(config('faslink.facilities'))->where('status', 'Aktif');
    $selSlug = ($selected && $selected['status'] === 'Aktif' && $selected['kondisi'] === 'Baik') ? $selected['slug'] : '';
    $me = config('faslink.user');
@endphp
<form id="loanWizard" class="card-soft" novalidate data-selected="{{ $selSlug }}" data-done="{{ route('user.loans') }}">
  <div class="stepper">
    <div class="step active"><span>1</span>Pilih Fasilitas</div>
    <div class="step"><span>2</span>Isi Detail</div>
    <div class="step"><span>3</span>Konfirmasi</div>
  </div>

  {{-- LANGKAH 1 --}}
  <div data-step="1">
    <h3>Pilih Fasilitas</h3>
    <input type="hidden" id="facilityInput" name="fasilitas">
    <div id="pickedBox" class="selected-facility d-none">
      <img id="pickedImg" src="" alt="">
      <div class="grow"><b id="pickedName"></b><br><small id="pickedLoc"></small></div>
      <button type="button" class="btn btn-sm btn-link text-decoration-none fw-bold" id="changeFacility">Ubah</button>
    </div>
    <div id="pickGrid" class="pick-grid">
      @foreach($all as $f)
        @php $ok = $f['kondisi'] === 'Baik'; @endphp
        <button type="button" class="pick-card {{ $ok ? '' : 'disabled' }}" @if(! $ok) disabled @endif
          data-slug="{{ $f['slug'] }}" data-nama="{{ $f['nama'] }}" data-lokasi="{{ $f['lokasi'] }}" data-jenis="{{ $f['jenis'] }}" data-jumlah="{{ $f['jumlah'] }}" data-img="{{ asset('img/' . $f['img']) }}">
          <img src="{{ asset('img/' . $f['img']) }}" alt="">
          <b>{{ $f['nama'] }}</b>
          <small>{{ $ok ? $f['lokasi'] : 'Tidak tersedia' }}</small>
        </button>
      @endforeach
    </div>
    <div id="qtyBox" class="mt-3 d-none" style="max-width:220px">
      <label class="form-label" for="qty">Jumlah unit <span class="req">*</span></label>
      <input type="number" class="form-control" id="qty" min="1" value="1" step="1">
      <div class="form-text" id="qtyHint"></div>
      <div class="invalid-feedback">Jumlah harus 1 sampai stok yang tersedia.</div>
    </div>
    <div class="d-flex justify-content-end gap-2 mt-4">
      <a class="btn btn-light" href="{{ route('user.catalog') }}">Batal</a>
      <button type="button" class="btn btn-primary" data-next>Lanjutkan <i class="bi bi-arrow-right ms-1"></i></button>
    </div>
  </div>

  {{-- LANGKAH 2 --}}
  <div data-step="2" class="d-none">
    <h3>Isi Detail Peminjaman</h3>
    <div id="detailFields" class="row g-3">
      <div class="col-md-6"><label class="form-label" for="kegiatan">Nama kegiatan <span class="req">*</span></label><input class="form-control" id="kegiatan" required maxlength="100" placeholder="Contoh: Seminar Program Kreativitas Mahasiswa"><div class="invalid-feedback">Nama kegiatan wajib diisi.</div></div>
      <div class="col-md-6"><label class="form-label" for="org">Organisasi / UKM</label><input class="form-control" id="org" maxlength="100" placeholder="Nama organisasi (opsional)"></div>
      <div class="col-md-6"><label class="form-label" for="tglPinjam">Tanggal peminjaman <span class="req">*</span></label><input type="date" class="form-control" id="tglPinjam" required><div class="invalid-feedback">Pilih tanggal hari ini atau setelahnya.</div></div>
      <div class="col-md-6"><label class="form-label" for="waktu">Waktu <span class="req">*</span></label><select class="form-select" id="waktu" required>@foreach(config('faslink.waktu') as $w)<option>{{ $w }}</option>@endforeach</select></div>
      <div class="col-12"><label class="form-label" for="tujuan">Tujuan kegiatan <span class="req">*</span></label><textarea class="form-control" id="tujuan" rows="3" required minlength="10" maxlength="500" placeholder="Contoh: Seminar Program Kreativitas Mahasiswa"></textarea><div class="invalid-feedback">Tujuan kegiatan wajib diisi (minimal 10 karakter).</div></div>
      <div class="col-md-4"><label class="form-label" for="pj">Penanggung jawab <span class="req">*</span></label><input class="form-control" id="pj" required value="{{ $me['nama'] }}"><div class="invalid-feedback">Wajib diisi.</div></div>
      <div class="col-md-4"><label class="form-label" for="kontak">Kontak penanggung jawab <span class="req">*</span></label><input class="form-control" id="kontak" required inputmode="tel" pattern="08[0-9]{8,11}" value="{{ $me['telp'] }}" placeholder="08xxxxxxxxxx"><div class="invalid-feedback">Gunakan nomor HP yang diawali 08 (10-13 digit).</div></div>
      <div class="col-md-4"><label class="form-label" for="peserta">Jumlah peserta <span class="req">*</span></label><input type="number" class="form-control" id="peserta" required min="1" step="1"><div class="invalid-feedback" id="pesertaMsg">Isi jumlah peserta (minimal 1, tidak melebihi kapasitas).</div></div>
      <div class="col-12"><label class="form-label" for="dokumen">Proposal / dokumen pendukung</label><input type="file" class="form-control" id="dokumen" accept=".pdf,.doc,.docx"><div class="form-text">Format PDF, DOC, atau DOCX. Maksimal 2 MB.</div><div class="invalid-feedback d-block" id="dokumenMsg"></div></div>
    </div>
    <div class="d-flex justify-content-end gap-2 mt-4">
      <button type="button" class="btn btn-light" data-prev>Kembali</button>
      <button type="button" class="btn btn-primary" data-next>Lanjutkan <i class="bi bi-arrow-right ms-1"></i></button>
    </div>
  </div>

  {{-- LANGKAH 3 --}}
  <div data-step="3" class="d-none">
    <h3>Konfirmasi Pengajuan</h3>
    <p class="muted">Periksa kembali data pengajuanmu sebelum dikirim.</p>
    <dl class="confirm-list">
      <dt>Fasilitas</dt><dd id="cFasilitas"></dd>
      <dt>Tanggal</dt><dd id="cTanggal"></dd>
      <dt>Waktu</dt><dd id="cWaktu"></dd>
      <dt>Nama kegiatan</dt><dd id="cKegiatan"></dd>
      <dt>Organisasi / UKM</dt><dd id="cOrg"></dd>
      <dt>Tujuan</dt><dd id="cTujuan"></dd>
      <dt>Penanggung jawab</dt><dd id="cPj"></dd>
      <dt>Kontak</dt><dd id="cKontak"></dd>
      <dt>Jumlah peserta</dt><dd id="cPeserta"></dd>
      <dt>Dokumen</dt><dd id="cDok"></dd>
    </dl>
    <div class="form-check mt-3"><input class="form-check-input" type="checkbox" id="agree"><label class="form-check-label" for="agree">Saya menyatakan data di atas benar dan bersedia menjaga fasilitas yang dipinjam.</label><div class="invalid-feedback">Centang pernyataan ini untuk melanjutkan.</div></div>
    <div class="d-flex justify-content-end gap-2 mt-4">
      <button type="button" class="btn btn-light" data-prev>Kembali</button>
      <button type="submit" class="btn btn-primary">Kirim Pengajuan <i class="bi bi-send ms-1"></i></button>
    </div>
  </div>
</form>
@endsection
