<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $__env->yieldContent('title', 'FASLINK'); ?> · FASLINK</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="<?php echo e(asset('css/faslink.css')); ?>" rel="stylesheet">
</head>
<body>
<div class="app-shell">
  <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <main class="main-area">
    <header class="topbar">
      <button class="btn btn-light d-lg-none" id="sidebarToggle" aria-label="Buka menu"><i class="bi bi-list"></i></button>
      <div class="topbar-title"><span class="eyebrow">SISTEM INFORMASI FASILITAS KAMPUS</span><strong><?php echo $__env->yieldContent('heading', 'Dashboard'); ?></strong></div>
      <div class="topbar-actions"><button class="icon-button" title="Notifikasi"><i class="bi bi-bell"></i><span class="notification-dot"></span></button><div class="profile-chip"><span class="avatar"><?php echo e(strtoupper(substr($demoName ?? 'B',0,1))); ?></span><span><b><?php echo e($demoName ?? 'Budi Santoso'); ?></b><small><?php echo e(($role ?? 'user') === 'admin' ? 'Admin Sarpras' : 'Mahasiswa'); ?></small></span></div></div>
    </header>
    <section class="page-content"><?php echo $__env->yieldContent('content'); ?></section>
    <footer class="footer-note">© <?php echo e(date('Y')); ?> FASLINK · Sistem Peminjaman Fasilitas Kampus</footer>
  </main>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo e(asset('js/faslink.js')); ?>"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body></html>
<?php /**PATH D:\CobaTerus\hasilKerja\faslink_work\resources\views/layouts/app.blade.php ENDPATH**/ ?>