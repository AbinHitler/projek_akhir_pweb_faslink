
@extends('layouts.app')

@section('title', $facility->exists ? 'Edit Fasilitas' : 'Tambah Fasilitas')
@section('heading', $facility->exists ? 'Edit Fasilitas' : 'Tambah Fasilitas')

@section('content')

<a class="back-link" href="{{ route('admin.facilities') }}">
    <i class="bi bi-arrow-left"></i> Kembali ke manajemen fasilitas
</a>

<div class="panel mt-3">
    <form method="POST" action="{{ $facility->exists ? route('admin.facilities.update', $facility) : route('admin.facilities.store') }}">
        @csrf

        @if($facility->exists)
            @method('PUT')
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                Periksa kembali data: {{ $errors->first() }}
            </div>
        @endif

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Jenis fasilitas *</label>
                <select name="type" id="facilityType" class="form-select" required>
                    <option value="">Pilih jenis</option>
                    @foreach(['gedung'=>'Gedung','ruangan'=>'Ruangan','barang'=>'Barang'] as $key => $label)
                        <option value="{{ $key }}" @selected(old('type', $facility->type) === $key)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Nama fasilitas *</label>
                <input name="name" value="{{ old('name', $facility->name) }}"
                    class="form-control" required maxlength="150"
                    placeholder="Masukkan nama fasilitas">
            </div>

            <div class="col-md-6" id="parentField">
                <label class="form-label">Gedung induk *</label>
                <select name="parent_id" class="form-select">
                    <option value="">Pilih gedung</option>
                    @foreach($buildings as $building)
                        <option value="{{ $building->id }}"
                            @selected((string)old('parent_id', $facility->parent_id) === (string)$building->id)>
                            {{ $building->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6" id="locationField">
                <label class="form-label">Lokasi gedung</label>
                <input name="location" value="{{ old('location', $facility->location) }}"
                    class="form-control" placeholder="Contoh: Area Fakultas Ilmu Komputer">
            </div>

            <div class="col-md-6" id="categoryField">
                <label class="form-label">Kategori barang</label>
                <select name="category_id" class="form-select">
                    <option value="">Pilih kategori (opsional)</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @selected((string)old('category_id', $facility->category_id) === (string)$category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">
                    Kategori dapat diisi setelah data kategori tersedia.
                </small>
            </div>

            <div class="col-md-6" id="capacityField">
                <label class="form-label">Kapasitas ruangan (orang)</label>
                <input type="number" min="1" name="capacity"
                    value="{{ old('capacity', $facility->capacity) }}" class="form-control">
            </div>

            <div class="col-md-6" id="stockField">
                <label class="form-label">Jumlah stok total</label>
                <input type="number" min="0" name="stock_total"
                    value="{{ old('stock_total', $facility->stock_total ?? 0) }}"
                    class="form-control">
            </div>

            <div class="col-md-6" id="damagedField">
                <label class="form-label">Jumlah stok rusak</label>
                <input type="number" min="0" name="stock_damaged"
                    value="{{ old('stock_damaged', $facility->stock_damaged ?? 0) }}"
                    class="form-control">
                <small class="text-muted">
                    Stok tersedia = stok total dikurangi stok rusak.
                </small>
            </div>

            <div class="col-md-6">
                <label class="form-label">Kondisi fasilitas *</label>
                <select name="condition" class="form-select" required>
                    @foreach(['baik'=>'Baik','rusak'=>'Rusak','pemeliharaan'=>'Pemeliharaan'] as $key => $label)
                        <option value="{{ $key }}"
                            @selected(old('condition', $facility->condition ?: 'baik') === $key)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Status fasilitas *</label>
                <select name="status" class="form-select" required>
                    <option value="aktif"
                        @selected(old('status', $facility->status ?: 'aktif') === 'aktif')>
                        Aktif
                    </option>
                    <option value="tidak_aktif"
                        @selected(old('status', $facility->status) === 'tidak_aktif')>
                        Tidak Aktif
                    </option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Penanggung jawab</label>
                <input name="responsible"
                    value="{{ old('responsible', $facility->responsible) }}"
                    class="form-control"
                    placeholder="Nama penanggung jawab (opsional)">
            </div>

            <div class="col-12">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" rows="3" class="form-control"
                    placeholder="Keterangan tambahan">{{ old('description', $facility->description) }}</textarea>
            </div>

        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.facilities') }}" class="btn btn-light">
                Batal
            </a>
            <button class="btn btn-primary">
                {{ $facility->exists ? 'Simpan Perubahan' : 'Simpan Fasilitas' }}
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const type = document.getElementById('facilityType');

    function toggle() {
        const v = type.value;

        document.getElementById('parentField').hidden = v !== 'ruangan';
        document.getElementById('locationField').hidden = v !== 'gedung';
        document.getElementById('categoryField').hidden = v !== 'barang';
        document.getElementById('capacityField').hidden = v !== 'ruangan';
        document.getElementById('stockField').hidden = v !== 'barang';
        document.getElementById('damagedField').hidden = v !== 'barang';
    }

    type.addEventListener('change', toggle);
    toggle();
})();
</script>
@endpush
