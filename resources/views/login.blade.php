<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Admin · FASLINK</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="{{ asset('css/faslink.css') }}" rel="stylesheet">
</head>
<body>
  <div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="panel p-4 p-md-5" style="max-width: 420px; width: 100%;">

      <div class="text-center mb-4">
        <div class="brand-mark mx-auto mb-3" style="background: var(--navy); color: white;">
          <i class="bi bi-shield-lock"></i>
        </div>
        <h2 style="font-size: 20px; font-weight: 700; color: var(--navy);">FASLINK</h2>
        <p class="muted" style="margin-top: 4px;">Masuk sebagai admin untuk mengelola fasilitas kampus.</p>
      </div>

      <form method="POST" action="{{ route('login.store') }}">
        @csrf

        @if(session('error'))
          <div class="alert alert-warning py-2">{{ session('error') }}</div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
        @endif

        <div class="mb-3">
          <label class="form-label" for="email">Email Admin</label>
          <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            class="form-control"
            placeholder="Masukkan email admin"
            required
            autofocus>
        </div>

        <div class="mb-4">
          <label class="form-label" for="password">Password</label>
          <input
            id="password"
            type="password"
            name="password"
            class="form-control"
            placeholder="Masukkan password"
            required>
        </div>

        <button type="submit" class="btn btn-primary w-100">
          <i class="bi bi-box-arrow-in-right me-2"></i>Masuk sebagai Admin
        </button>

        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary w-100 mt-2">
          <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
        </a>
      </form>

    </div>
  </div>
</body>
</html>