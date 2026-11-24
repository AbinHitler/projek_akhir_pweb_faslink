<div class="panel mt-3 mb-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
        <div>
            <h3 class="mb-1">Kalender Ketersediaan</h3>
            <p class="muted mb-0">Pilih blok waktu kosong pada kalender untuk mengisi tanggal dan jam.</p>
        </div>
        <div class="small d-flex flex-wrap gap-3">
            <span><span class="badge" style="background:#9ca3af">&nbsp;</span> Kosong</span>
            <span><span class="badge" style="background:#eab308">&nbsp;</span> Menunggu</span>
            <span><span class="badge" style="background:#dc3545">&nbsp;</span> Disetujui</span>
        </div>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <style>
        #loanAvailabilityCalendar .fc-timegrid-slot { background: #f3f4f6; }
        #loanAvailabilityCalendar .fc-toolbar-title { font-size: 1.05rem; }
    </style>
    <div id="loanAvailabilityCalendar"></div>
    <small class="text-muted d-block mt-2">Jadwal kuning dan merah tidak dapat dipilih. Jam kosong ditampilkan dengan latar abu-abu.</small>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const element = document.getElementById('loanAvailabilityCalendar');
    if (!element) return;

    const facility = document.getElementById('facility_name');
    const startInput = document.getElementById('start_at');
    const endInput = document.getElementById('end_at');

    function toLocalInput(date) {
        const pad = value => String(value).padStart(2, '0');
        return date.getFullYear() + '-' + pad(date.getMonth() + 1) + '-' +
            pad(date.getDate()) + 'T' + pad(date.getHours()) + ':' + pad(date.getMinutes());
    }

    const calendar = new FullCalendar.Calendar(element, {
        initialView: 'timeGridWeek',
        locale: 'id',
        height: 'auto',
        allDaySlot: false,
        slotMinTime: '06:00:00',
        slotMaxTime: '23:00:00',
        slotDuration: '00:30:00',
        nowIndicator: true,
        selectable: true,
        selectMirror: true,
        selectOverlap: false,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: {
            url: @json(route('user.calendar.events')),
            extraParams: function () {
                return { facility_name: facility ? facility.value : '' };
            }
        },
        select: function (info) {
            if (startInput) startInput.value = toLocalInput(info.start);
            if (endInput) endInput.value = toLocalInput(info.end);
            calendar.unselect();
            if (startInput) startInput.scrollIntoView({behavior: 'smooth', block: 'center'});
        }
    });

    if (facility) {
        facility.addEventListener('change', function () {
            calendar.refetchEvents();
        });
    }

    calendar.render();
});
</script>
@endpush
