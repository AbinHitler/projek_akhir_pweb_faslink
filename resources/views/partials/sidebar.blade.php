@php($isAdmin = ($role ?? 'user') === 'admin')

<aside class="sidebar" id="appSidebar">
  <a class="brand" href="{{ $isAdmin ? route('admin.dashboard') : route('user.dashboard') }}">
    <span class="brand-mark"><i class="bi bi-buildings"></i></span>
    <span>FASLINK<small>Fasilitas Kampus</small></span>
  </a>

  <div class="sidebar-caption">MENU</div>

  @if(!$isAdmin)
    <nav class="side-nav">
      <a class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}"><i class="bi bi-house"></i>Dashboard</a>
      <a class="{{ request()->routeIs('user.catalog*','user.facility*') ? 'active' : '' }}" href="{{ route('user.catalog') }}"><i class="bi bi-building"></i>Katalog Fasilitas</a>
      <a class="{{ request()->routeIs('user.loans*','user.loan.*') ? 'active' : '' }}" href="{{ route('user.loans') }}"><i class="bi bi-file-text"></i>Pengajuan Saya</a>
    </nav>
  @else
    <nav class="side-nav">
      <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-house"></i>Dashboard</a>
      <a class="{{ request()->routeIs('admin.facilities*') ? 'active' : '' }}" href="{{ route('admin.facilities') }}"><i class="bi bi-building"></i>Manajemen Fasilitas</a>
      <a class="{{ request()->routeIs('admin.loans','admin.loan.detail') ? 'active' : '' }}" href="{{ route('admin.loans') }}"><i class="bi bi-inbox"></i>Daftar Pengajuan</a>
      <a class="{{ request()->routeIs('admin.verification*') ? 'active' : '' }}" href="{{ route('admin.verification') }}"><i class="bi bi-clipboard-check"></i>Verifikasi</a>
      <a class="{{ request()->routeIs('admin.approvals') ? 'active' : '' }}" href="{{ route('admin.approvals') }}"><i class="bi bi-journal-check"></i>Riwayat Persetujuan</a>
      <a class="{{ request()->routeIs('admin.handover','admin.returns') ? 'active' : '' }}" href="{{ route('admin.handover') }}"><i class="bi bi-arrow-left-right"></i>Serah Terima & Pengembalian</a>
      <a class="{{ request()->routeIs('admin.damage') ? 'active' : '' }}" href="{{ route('admin.damage') }}"><i class="bi bi-exclamation-circle"></i>Kerusakan / Kehilangan</a>
    </nav>
  @endif

  <div class="sidebar-bottom">
    @if($isAdmin)
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">
          <i class="bi bi-box-arrow-right"></i>Logout
        </button>
      </form>
    @else
      <a href="{{ route('login') }}">
        <i class="bi bi-shield-lock"></i>Login Admin
      </a>
    @endif
  </div>
</aside>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>