<<<<<<< HEAD
@extends('layouts.app') @section('title','Detail Pengajuan') @section('heading','Detail Pengajuan')
@section('content')<a class="back-link" href="{{ route('user.loans') }}"><i class="bi bi-arrow-left"></i> Kembali ke pengajuan saya</a><div class="page-intro mt-3"><div><h1>Pengajuan #PJ-001</h1><p class="muted">Dibuat pada 12 November 2026</p></div><span class="status pending">Menunggu Verifikasi</span></div><div class="panel mb-3"><div class="approval-track"><div class="track-step active"><span>1</span><b>Pengajuan</b><small>Terkirim</small></div><div class="track-step"><span>2</span><b>Verifikasi Admin</b><small>Menunggu</small></div><div class="track-step"><span>3</span><b>Persetujuan akhir</b><small>Belum diproses</small></div></div></div><div class="row g-3"><div class="col-lg-7"><div class="panel"><h3>Informasi Kegiatan</h3><dl class="detail-list"><dt>Nama kegiatan</dt><dd>Seminar Nasional Teknologi</dd><dt>Organisasi</dt><dd>Himpunan Mahasiswa Informatika</dd><dt>Penanggung jawab</dt><dd>Budi Santoso</dd><dt>Jumlah peserta</dt><dd>120 orang</dd><dt>Jadwal</dt><dd>20 November 2026 · 08.00–12.00</dd><dt>Fasilitas</dt><dd>Aula Serbaguna</dd></dl></div></div><div class="col-lg-5"><div class="panel"><h3>Dokumen Pendukung</h3><div class="document-row"><i class="bi bi-file-earmark-pdf"></i> Proposal_Kegiatan.pdf <a href="#">Unduh</a></div><hr><h3>Status & Catatan</h3><p class="muted">Pengajuan sedang menunggu pemeriksaan kelengkapan oleh Admin Sarpras.</p><button class="btn btn-outline-danger btn-sm" data-confirm="Batalkan pengajuan ini?">Batalkan Pengajuan</button></div></div></div>@endsection
=======

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
>>>>>>> origin/main
