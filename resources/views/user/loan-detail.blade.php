@extends('layouts.app')

@section('title', 'Detail Pengajuan')
@section('heading', 'Detail Pengajuan')

@section('content')
<a class="back-link" href="{{ route('user.loans') }}">
    <i class="bi bi-arrow-left"></i> Kembali ke pengajuan saya
</a>

<div class="page-intro mt-3">
    <div>
        <h1>Pengajuan {{ $loan->code }}</h1>
        <p class="muted">
            Dibuat pada {{ $loan->created_at->format('d M Y H:i') }}
        </p>
    </div>

    <span class="status {{ $loan->status }}">
        {{ [
            'pending' => 'Menunggu Verifikasi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai'
        ][$loan->status] ?? ucfirst($loan->status) }}
    </span>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="panel">
            <h3>Informasi Kegiatan</h3>

            <dl class="detail-list">
                <dt>Nama kegiatan</dt>
                <dd>{{ $loan->activity_name }}</dd>

                <dt>Organisasi</dt>
                <dd>{{ $loan->organization ?: '-' }}</dd>

                <dt>Deskripsi / tujuan</dt>
                <dd>{{ $loan->description }}</dd>

                <dt>Penanggung jawab</dt>
                <dd>{{ $loan->responsible_name }}</dd>

                <dt>Kontak</dt>
                <dd>{{ $loan->responsible_contact }}</dd>

                <dt>Jumlah peserta</dt>
                <dd>{{ $loan->participant_count }} orang</dd>

                <dt>Jadwal</dt>
                <dd>
                    {{ $loan->start_at->format('d M Y H:i') }}
                    –
                    {{ $loan->end_at->format('d M Y H:i') }}
                </dd>

                <dt>Fasilitas</dt>
                <dd>{{ $loan->facility_name }} ({{ $loan->quantity }})</dd>

                <dt>Catatan</dt>
                <dd>{{ $loan->additional_notes ?: '-' }}</dd>
            </dl>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="panel">
            <h3>Dokumen Pendukung</h3>

            @forelse($loan->documents as $document)
                <div class="document-row">
                    <i class="bi bi-file-earmark"></i>
                    {{ $document->original_name }}

                    <span class="text-muted">
                        {{ number_format(($document->file_size ?? 0) / 1024, 0) }} KB
                    </span>
                </div>
            @empty
                <p class="muted">Tidak ada dokumen yang diunggah.</p>
            @endforelse

            <hr>

            <h3>Status Pengajuan</h3>
            @if($loan->status === 'rejected' && $loan->rejection_note)
                <div class="alert alert-warning mt-2">
                    <strong>Catatan revisi / alasan penolakan:</strong>
                    <p class="mb-0 mt-1">{{ $loan->rejection_note }}</p>
                </div>
            @elseif($loan->status === 'cancelled')
                <div class="alert alert-secondary mt-2">Pengajuan ini telah dibatalkan.</div>
            @else
                <p class="muted">Status pengajuan saat ini: {{ ucfirst($loan->status) }}.</p>
            @endif
        </div>
    </div>
</div>
@endsection
