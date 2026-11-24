@php($isAdmin = ($role ?? 'user') === 'admin')
<aside class="sidebar" id="appSidebar">
  <a class="brand" href="{{ $isAdmin ? route('admin.dashboard') : route('user.dashboard') }}"><span class="brand-mark"><i class="bi bi-buildings"></i></span><span>FASLINK<small>Fasilitas Link</small></span></a>
  <div class="sidebar-caption">MENU UTAMA</div>
  @if(!$isAdmin)
    <nav class="side-nav">
      <a class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}"><i class="bi bi-grid"></i>Dashboard</a>
      <a class="{{ request()->routeIs('user.catalog*','user.facility*') ? 'active' : '' }}" href="{{ route('user.catalog') }}"><i class="bi bi-search"></i>Katalog Fasilitas</a>
      <a class="{{ request()->routeIs('user.loans*') ? 'active' : '' }}" href="{{ route('user.loans') }}"><i class="bi bi-file-earmark-text"></i>Pengajuan Saya</a>
      <a class="{{ request()->routeIs('user.history') ? 'active' : '' }}" href="{{ route('user.history') }}"><i class="bi bi-clock-history"></i>Riwayat Peminjaman</a>
      <a class="{{ request()->routeIs('user.profile') ? 'active' : '' }}" href="{{ route('user.profile') }}"><i class="bi bi-gear"></i>Profil & Pengaturan</a>
    </nav>
  @else
    <nav class="side-nav">
      <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid"></i>Dashboard</a>
      <a class="{{ request()->routeIs('admin.facilities*') ? 'active' : '' }}" href="{{ route('admin.facilities') }}"><i class="bi bi-building"></i>Manajemen Fasilitas</a>
    </nav>
  @endif
  <div class="sidebar-bottom"><a href="{{ $isAdmin ? route('admin.facilities') : '#' }}"><i class="bi bi-box-arrow-right"></i>{{ $isAdmin ? 'Kembali ke Manajemen Fasilitas' : 'Keluar (Demo)' }}</a><small>Versi prototype UI</small></div>
</aside>
