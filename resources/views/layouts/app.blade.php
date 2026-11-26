<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'FASLINK') · FASLINK</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="{{ asset('css/faslink.css') }}" rel="stylesheet">
</head>
<body>
<div class="app-shell">
  @include('partials.sidebar')
  <main class="main-area">
    <header class="topbar">
      <button class="btn btn-light d-lg-none" id="sidebarToggle" aria-label="Buka menu">
        <i class="bi bi-list"></i>
      </button>
      <div class="topbar-title">
        <strong>@yield('heading', 'Dashboard')</strong>
      </div>
      <div class="topbar-actions">
        <div class="profile-chip">
          <span class="avatar">{{ strtoupper(substr($demoName ?? auth()->user()->name ?? 'U', 0, 1)) }}</span>
          <span>
            <b>{{ $demoName ?? auth()->user()->name ?? 'Pengguna' }}</b>
            <small>{{ ($role ?? 'user') === 'admin' ? 'Admin Sarpras' : 'Mahasiswa' }}</small>
          </span>
        </div>
      </div>
    </header>
    <section class="page-content">@yield('content')</section>
  </main>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/faslink.js') }}"></script>
@stack('scripts')
</body>
</html>