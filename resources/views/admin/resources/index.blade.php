@extends('layouts.app')

@section('title', 'Manajemen Fasilitas')
@section('heading', 'Manajemen Fasilitas')

@section('content')

<div class="page-intro">
  <div>
    <h1>Manajemen Fasilitas</h1>
    <p class="muted">Pengelolaan gedung, ruangan, dan barang FASLINK.</p>
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

<div class="panel table-responsive">
  <table class="table align-middle">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Jenis</th>
        <th>Lokasi / Gedung</th>
        <th>Stok / Kapasitas</th>
        <th>Kondisi</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($facilities as $facility)
        <tr>
          <td>{{ $loop->iteration + ($facilities->currentPage() - 1) * 10 }}</td>
          <td><strong>{{ $facility->name }}</strong></td>
          <td>{{ ucfirst($facility->type) }}</td>
          <td>{{ $facility->parent?->name ?? $facility->location ?? '-' }}</td>
          <td>
            @if($facility->type === 'barang')
              {{ $facility->stock_total }}
              <small class="text-muted">(Rusak: {{ $facility->stock_damaged }})</small>
            @elseif($facility->type === 'ruangan')
              {{ $facility->capacity }} orang
            @else
              -
            @endif
          </td>
          <td>{{ ucfirst($facility->condition) }}</td>
          <td>{{ ucfirst(str_replace('_', ' ', $facility->status)) }}</td>
          <td>
            <a class="btn btn-sm btn-outline-primary me-1"
               href="{{ route('admin.facilities.edit', $facility->id) }}">
              Edit
            </a>
            <form action="{{ route('admin.facilities.destroy', $facility->id) }}"
                  method="POST"
                  style="display: inline;"
                  onsubmit="return confirm('Yakin ingin menghapus fasilitas ini?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="8" class="text-center text-muted py-4">Belum ada data fasilitas.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <div class="p-3">
    {{ $facilities->links() }}
  </div>
</div>

@endsection