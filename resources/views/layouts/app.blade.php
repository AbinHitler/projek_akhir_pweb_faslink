@php
    $isAdmin = request()->routeIs('admin.*');
    $me = config($isAdmin ? 'faslink.admin' : 'faslink.user');
@endphp
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'FASLINK') · FASLINK</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="{{ asset('css/faslink.css') }}" rel="stylesheet">
</head>
<body>
<div class="app-shell">
  @include('partials.sidebar')
  <div class="sidebar-backdrop"></div>

  <main class="main-area">
    <header class="topbar">
      <button class="icon-btn d-lg-none" id="sidebarToggle" type="button" aria-label="Buka menu"><i class="bi bi-list fs-4"></i></button>
      <div class="topbar-left">
        @hasSection('back')
          @yield('back')
        @else
          <h1 class="page-title">@yield('heading', 'Dashboard')</h1>
          @hasSection('subheading')<p class="page-sub">@yield('subheading')</p>@endif
        @endif
      </div>
      <div class="topbar-right">
        <form class="topbar-search" method="get" action="{{ $isAdmin ? route('admin.facilities') : route('user.catalog') }}" role="search">
          <input type="search" name="q" placeholder="Cari fasilitas..." aria-label="Cari fasilitas">
          <button class="icon-btn" id="searchToggle" type="button" aria-label="Cari"><i class="bi bi-search"></i></button>
        </form>
        <div class="dropdown">
          <button class="profile-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menu akun">
            <span class="avatar"><img src="{{ asset('img/avatar.svg') }}" alt=""></span><i class="bi bi-caret-down-fill"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li class="px-3 py-2"><b>{{ $me['nama'] }}</b><small>{{ $me['prodi'] }}</small></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route($isAdmin ? 'admin.profile' : 'user.profile') }}"><i class="bi bi-gear me-2"></i>Pengaturan Akun</a></li>
            <li><form method="post" action="{{ route('logout') }}">@csrf<button class="dropdown-item" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Keluar</button></form></li>
          </ul>
        </div>
      </div>
    </header>

    <section class="page-content">@yield('content')</section>
  </main>
</div>

{{-- Modal konfirmasi umum (dipakai tombol dengan atribut data-confirm) --}}
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center p-4">
        <p class="mb-4 fw-semibold" id="confirmText">Lanjutkan aksi ini?</p>
        <div class="d-flex gap-2 justify-content-center">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="confirmOk">Ya, lanjutkan</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="toast-container position-fixed top-0 end-0 p-3" id="toastArea"></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/faslink.js') }}"></script>
@stack('scripts')
</body>
</html>
