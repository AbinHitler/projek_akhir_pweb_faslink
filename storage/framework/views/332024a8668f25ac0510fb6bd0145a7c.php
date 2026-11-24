<?php ($isAdmin = ($role ?? 'user') === 'admin'); ?>
<aside class="sidebar" id="appSidebar">
  <a class="brand" href="<?php echo e($isAdmin ? route('admin.dashboard') : route('user.dashboard')); ?>"><span class="brand-mark"><i class="bi bi-buildings"></i></span><span>FASLINK<small>Fasilitas Link</small></span></a>
  <div class="sidebar-caption">MENU UTAMA</div>
  <?php if(!$isAdmin): ?>
    <nav class="side-nav">
      <a class="<?php echo e(request()->routeIs('user.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('user.dashboard')); ?>"><i class="bi bi-grid"></i>Dashboard</a>
      <a class="<?php echo e(request()->routeIs('user.catalog*','user.facility*') ? 'active' : ''); ?>" href="<?php echo e(route('user.catalog')); ?>"><i class="bi bi-search"></i>Katalog Fasilitas</a>
      <a class="<?php echo e(request()->routeIs('user.loans*') ? 'active' : ''); ?>" href="<?php echo e(route('user.loans')); ?>"><i class="bi bi-file-earmark-text"></i>Pengajuan Saya</a>
      <a class="<?php echo e(request()->routeIs('user.history') ? 'active' : ''); ?>" href="<?php echo e(route('user.history')); ?>"><i class="bi bi-clock-history"></i>Riwayat Peminjaman</a>
      <a class="<?php echo e(request()->routeIs('user.profile') ? 'active' : ''); ?>" href="<?php echo e(route('user.profile')); ?>"><i class="bi bi-gear"></i>Profil & Pengaturan</a>
    </nav>
  <?php else: ?>
    <nav class="side-nav">
      <a class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>"><i class="bi bi-grid"></i>Dashboard</a>
      <a class="<?php echo e(request()->routeIs('admin.facilities*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.facilities')); ?>"><i class="bi bi-building"></i>Manajemen Fasilitas</a>
    </nav>
  <?php endif; ?>
  <div class="sidebar-bottom"><a href="<?php echo e($isAdmin ? route('admin.facilities') : '#'); ?>"><i class="bi bi-box-arrow-right"></i><?php echo e($isAdmin ? 'Kembali ke Manajemen Fasilitas' : 'Keluar (Demo)'); ?></a><small>Versi prototype UI</small></div>
</aside>
<?php /**PATH D:\CobaTerus\hasilKerja\faslink_work\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>