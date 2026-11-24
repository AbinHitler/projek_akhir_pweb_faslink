
@extends('layouts.app')

@section('title', 'Manajemen Fasilitas')
@section('heading', 'Manajemen Fasilitas')

@section('content')

<div class="page-intro">
    <div>
        <h1>Manajemen Fasilitas</h1>
        <p class="muted">Kelola data gedung, ruangan, dan barang inventaris kampus.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('admin.facilities.create') }}">
        <i class="bi bi-plus-lg me-1"></i>Tambah Fasilitas
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div class="row g-3 mb-4">
    @foreach([
        ['Gedung', 'gedung', 'bi-buildings'],
        ['Ruangan', 'ruangan', 'bi-door-open'],
        ['Barang', 'barang', 'bi-box-seam']
    ] as $item)
        <div class="col-md-4">
            <div class="panel d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Total {{ $item[0] }}</small>
                    <h3 class="mb-0">{{ $counts[$item[1]] }}</h3>
                </div>
                <i class="bi {{ $item[2] }} fs-2 text-primary"></i>
            </div>
        </div>
    @endforeach
</div>

<div class="panel">
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-5">
            <input name="search" value="{{ request('search') }}"
                class="form-control" placeholder="Cari nama fasilitas...">
        </div>

        <div class="col-md-3">
            <select name="type" class="form-select">
                <option value="">Semua jenis</option>
                @foreach(['gedung'=>'Gedung','ruangan'=>'Ruangan','barang'=>'Barang'] as $key => $label)
                    <option value="{{ $key }}" @selected(request('type') === $key)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Semua status</option>
                <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                <option value="tidak_aktif" @selected(request('status') === 'tidak_aktif')>Tidak aktif</option>
            </select>
        </div>

        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-primary w-100">Filter</button>
            <a href="{{ route('admin.facilities') }}" class="btn btn-light">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Nama Fasilitas</th>
                    <th>Jenis</th>
                    <th>Lokasi / Gedung Induk</th>
                    <th>Kapasitas / Stok</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($facilities as $facility)
                    <tr>
                        <td>
                            <strong>{{ $facility->name }}</strong>
                            @if($facility->category)
                                <div class="small text-muted">{{ $facility->category->name }}</div>
                            @endif
                        </td>

                        <td>{{ ucfirst($facility->type) }}</td>

                        <td>
                            {{ $facility->type === 'ruangan'
                                ? ($facility->parent?->name ?? '-')
                                : ($facility->location ?: '-') }}
                        </td>

                        <td>
                            @if($facility->type === 'ruangan')
                                {{ $facility->capacity }} orang
                            @elseif($facility->type === 'barang')
                                <div>{{ $facility->available_stock }} tersedia</div>
                                <small class="text-muted">
                                    Total: {{ $facility->stock_total }}
                                    - Rusak: {{ $facility->stock_damaged }}
                                </small>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            <span class="badge text-bg-{{ $facility->condition === 'baik' ? 'success' : ($facility->condition === 'rusak' ? 'danger' : 'warning') }}">
                                {{ ucfirst($facility->condition) }}
                            </span>
                        </td>

                        <td>
                            <span class="badge text-bg-{{ $facility->status === 'aktif' ? 'primary' : 'secondary' }}">
                                {{ $facility->status === 'aktif' ? 'Aktif' : 'Tidak aktif' }}
                            </span>
                        </td>

                        <td>
                            <div class="d-flex gap-2">
                                <a class="btn btn-sm btn-outline-primary"
                                    href="{{ route('admin.facilities.edit', $facility) }}">
                                    Edit
                                </a>

                                <form method="POST"
                                    action="{{ route('admin.facilities.destroy', $facility) }}"
                                    onsubmit="return confirm('Hapus fasilitas ini dari daftar aktif?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada data fasilitas. Klik Tambah Fasilitas untuk mulai mengisi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $facilities->links() }}
</div>

@endsection
