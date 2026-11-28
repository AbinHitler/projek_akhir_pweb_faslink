@extends('layouts.app')
@section('title', 'Kelola Pengguna')
@section('heading', 'Kelola Pengguna')
@section('subheading', 'Data akun mahasiswa dan admin yang menggunakan FASLINK.')

@section('content')
<div data-filter-scope>
  <div class="filter-pills mb-3">
    <button type="button" class="active" data-filter-pill="all">Semua</button>
    <button type="button" data-filter-pill="Mahasiswa">Mahasiswa</button>
    <button type="button" data-filter-pill="Admin">Admin</button>
  </div>
  <div class="card-soft">
    <div class="search-box mb-3" style="max-width:380px"><i class="bi bi-search"></i><input class="form-control" data-filter-search placeholder="Cari nama, NIM, atau email..." aria-label="Cari pengguna"></div>
    <div class="table-responsive">
      <table class="table align-middle">
        <thead><tr><th>Nama</th><th>NIM / ID</th><th>Email</th><th>Role</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
          @foreach(config('faslink.users') as $u)
            @php $aktif = $u['status'] === 'Aktif'; $self = $u['id'] === config('faslink.admin.id'); @endphp
            <tr data-filter-item data-group="{{ $u['role'] }}" data-text="{{ $u['nama'] }} {{ $u['id'] }} {{ $u['email'] }}">
              <td><b>{{ $u['nama'] }}</b></td><td>{{ $u['id'] }}</td><td>{{ $u['email'] }}</td><td>{{ $u['role'] }}</td>
              <td><span class="status {{ $aktif ? 'ok' : 'bad' }}" data-user-status>{{ $u['status'] }}</span></td>
              <td>@if($self)<span class="muted small">Akun Anda</span>@else<button type="button" class="btn-view" data-toggle-user data-confirm="{{ $aktif ? 'Nonaktifkan' : 'Aktifkan' }} akun {{ $u['nama'] }}?" data-success="Status akun diperbarui (simulasi).">{{ $aktif ? 'Nonaktifkan' : 'Aktifkan' }}</button>@endif</td>
            </tr>
          @endforeach
          <tr class="table-empty" data-filter-empty style="display:none"><td colspan="6">Pengguna tidak ditemukan.</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
