
@extends('layouts.app')

@section('title', 'Edit Pengajuan')
@section('heading', 'Edit Pengajuan Peminjaman')

@section('content')

<div class="page-intro">
    <div>
        <h1>Edit Pengajuan Peminjaman</h1>
        <p class="muted">Ubah informasi pengajuan peminjamanmu sebelum diproses.</p>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Pengajuan belum dapat diperbarui.</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="panel">
    <form action="{{ route('user.loan.update', $loan->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <h3 class="form-section-title">1. Informasi Kegiatan</h3>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nama kegiatan *</label>
                <input
                    name="activity_name"
                    class="form-control"
                    required
                    maxlength="150"
                    value="{{ old('activity_name', $loan->activity_name) }}"
                    placeholder="Contoh: Seminar Nasional">
            </div>

            <div class="col-md-6">
                <label class="form-label">Organisasi / UKM</label>
                <input
                    name="organization"
                    class="form-control"
                    maxlength="150"
                    value="{{ old('organization', $loan->organization) }}"
                    placeholder="Nama organisasi">
            </div>

            <div class="col-12">
                <label class="form-label">Deskripsi / tujuan kegiatan *</label>
                <textarea
                    name="description"
                    class="form-control"
                    rows="3"
                    required>{{ old('description', $loan->description) }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Penanggung jawab *</label>
                <input
                    name="responsible_name"
                    class="form-control"
                    required
                    maxlength="150"
                    value="{{ old('responsible_name', $loan->responsible_name) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Kontak penanggung jawab *</label>
                <input
                    name="responsible_contact"
                    class="form-control"
                    required
                    maxlength="30"
                    value="{{ old('responsible_contact', $loan->responsible_contact) }}"
                    placeholder="08xxxxxxxxxx">
            </div>

            <div class="col-md-4">
                <label class="form-label">Jumlah peserta *</label>
                <input
                    name="participant_count"
                    type="number"
                    min="1"
                    class="form-control"
                    required
                    value="{{ old('participant_count', $loan->participant_count) }}">
            </div>
        </div>

        <hr>

    
                <h3 class="form-section-title">2. Jadwal Peminjaman</h3>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Tanggal mulai *</label>
                <input
                    id="start_at"
                    name="start_at"
                    type="datetime-local"
                    class="form-control"
                    required
                    value="{{ old('start_at', $loan->start_at->format('Y-m-d\TH:i')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Tanggal selesai *</label>
                <input
                    id="end_at"
                    name="end_at"
                    type="datetime-local"
                    class="form-control"
                    required
                    value="{{ old('end_at', $loan->end_at->format('Y-m-d\TH:i')) }}">
            </div>
        </div>

        <hr>

        <h3 class="form-section-title">3. Fasilitas yang Dipinjam</h3>

        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Pilih fasilitas *</label>

                <select id="facility_name" name="facility_name" class="form-select" required>
                    <option value="">Pilih fasilitas</option>

                    @foreach(['Aula Serbaguna', 'Ruang Seminar', 'Proyektor', 'Sound System'] as $facility)
                        <option
                            value="{{ $facility }}"
                            @selected(old('facility_name', $loan->facility_name) === $facility)>
                            {{ $facility }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Jumlah barang</label>
                <input
                    name="quantity"
                    type="number"
                    min="1"
                    class="form-control"
                    required
                    value="{{ old('quantity', $loan->quantity) }}">
            </div>

            <div class="col-12">
                <label class="form-label">
                    Proposal / dokumen persyaratan (PDF/DOC/DOCX, maks. 5 MB)
                </label>

                @if($loan->documents->isNotEmpty())
                    <div class="mb-2">
                        <small class="text-muted">
                            Dokumen saat ini:
                            <strong>{{ $loan->documents->first()->original_name }}</strong>
                        </small>
                    </div>
                @else
                    <small class="text-muted d-block mb-2">
                        Belum ada dokumen yang diunggah.
                    </small>
                @endif

                <input
                    name="document"
                    type="file"
                    class="form-control"
                    accept=".pdf,.doc,.docx">

                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti dokumen.
                </small>
            </div>

            <div class="col-12">
                <label class="form-label">Catatan tambahan</label>
                <textarea
                    name="additional_notes"
                    class="form-control"
                    rows="2">{{ old('additional_notes', $loan->additional_notes) }}</textarea>
            </div>
        </div>

        @include('user.partials.availability-calendar')

    <div class="d-flex justify-content-end gap-2 mt-4">
            <a class="btn btn-light"
               href="{{ route('user.loan.detail', $loan->id) }}">
                Batal
            </a>

            <button class="btn btn-primary" type="submit">
                Simpan Perubahan
                <i class="bi bi-check-lg ms-1"></i>
            </button>
        </div>

    </form>
</div>

@endsection