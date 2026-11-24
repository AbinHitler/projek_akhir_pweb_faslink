@extends('layouts.app')

@section('title', 'Detail Pengajuan')
@section('heading', 'Detail Pengajuan')

@section('content')
<a class="back-link" href="{{ route('admin.loans') }}">
    <i class="bi bi-arrow-left"></i> Kembali ke daftar pengajuan
</a>

<div class="page-intro mt-3">
    <div>
        <h1>Pengajuan {{ $loan->code }}</h1>
        <p class="muted">Dibuat pada {{ $loan->created_at->format('d M Y H:i') }}</p>
    </div>
    <span class="status {{ $loan->status }}">
        {{ ['pending'=>'Menunggu','approved'=>'Disetujui','rejected'=>'Ditolak','completed'=>'Selesai','cancelled'=>'Dibatalkan'][$loan->status] ?? ucfirst($loan->status) }}
    </span>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="panel">
            <h3>Informasi Pengajuan</h3>
            <dl class="detail-list">
                <dt>Kode pengajuan</dt><dd>{{ $loan->code }}</dd>
                <dt>Nama pemohon</dt><dd>{{ $loan->user->name ?? $loan->responsible_name }}</dd>
                <dt>Penanggung jawab</dt><dd>{{ $loan->responsible_name }}</dd>
                <dt>Kontak</dt><dd>{{ $loan->responsible_contact }}</dd>
                <dt>Organisasi</dt><dd>{{ $loan->organization ?: '-' }}</dd>
                <dt>Nama kegiatan</dt><dd>{{ $loan->activity_name }}</dd>
                <dt>Deskripsi</dt><dd>{{ $loan->description }}</dd>
                <dt>Jumlah peserta</dt><dd>{{ $loan->participant_count }} orang</dd>
                <dt>Fasilitas</dt><dd>{{ $loan->facility_name }} ({{ $loan->quantity }})</dd>
                <dt>Mulai</dt><dd>{{ $loan->start_at->format('d M Y H:i') }}</dd>
                <dt>Selesai</dt><dd>{{ $loan->end_at->format('d M Y H:i') }}</dd>
                <dt>Catatan pemohon</dt><dd>{{ $loan->additional_notes ?: '-' }}</dd>
            </dl>
            @if($loan->status === 'rejected' && $loan->rejection_note)
                <div class="alert alert-warning mt-3">
                    <strong>Catatan revisi / alasan penolakan</strong>
                    <p class="mb-0 mt-1">{{ $loan->rejection_note }}</p>
                </div>
            @endif
        </div>
    </div>
    <div class="col-lg-5">
       <div class="panel">
    <h3>Dokumen Pendukung</h3>

    @forelse($loan->documents as $document)
        <div class="document-row">
            <i class="bi bi-file-earmark"></i>

            <div class="flex-grow-1">
                <div>{{ $document->original_name }}</div>
                <span class="text-muted">
                    {{ number_format(($document->file_size ?? 0) / 1024, 0) }} KB
                </span>
            </div>

            <a href="{{ url('/faslink/admin/pengajuan/' . $loan->id . '/dokumen/' . $document->id) }}"
               style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; background: #24558a; color: white; border-radius: 6px; text-decoration: none; white-space: nowrap;"
               target="_blank">
                <i class="bi bi-download"></i>
                Unduh
            </a>
        </div>
    @empty
        <p class="muted">Tidak ada dokumen yang diunggah.</p>
    @endforelse
</div>
        </div>
    </div>
</div>
@endsection
