@extends('layouts.app')
@section('title', 'Serah Terima & Pengembalian')
@section('heading', 'Serah Terima & Pengembalian')

@section('content')

<div class="page-intro">
  <div>
    <h1>Serah Terima & Pengembalian</h1>
    <p class="muted">Catat penyerahan fasilitas kepada peminjam dan pemeriksaan saat dikembalikan.</p>
  </div>
</div>

<ul class="nav nav-tabs mb-3" id="handoverTab">
  <li class="nav-item">
    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-handover">
      <i class="bi bi-box-arrow-right me-1"></i>Serah Terima
    </button>
  </li>
  <li class="nav-item">
    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-return">
      <i class="bi bi-box-arrow-in-left me-1"></i>Pengembalian
    </button>
  </li>
</ul>

<div class="tab-content">

  {{-- Tab Serah Terima --}}
  <div class="tab-pane fade show active" id="tab-handover">
    <div class="panel">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Peminjam</th>
              <th>Fasilitas</th>
              <th>Jadwal</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>#PJ-001</td>
              <td>Budi Santoso</td>
              <td>Aula Serbaguna</td>
              <td>20 Nov 2026</td>
              <td><span class="status approved">Disetujui</span></td>
              <td>
                <button class="btn btn-sm btn-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#handoverModal">
                  Catat Serah Terima
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Tab Pengembalian --}}
  <div class="tab-pane fade" id="tab-return">
    <div class="panel">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Peminjam</th>
              <th>Fasilitas</th>
              <th>Jadwal Kembali</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>#PJ-008</td>
              <td>Raka Putra</td>
              <td>Proyektor (2 unit)</td>
              <td>17 Nov 2026</td>
              <td><span class="status pending">Sedang digunakan</span></td>
              <td>
                <button class="btn btn-sm btn-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#returnModal">
                  Proses Pengembalian
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

{{-- Modal Serah Terima --}}
<div class="modal fade" id="handoverModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="demo-form" data-success="Serah terima tercatat (demo).">
        <div class="modal-header">
          <h5 class="modal-title">Catat Serah Terima</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <label class="form-label">Petugas yang menyerahkan</label>
          <input class="form-control mb-3" required>
          <label class="form-label">Peminjam yang menerima</label>
          <input class="form-control mb-3" value="Budi Santoso">
          <label class="form-label">Tanggal dan waktu</label>
          <input type="datetime-local" class="form-control mb-3" required>
          <label class="form-label">Kondisi awal fasilitas</label>
          <select class="form-select mb-3">
            <option>Baik</option>
            <option>Rusak</option>
          </select>
          <label class="form-label">Catatan</label>
          <textarea class="form-control"></textarea>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Simpan Catatan</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal Pengembalian --}}
<div class="modal fade" id="returnModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="demo-form" data-success="Pemeriksaan pengembalian tersimpan (demo).">
        <div class="modal-header">
          <h5 class="modal-title">Pemeriksaan Pengembalian</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <label class="form-label">Tanggal dan waktu pengembalian</label>
          <input type="datetime-local" class="form-control mb-3" required>
          <label class="form-label">Kondisi akhir fasilitas</label>
          <select class="form-select mb-3">
            <option>Baik</option>
            <option>Rusak</option>
            <option>Hilang</option>
          </select>
          <label class="form-label">Catatan pemeriksaan</label>
          <textarea class="form-control mb-3"></textarea>
          <label class="form-label">Foto dokumentasi</label>
          <input type="file" class="form-control" accept="image/*">
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Simpan Pengembalian</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection