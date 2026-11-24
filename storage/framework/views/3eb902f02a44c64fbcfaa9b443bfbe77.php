<?php $__env->startSection('title', 'Manajemen Fasilitas'); ?>
<?php $__env->startSection('heading', 'Manajemen Fasilitas'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-intro">
    <div><h1>Manajemen Fasilitas</h1><p class="muted">Kelola data gedung, ruangan, dan barang inventaris kampus.</p></div>
    <a class="btn btn-primary" href="<?php echo e(route('admin.facilities.create')); ?>"><i class="bi bi-plus-lg me-1"></i>Tambah Fasilitas</a>
</div>
<?php if(session('success')): ?> <div class="alert alert-success"><?php echo e(session('success')); ?></div> <?php endif; ?>
<?php if(session('error')): ?> <div class="alert alert-danger"><?php echo e(session('error')); ?></div> <?php endif; ?>
<?php if($errors->any()): ?> <div class="alert alert-danger"><?php echo e($errors->first()); ?></div> <?php endif; ?>
<div class="row g-3 mb-4">
    <?php $__currentLoopData = [['Gedung','gedung','bi-buildings'],['Ruangan','ruangan','bi-door-open'],['Barang','barang','bi-box-seam']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-4"><div class="panel d-flex justify-content-between align-items-center"><div><small class="text-muted">Total <?php echo e($item[0]); ?></small><h3 class="mb-0"><?php echo e($counts[$item[1]]); ?></h3></div><i class="bi <?php echo e($item[2]); ?> fs-2 text-primary"></i></div></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<div class="panel">
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-5"><input name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="Cari nama fasilitas..."></div>
        <div class="col-md-3"><select name="type" class="form-select"><option value="">Semua jenis</option><?php $__currentLoopData = ['gedung'=>'Gedung','ruangan'=>'Ruangan','barang'=>'Barang']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($key); ?>" <?php if(request('type')===$key): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div class="col-md-2"><select name="status" class="form-select"><option value="">Semua status</option><option value="aktif" <?php if(request('status')==='aktif'): echo 'selected'; endif; ?>>Aktif</option><option value="tidak_aktif" <?php if(request('status')==='tidak_aktif'): echo 'selected'; endif; ?>>Tidak aktif</option></select></div>
        <div class="col-md-2 d-flex gap-2"><button class="btn btn-primary w-100">Filter</button><a href="<?php echo e(route('admin.facilities')); ?>" class="btn btn-light">Reset</a></div>
    </form>
    <div class="table-responsive"><table class="table align-middle">
        <thead><tr><th>Nama Fasilitas</th><th>Jenis</th><th>Lokasi / Gedung Induk</th><th>Kapasitas / Stok</th><th>Kondisi</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><strong><?php echo e($facility->name); ?></strong><?php if($facility->category): ?><div class="small text-muted"><?php echo e($facility->category->name); ?></div><?php endif; ?></td>
            <td><?php echo e(ucfirst($facility->type)); ?></td>
            <td><?php echo e($facility->type === 'ruangan' ? ($facility->parent?->name ?? '-') : ($facility->location ?: '-')); ?></td>
            <td><?php if($facility->type==='ruangan'): ?> <?php echo e($facility->capacity); ?> orang <?php elseif($facility->type==='barang'): ?> <div><?php echo e($facility->available_stock); ?> tersedia</div><small class="text-muted">Total: <?php echo e($facility->stock_total); ?> · Rusak: <?php echo e($facility->stock_damaged); ?></small> <?php else: ?> - <?php endif; ?></td>
            <td><span class="badge text-bg-<?php echo e($facility->condition==='baik'?'success':($facility->condition==='rusak'?'danger':'warning')); ?>"><?php echo e(ucfirst($facility->condition)); ?></span></td>
            <td><span class="badge text-bg-<?php echo e($facility->status==='aktif'?'primary':'secondary'); ?>"><?php echo e($facility->status==='aktif'?'Aktif':'Tidak aktif'); ?></span></td>
            <td><div class="d-flex gap-2"><a class="btn btn-sm btn-outline-primary" href="<?php echo e(route('admin.facilities.edit',$facility)); ?>">Edit</a><form method="POST" action="<?php echo e(route('admin.facilities.destroy',$facility)); ?>" onsubmit="return confirm('Hapus fasilitas ini dari daftar aktif?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn btn-sm btn-outline-danger">Hapus</button></form></div></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data fasilitas. Klik Tambah Fasilitas untuk mulai mengisi.</td></tr> <?php endif; ?>
        </tbody>
    </table></div>
    <?php echo e($facilities->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CobaTerus\hasilKerja\faslink_work\resources\views/admin/facilities/index.blade.php ENDPATH**/ ?>