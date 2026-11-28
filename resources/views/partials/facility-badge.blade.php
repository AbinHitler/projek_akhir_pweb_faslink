@php $ok = $f['status'] === 'Aktif' && $f['kondisi'] === 'Baik'; @endphp
<span class="status {{ $ok ? 'ok' : 'warn' }}">{{ $ok ? 'Tersedia' : 'Tidak Tersedia' }}</span>
