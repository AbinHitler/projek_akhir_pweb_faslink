{{-- Pengaturan akun (dipakai mahasiswa & admin). Variabel: $me, $idLabel, $idValue --}}
<div class="settings-grid">
  <div class="nav nav-pills flex-column settings-nav" role="tablist">
    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tabProfil" type="button" role="tab">Profil</button>
    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tabKeamanan" type="button" role="tab">Keamanan</button>
    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tabNotif" type="button" role="tab">Notifikasi</button>
  </div>
  <div class="tab-content">
    <div class="tab-pane fade show active" id="tabProfil" role="tabpanel">
      <form class="card-soft demo-form" novalidate data-success="Perubahan profil tersimpan (simulasi).">
        <h3>Informasi Profil</h3>
        <div class="profile-head">
          <span class="avatar xl"><img id="avatarPreview" src="{{ asset('img/avatar.svg') }}" alt="Foto profil"></span>
          <div><h4>{{ $me['nama'] }}</h4><label class="btn btn-outline-primary btn-sm mt-1 mb-0">Ubah Foto<input type="file" hidden accept="image/*" data-preview="#avatarPreview"></label></div>
        </div>
        <div class="row g-3">
          <div class="col-md-6"><label class="form-label" for="pNama">Nama lengkap <span class="req">*</span></label><input class="form-control" id="pNama" required value="{{ $me['nama'] }}"><div class="invalid-feedback">Nama wajib diisi.</div></div>
          <div class="col-md-6"><label class="form-label" for="pId">{{ $idLabel }}</label><input class="form-control" id="pId" value="{{ $idValue }}" disabled></div>
          <div class="col-md-6"><label class="form-label" for="pEmail">Email <span class="req">*</span></label><input type="email" class="form-control" id="pEmail" required value="{{ $me['email'] }}"><div class="invalid-feedback">Masukkan email yang valid.</div></div>
          <div class="col-md-6"><label class="form-label" for="pTelp">Nomor telepon</label><input class="form-control" id="pTelp" inputmode="tel" pattern="08[0-9]{8,11}" value="{{ $me['telp'] }}" placeholder="08xxxxxxxxxx"><div class="invalid-feedback">Gunakan nomor HP yang diawali 08 (10-13 digit).</div></div>
        </div>
        <div class="text-end mt-4"><button class="btn btn-primary" type="submit">Simpan Perubahan</button></div>
      </form>
    </div>
    <div class="tab-pane fade" id="tabKeamanan" role="tabpanel">
      <form class="card-soft demo-form" novalidate data-validate="validatePassword" data-success="Password berhasil diubah (simulasi).">
        <h3>Ubah Password</h3>
        <div class="row g-3">
          <div class="col-md-6"><label class="form-label" for="pwLama">Password saat ini <span class="req">*</span></label><input type="password" class="form-control" id="pwLama" name="password_lama" required autocomplete="current-password"><div class="invalid-feedback">Wajib diisi.</div></div>
          <div class="col-md-6"></div>
          <div class="col-md-6"><label class="form-label" for="pwBaru">Password baru <span class="req">*</span></label><input type="password" class="form-control" id="pwBaru" name="password_baru" required minlength="8" autocomplete="new-password"><div class="invalid-feedback">Minimal 8 karakter.</div></div>
          <div class="col-md-6"><label class="form-label" for="pwKonf">Konfirmasi password baru <span class="req">*</span></label><input type="password" class="form-control" id="pwKonf" name="password_konfirmasi" required autocomplete="new-password"><div class="invalid-feedback">Konfirmasi password tidak sama.</div></div>
        </div>
        <div class="text-end mt-4"><button class="btn btn-primary" type="submit">Simpan Password</button></div>
      </form>
    </div>
    <div class="tab-pane fade" id="tabNotif" role="tabpanel">
      <form class="card-soft demo-form" data-success="Preferensi notifikasi tersimpan (simulasi).">
        <h3>Preferensi Notifikasi</h3>
        @foreach([['Email status pengajuan','Kirim email saat status pengajuan berubah.',true],['Pengingat jadwal peminjaman','Ingatkan 1 hari sebelum jadwal peminjaman.',true],['Pengingat pengembalian','Ingatkan saat batas pengembalian mendekat.',false]] as $k => $n)
          <div class="list-row"><div class="grow"><b>{{ $n[0] }}</b><small>{{ $n[1] }}</small></div><div class="form-check form-switch m-0"><input class="form-check-input" type="checkbox" role="switch" id="n{{ $k }}" aria-label="{{ $n[0] }}" @checked($n[2])></div></div>
        @endforeach
        <div class="text-end mt-4"><button class="btn btn-primary" type="submit">Simpan Preferensi</button></div>
      </form>
    </div>
  </div>
</div>
