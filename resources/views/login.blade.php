<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Masuk · FASLINK</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="{{ asset('css/faslink.css') }}" rel="stylesheet">
</head>
<body>
<div class="container min-vh-100 d-flex align-items-center justify-content-center py-4">
  <div class="card-soft p-4 p-md-5" style="max-width:440px;width:100%">
    <div class="text-center mb-4">
      <div class="mx-auto mb-3 d-grid" style="width:56px;height:56px;border-radius:16px;background:var(--navy);color:#fff;place-items:center;font-size:30px"><i class="bi bi-buildings"></i></div>
      <h2 class="fw-bold" style="color:var(--navy-dark)">FASLINK</h2>
      <p class="muted mb-0">Masuk untuk meminjam fasilitas kampus.</p>
    </div>
    <form id="loginForm" class="needs-validation" novalidate data-user="{{ route('user.dashboard') }}" data-admin="{{ route('admin.dashboard') }}">
      <div class="filter-pills mb-3 justify-content-center">
        <label class="m-0"><input class="btn-check" type="radio" name="role" value="user" checked><span class="btn btn-outline-primary btn-sm">Mahasiswa</span></label>
        <label class="m-0"><input class="btn-check" type="radio" name="role" value="admin"><span class="btn btn-outline-primary btn-sm">Admin Sarpras</span></label>
      </div>
      <label class="form-label" for="ident">Email / NIM</label>
      <input class="form-control mb-3" id="ident" required placeholder="Masukkan email atau NIM" autocomplete="username">
      <label class="form-label" for="pw">Password</label>
      <input type="password" class="form-control mb-4" id="pw" required minlength="6" placeholder="Masukkan password" autocomplete="current-password">
      <button type="submit" class="btn btn-primary w-100">Masuk</button>
      <p class="muted small text-center mt-3 mb-0">Mode demo: isi bebas, belum terhubung ke autentikasi.</p>
    </form>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/faslink.js') }}"></script>
</body>
</html>
