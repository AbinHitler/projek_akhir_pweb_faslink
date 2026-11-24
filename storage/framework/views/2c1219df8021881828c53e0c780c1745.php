<?php $__env->startSection('title', $facility->exists ? 'Edit Fasilitas' : 'Tambah Fasilitas'); ?>
<?php $__env->startSection('heading', $facility->exists ? 'Edit Fasilitas' : 'Tambah Fasilitas'); ?>
<?php $__env->startSection('content'); ?>
<a class="back-link" href="<?php echo e(route('admin.facilities')); ?>"><i class="bi bi-arrow-left"></i> Kembali ke manajemen fasilitas</a>
<div class="panel mt-3">
<form method="POST" action="<?php echo e($facility->exists ? route('admin.facilities.update',$facility) : route('admin.facilities.store')); ?>">
    <?php echo csrf_field(); ?> <?php if($facility->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
    <?php if($errors->any()): ?> <div class="alert alert-danger">Periksa kembali data: <?php echo e($errors->first()); ?></div> <?php endif; ?>
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Jenis fasilitas *</label><select name="type" id="facilityType" class="form-select" required><option value="">Pilih jenis</option><?php $__currentLoopData = ['gedung'=>'Gedung','ruangan'=>'Ruangan','barang'=>'Barang']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($key); ?>" <?php if(old('type',$facility->type)===$key): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div class="col-md-6"><label class="form-label">Nama fasilitas *</label><input name="name" value="<?php echo e(old('name',$facility->name)); ?>" class="form-control" required maxlength="150" placeholder="Masukkan nama fasilitas"></div>
        <div class="col-md-6" id="parentField"><label class="form-label">Gedung induk *</label><select name="parent_id" class="form-select"><option value="">Pilih gedung</option><?php $__currentLoopData = $buildings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $building): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($building->id); ?>" <?php if((string)old('parent_id',$facility->parent_id)===(string)$building->id): echo 'selected'; endif; ?>><?php echo e($building->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div class="col-md-6" id="locationField"><label class="form-label">Lokasi gedung</label><input name="location" value="<?php echo e(old('location',$facility->location)); ?>" class="form-control" placeholder="Contoh: Area Fakultas Ilmu Komputer"></div>
        <div class="col-md-6" id="categoryField"><label class="form-label">Kategori barang</label><select name="category_id" class="form-select"><option value="">Pilih kategori (opsional)</option><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($category->id); ?>" <?php if((string)old('category_id',$facility->category_id)===(string)$category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><small class="text-muted">Kategori dapat diisi setelah data kategori tersedia.</small></div>
        <div class="col-md-6" id="capacityField"><label class="form-label">Kapasitas ruangan (orang)</label><input type="number" min="1" name="capacity" value="<?php echo e(old('capacity',$facility->capacity)); ?>" class="form-control"></div>
        <div class="col-md-6" id="stockField"><label class="form-label">Jumlah stok total</label><input type="number" min="0" name="stock_total" value="<?php echo e(old('stock_total',$facility->stock_total ?? 0)); ?>" class="form-control"></div>
        <div class="col-md-6" id="damagedField"><label class="form-label">Jumlah stok rusak</label><input type="number" min="0" name="stock_damaged" value="<?php echo e(old('stock_damaged',$facility->stock_damaged ?? 0)); ?>" class="form-control"><small class="text-muted">Stok tersedia = stok total dikurangi stok rusak.</small></div>
        <div class="col-md-6"><label class="form-label">Kondisi fasilitas *</label><select name="condition" class="form-select" required><?php $__currentLoopData = ['baik'=>'Baik','rusak'=>'Rusak','pemeliharaan'=>'Pemeliharaan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($key); ?>" <?php if(old('condition',$facility->condition ?: 'baik')===$key): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div class="col-md-6"><label class="form-label">Status fasilitas *</label><select name="status" class="form-select" required><option value="aktif" <?php if(old('status',$facility->status ?: 'aktif')==='aktif'): echo 'selected'; endif; ?>>Aktif</option><option value="tidak_aktif" <?php if(old('status',$facility->status)==='tidak_aktif'): echo 'selected'; endif; ?>>Tidak Aktif</option></select></div>
        <div class="col-md-6"><label class="form-label">Penanggung jawab</label><input name="responsible" value="<?php echo e(old('responsible',$facility->responsible)); ?>" class="form-control" placeholder="Nama penanggung jawab (opsional)"></div>
        <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" rows="3" class="form-control" placeholder="Keterangan tambahan"><?php echo e(old('description',$facility->description)); ?></textarea></div>
    </div>
    <div class="d-flex justify-content-end gap-2 mt-4"><a href="<?php echo e(route('admin.facilities')); ?>" class="btn btn-light">Batal</a><button class="btn btn-primary"><?php echo e($facility->exists ? 'Simpan Perubahan' : 'Simpan Fasilitas'); ?></button></div>
</form>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
(function(){
 const type=document.getElementById('facilityType');
 function toggle(){const v=type.value;document.getElementById('parentField').hidden=v!=='ruangan';document.getElementById('locationField').hidden=v!=='gedung';document.getElementById('categoryField').hidden=v!=='barang';document.getElementById('capacityField').hidden=v!=='ruangan';document.getElementById('stockField').hidden=v!=='barang';document.getElementById('damagedField').hidden=v!=='barang';}
 type.addEventListener('change',toggle);toggle();
})();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CobaTerus\hasilKerja\faslink_work\resources\views/admin/facilities/form.blade.php ENDPATH**/ ?>