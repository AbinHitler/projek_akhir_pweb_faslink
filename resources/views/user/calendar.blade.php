@extends('layouts.app')

@section('title', 'Kalender Peminjaman')
@section('heading', 'Kalender Peminjaman')

@section('content')
<div class="page-intro">
    <div>
        <h1>Kalender Ketersediaan Fasilitas</h1>
        <p class="muted">Pilih fasilitas untuk melihat jadwal yang sudah diajukan atau disetujui.</p>
    </div>
    <a href="{{ route('user.loan.create') }}" class="btn btn-primary">Buat Pengajuan</a>
</div>

<div class="panel mb-3">
    <label for="calendarFacility" class="form-label">Pilih fasilitas</label>
    <select id="calendarFacility" class="form-select" style="max-width: 420px">
        <option value="">Semua fasilitas</option>
        @foreach(['Aula Serbaguna', 'Ruang Seminar', 'Proyektor', 'Sound System'] as $facility)
            <option value="{{ $facility }}">{{ $facility }}</option>
        @endforeach
    </select>
    <div class="d-flex flex-wrap gap-3 mt-3 small">
        <span><span class="badge" style="background:#9ca3af">&nbsp;</span> Kosong / tersedia</span>
        <span><span class="badge" style="background:#eab308">&nbsp;</span> Menunggu persetujuan</span>
        <span><span class="badge" style="background:#dc3545">&nbsp;</span> Disetujui / tidak tersedia</span>
    </div>
</div>

<div class="panel">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <style>
        #availabilityCalendar .fc-timegrid-slot { background: #f3f4f6; }
        #availabilityCalendar .fc-event { cursor: default; }
        #availabilityCalendar .fc-toolbar-title { font-size: 1.15rem; }
    </style>
    <div id="availabilityCalendar"></div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarElement = document.getElementById('availabilityCalendar');
    const facilitySelect = document.getElementById('calendarFacility');

    const calendar = new FullCalendar.Calendar(calendarElement, {
        initialView: 'timeGridWeek',
        locale: 'id',
        height: 'auto',
        allDaySlot: false,
        slotMinTime: '06:00:00',
        slotMaxTime: '23:00:00',
        slotDuration: '00:30:00',
        nowIndicator: true,
        selectable: false,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: {
            url: @json(route('user.calendar.events')),
            extraParams: function () {
                return { facility_name: facilitySelect.value };
            }
        },
        eventDidMount: function (info) {
            info.el.title = info.event.title + ' · ' +
                info.event.start.toLocaleString('id-ID') + ' - ' +
                (info.event.end ? info.event.end.toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'}) : '');
        }
    });

    facilitySelect.addEventListener('change', function () {
        calendar.refetchEvents();
    });

    calendar.render();
});
</script>
@endpush
