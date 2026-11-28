@php
    $isAdmin = request()->routeIs('admin.*');
    // [route, label, ikon, pola route yang membuat menu aktif]
    $menu = $isAdmin ? [
        ['admin.dashboard',    'Dashboard',              'bi-house-door',             ['admin.dashboard']],
        ['admin.facilities',   'Kelola Fasilitas',       'bi-buildings',              ['admin.facilities*']],
        ['admin.loans',        'Daftar Pengajuan',       'bi-inbox',                  ['admin.loans']],
        ['admin.verification', 'Verifikasi Pengajuan',   'bi-clipboard-check',        ['admin.verification']],
        ['admin.approvals',    'Riwayat Persetujuan',    'bi-journal-check',          ['admin.approvals']],
        ['admin.handover',     'Serah Terima',           'bi-box-arrow-up-right',     ['admin.handover']],
        ['admin.returns',      'Pengembalian',           'bi-box-arrow-in-down-left', ['admin.returns']],
        ['admin.damage',       'Kerusakan / Kehilangan', 'bi-exclamation-triangle',   ['admin.damage']],
        ['admin.reports',      'Laporan',                'bi-bar-chart-line',         ['admin.reports']],
        ['admin.users',        'Kelola Pengguna',        'bi-people',                 ['admin.users']],
        ['admin.profile',      'Pengaturan',             'bi-gear',                   ['admin.profile']],
    ] : [
        ['user.dashboard', 'Dashboard',          'bi-house-door',        ['user.dashboard']],
        ['user.catalog',   'Katalog Fasilitas',  'bi-search',            ['user.catalog', 'user.facility.*']],
        ['user.loans',     'Pengajuan Saya',     'bi-file-earmark-text', ['user.loans', 'user.loan.*']],
        ['user.history',   'Riwayat Peminjaman', 'bi-clock-history',     ['user.history']],
        ['user.profile',   'Pengaturan',         'bi-gear',              ['user.profile']],
    ];
@endphp
<aside class="sidebar" id="appSidebar" aria-label="Menu utama">
  <a class="brand" href="{{ route($isAdmin ? 'admin.dashboard' : 'user.dashboard') }}"><i class="bi bi-buildings"></i><span>FASLINK</span></a>
  <nav class="side-nav">
    @foreach($menu as $m)
      @php $active = request()->routeIs(...$m[3]); @endphp
      <a href="{{ route($m[0]) }}" class="{{ $active ? 'active' : '' }}" @if($active) aria-current="page" @endif><i class="bi {{ $m[2] }}"></i>{{ $m[1] }}</a>
    @endforeach
  </nav>
  <div class="sidebar-bottom">
    <form method="post" action="{{ route('logout') }}">@csrf<button type="submit"><i class="bi bi-box-arrow-right"></i>Keluar</button></form>
  </div>
</aside>
