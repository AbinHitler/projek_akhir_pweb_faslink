@extends('layouts.app')
@php $edit = $f !== null; @endphp
@section('title', $edit ? 'Ubah Fasilitas' : 'Tambah Fasilitas')
@section('back')<a class="back-link" href="{{ route('admin.facilities') }}"><i class="bi bi-arrow-left"></i> Kembali ke Kelola Fasilitas</a>@endsection

@section('content')
@php
    $gedung = collect(config('faslink.facilities'))->where('jenis', 'gedung');
    $v = fn ($k, $d = '') => $edit ? ($f[$k] ?? $d) : $d;
@endphp
<form class="card-soft demo-form" novalidate data-success="{{ $edit ? 'Perubahan fasilitas tersimpan (simulasi).' : 'Fasilitas baru ditambahkan (simulasi).' }}">
  <h3>{{ $edit ? 'Ubah Fasilitas: ' . $f['nama'] : 'Tambah Fasilitas Baru' }}</h3>
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label" for="fJenis">Jenis fasilitas <span class="req">*</span></label>
      <select class="form-select" id="fJenis" required>
        <option value="">Pilih jenis</option>
        @foreach(['gedung' => 'Gedung', 'ruangan' => 'Ruangan', 'barang' => 'Barang'] as $val => $txt)<option value="{{ $val }}" @selected($v('jenis') === $val)>{{ $txt }}</option>@endforeach
      </select><div class="invalid-feedback">Pilih jenis fasilitas.</div>
    </div>
    <div class="col-md-6"><label class="form-label" for="fNama">Nama fasilitas <span class="req">*</span></label><input class="form-control" id="fNama" required maxlength="100" value="{{ $v('nama') }}"><div class="invalid-feedback">Nama fasilitas wajib diisi.</div></div>
    <div class="col-md-6">
      <label class="form-label" for="fInduk">Gedung induk <span class="req">*</span></label>
      <select class="form-select" id="fInduk"><option value="">Pilih gedung</option>@foreach($gedung as $g)<option @selected($v('lokasi') === $g['nama'])>{{ $g['nama'] }}</option>@endforeach<option>Gedung Fakultas</option></select>
      <div class="invalid-feedback">Pilih gedung induk ruangan.</div>
    </div>
    <div class="col-md-6"><label class="form-label" for="fKategori">Kategori <span class="req">*</span></label><input class="form-control" id="fKategori" required maxlength="60" placeholder="Contoh: Elektronik" value="{{ $v('kategori') }}"><div class="invalid-feedback">Kategori wajib diisi.</div></div>
    <div class="col-md-6"><label class="form-label" id="fJumlahLabel" for="fJumlah">Kapasitas / stok</label><input type="number" class="form-control" id="fJumlah" min="1" step="1" value="{{ $v('jumlah') }}"><div class="invalid-feedback">Isi angka bilangan bulat minimal 1.</div></div>
    <div class="col-md-6"><label class="form-label" for="fPic">Penanggung jawab <span class="req">*</span></label><input class="form-control" id="fPic" required maxlength="80" value="{{ $v('pic') }}"><div class="invalid-feedback">Penanggung jawab wajib diisi.</div></div>
    <div class="col-md-4"><label class="form-label" for="fKondisi">Kondisi</label><select class="form-select" id="fKondisi">@foreach(['Baik', 'Rusak', 'Pemeliharaan'] as $k)<option @selected($v('kondisi', 'Baik') === $k)>{{ $k }}</option>@endforeach</select></div>
    <div class="col-md-4"><label class="form-label" for="fStatus">Status</label><select class="form-select" id="fStatus">@foreach(['Aktif', 'Tidak Aktif'] as $s)<option @selected($v('status', 'Aktif') === $s)>{{ $s }}</option>@endforeach</select></div>
    <div class="col-md-4"><label class="form-label" for="fMaks">Waktu maksimal peminjaman</label><select class="form-select" id="fMaks">@foreach(['1 Hari', '2 Hari', '3 Hari', '1 Minggu'] as $m)<option @selected($v('maks', '1 Hari') === $m)>{{ $m }}</option>@endforeach</select></div>
    <div class="col-12"><label class="form-label" for="fJadwal">Jadwal tersedia</label><input class="form-control" id="fJadwal" maxlength="60" placeholder="Contoh: Senin - Jumat" value="{{ $v('jadwal') }}"></div>
    <div class="col-12"><label class="form-label" for="fDesk">Deskripsi</label><textarea class="form-control" id="fDesk" rows="3" maxlength="500">{{ $v('deskripsi') }}</textarea></div>
    <div class="col-12">
      <label class="form-label" for="fFoto">Foto fasilitas</label>
      <div class="d-flex align-items-center gap-3">
        <img id="fotoPreview" src="{{ $edit ? asset('img/' . $f['img']) : asset('img/gedung.svg') }}" alt="Pratinjau foto" style="width:120px;height:78px;object-fit:cover;border-radius:10px;border:1px solid var(--line)">
        <div class="flex-grow-1"><input type="file" class="form-control" id="fFoto" accept="image/*" data-preview="#fotoPreview"><div class="form-text">JPG/PNG, maksimal 2 MB.</div></div>
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-end gap-2 mt-4">
    <a class="btn btn-light" href="{{ route('admin.facilities') }}">Batal</a>
    <button class="btn btn-primary" type="submit">{{ $edit ? 'Simpan Perubahan' : 'Simpan Fasilitas' }}</button>
  </div>
</form>
@endsection
