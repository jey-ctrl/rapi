
@extends('layouts.app')

@section('title', 'Kalender Agenda')
@section('page-title', 'Kalender Agenda')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

<style>
    .calendar-intro {
        margin-bottom: 22px;
    }

    .calendar-intro h2 {
        color: #17365d;
        font-size: 21px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .calendar-intro p {
        color: #707985;
        font-size: 12px;
        margin: 0;
    }

    .calendar-section {
        margin-bottom: 22px;
    }

    .calendar-section .card-body {
        padding: 20px;
    }

    .calendar-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 14px 20px;
        margin-bottom: 20px;
        color: #596474;
        font-size: 11px;
    }

    .legend-item {
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .legend-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    #calendar {
        min-height: 400px;
    }

    .fc {
        font-size: 12px;
    }

    .fc .fc-toolbar-title {
        color: #17365d;
        font-size: 20px;
        font-weight: 700;
    }

    .fc .fc-button-primary {
        background: #17365d;
        border-color: #17365d;
        box-shadow: none;
        text-transform: capitalize;
    }

    .fc .fc-button-primary:hover,
    .fc .fc-button-primary:focus,
    .fc .fc-button-primary:not(:disabled).fc-button-active {
        background: #2457a7;
        border-color: #2457a7;
        box-shadow: none;
    }

    .fc .fc-daygrid-day-number,
    .fc .fc-col-header-cell-cushion {
        color: #344054;
        text-decoration: none;
    }

    .fc .fc-day-today {
        background: #edf3fb !important;
    }

    .fc .fc-event {
        border: none;
        border-radius: 4px;
        padding: 3px 5px;
        cursor: pointer;
    }

    .fc .fc-day-sat .fc-daygrid-day-number,
    .fc .fc-day-sun .fc-daygrid-day-number,
    .fc .fc-day-sat .fc-col-header-cell-cushion,
    .fc .fc-day-sun .fc-col-header-cell-cushion {
        color: #dc3545;
    }

    .today-event {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 14px 0;
        border-bottom: 1px solid #edf0f3;
        cursor: pointer;
    }

    .today-event:last-child {
        border-bottom: none;
    }

    .today-event h6 {
        color: #17365d;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .today-event p {
        color: #707985;
        font-size: 11px;
        margin: 0;
    }

    .today-event-time {
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .today-status {
        display: inline-block;
        margin-top: 6px;
        padding: 4px 9px;
        border-radius: 20px;
        font-size: 10px;
    }

    .today-status.pending {
        background: #fff3cd;
        color: #856404;
    }

    .today-status.approved {
        background: #d1e7dd;
        color: #0f5132;
    }

    .today-empty {
        padding: 25px 10px;
        color: #707985;
        text-align: center;
        font-size: 12px;
    }

    .detail-label {
        color: #707985;
        font-size: 11px;
        margin-bottom: 5px;
    }

    .detail-value {
        font-size: 12px;
        font-weight: 600;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    .detail-item {
        padding: 12px 0;
        border-bottom: 1px solid #edf0f3;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    @media (max-width: 768px) {
        .calendar-section .card-body {
            padding: 12px;
        }

        .fc .fc-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .fc .fc-toolbar-title {
            font-size: 16px;
        }

        .fc .fc-toolbar-chunk {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .fc .fc-button {
            padding: 6px 8px;
            font-size: 11px;
        }
    }

    @media (max-width: 576px) {
        .today-event {
            align-items: flex-start;
            flex-direction: column;
            gap: 7px;
        }
    }
</style>
@endpush

@section('content')

<div class="calendar-intro">
    <h2>Kalender Kegiatan Sekolah</h2>
    <p>
        Lihat jadwal kegiatan dan penggunaan ruangan sekolah
        dalam satu kalender.
    </p>
</div>

<section class="section calendar-section">
    <div class="card">
        <div class="card-header">
            <div>
                <h3>Acara Hari Ini</h3>
                <small class="text-muted" id="todayDate">
                    Daftar kegiatan sekolah hari ini
                </small>
            </div>
        </div>

        <div class="card-body">
            <div id="todayEventsList">
                <div class="today-empty">
                    Memuat kegiatan hari ini...
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section calendar-section">
    <div class="card">
        <div class="card-header">
            <div>
                <h3>Jadwal Kegiatan</h3>
                <small class="text-muted">
                    Pilih agenda pada kalender untuk melihat detailnya.
                </small>
            </div>
        </div>

        <div class="card-body">

            <div class="calendar-legend">
                <span class="legend-item">
                    <span class="legend-dot" style="background:#2457a7"></span>
                    Kegiatan Guru
                </span>

                <span class="legend-item">
                    <span class="legend-dot" style="background:#198754"></span>
                    Kegiatan Siswa
                </span>

                <span class="legend-item">
                    <span class="legend-dot" style="background:#805ad5"></span>
                    Kegiatan Organisasi
                </span>

                <span class="legend-item">
                    <span class="legend-dot" style="background:#0d9488"></span>
                    Rapat
                </span>

                <span class="legend-item">
                    <span class="legend-dot" style="background:#d97706"></span>
                    Kegiatan Sekolah
                </span>

                <span class="legend-item">
                    <span class="legend-dot" style="background:#64748b"></span>
                    Lainnya
                </span>

                <span class="legend-item">
                    <span class="legend-dot" style="background:#f0ad4e"></span>
                    Menunggu Persetujuan
                </span>
            </div>

            <div id="calendar"></div>

            <div id="calendarError"
                 class="alert alert-warning mt-3 d-none"
                 role="alert">
                Agenda gagal dimuat. Periksa koneksi dan route kalender.
            </div>

        </div>
    </div>
</section>

<div class="modal fade" id="eventModal" tabindex="-1"
     aria-labelledby="eventModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-3">

            <div class="modal-header">
                <div>
                    <div class="detail-label">DETAIL AGENDA</div>
                    <h5 class="modal-title fw-bold" id="eventModalLabel">
                        Informasi Kegiatan
                    </h5>
                </div>

                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">

                <h5 id="detailTitle"
                    class="fw-bold mb-3"
                    style="color:#17365d"></h5>

                <div class="detail-item">
                    <div class="detail-label">Ruangan</div>
                    <div id="detailRoom" class="detail-value">-</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Tanggal</div>
                    <div id="detailDate" class="detail-value">-</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Nama Pengaju</div>
                    <div id="detailApplicant" class="detail-value">-</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Keterangan Kegiatan</div>
                    <div id="detailDescription" class="detail-value">
                        Tidak ada keterangan
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')

{{-- Bootstrap JS harus dimuat sebelum script kalender --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- FullCalendar --}}
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const calendarElement = document.getElementById('calendar');
    const errorElement = document.getElementById('calendarError');
    const todayEventsList = document.getElementById('todayEventsList');
    const todayDateElement = document.getElementById('todayDate');

    if (!calendarElement || !todayEventsList || !todayDateElement) {
        console.error('Elemen kalender tidak ditemukan.');
        return;
    }

    if (typeof FullCalendar === 'undefined') {
        errorElement.classList.remove('d-none');
        errorElement.textContent = 'Library FullCalendar gagal dimuat.';
        return;
    }

    if (typeof bootstrap === 'undefined') {
        errorElement.classList.remove('d-none');
        errorElement.textContent = 'Library Bootstrap gagal dimuat.';
        return;
    }

    const modalElement = document.getElementById('eventModal');
    const eventModal = new bootstrap.Modal(modalElement);

    const categoryColors = {
        'Kegiatan Guru': '#2457a7',
        'Kegiatan Siswa': '#198754',
        'Kegiatan Organisasi': '#805ad5',
        'Rapat': '#0d9488',
        'Kegiatan Sekolah': '#d97706',
        'Lainnya': '#64748b'
    };

    function getLocalDateString(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');

        return `${year}-${month}-${day}`;
    }

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char];
        });
    }

    function renderTodayEvents(events) {
        const now = new Date();
        const today = getLocalDateString(now);

        todayDateElement.textContent = now.toLocaleDateString('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

        const todayEvents = events
            .filter(event =>
                event.extendedProps.date === today &&
                event.extendedProps.isNationalCalendar !== true
            )
            .sort((a, b) => {
                return (a.extendedProps.start_time || '').localeCompare(
                    b.extendedProps.start_time || ''
                );
            });

        if (todayEvents.length === 0) {
            todayEventsList.innerHTML = `
                <div class="today-empty">
                    <div class="fw-bold mb-1">Tidak ada kegiatan hari ini</div>
                    <div>Belum terdapat agenda kegiatan sekolah yang tercatat.</div>
                </div>
            `;
            return;
        }

        todayEventsList.innerHTML = todayEvents.map(event => {
            const props = event.extendedProps;
            const status = String(props.status || '').toLowerCase();

            const isApproved = [
                'approved',
                'disetujui',
                'setuju'
            ].includes(status);

            const statusLabel = isApproved
                ? 'Disetujui'
                : 'Menunggu Persetujuan';

            const statusClass = isApproved
                ? 'approved'
                : 'pending';

            const color = isApproved
                ? (categoryColors[props.category] || '#64748b')
                : '#f0ad4e';

            return `
                <div class="today-event"
                     role="button"
                     tabindex="0"
                     data-event-id="${escapeHtml(event.id)}">

                    <div>
                        <h6>${escapeHtml(event.title)}</h6>

                        <p>
                            ${escapeHtml(props.room || 'Ruangan tidak diketahui')}
                            &nbsp;•&nbsp;
                            ${escapeHtml(props.applicant || 'Pengaju tidak diketahui')}
                        </p>

                        <span class="today-status ${statusClass}">
                            ${statusLabel}
                        </span>
                    </div>

                    <div class="today-event-time" style="color:${color}">
                        ${escapeHtml(props.start_time || '-')} -
                        ${escapeHtml(props.end_time || '-')}
                    </div>
                </div>
            `;
        }).join('');

        todayEventsList.querySelectorAll('.today-event').forEach(item => {
            const openEvent = function () {
                const selectedEvent = calendar.getEventById(item.dataset.eventId);

                if (selectedEvent) {
                    showEventDetail(selectedEvent);
                }
            };

            item.addEventListener('click', openEvent);

            item.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    openEvent();
                }
            });
        });
    }

    function showEventDetail(event) {
        const props = event.extendedProps;

        document.getElementById('detailTitle').textContent =
            event.title || '-';

        document.getElementById('detailRoom').textContent =
            props.room || '-';

        document.getElementById('detailDate').textContent =
            props.date
                ? new Date(props.date + 'T00:00:00').toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                })
                : '-';

        document.getElementById('detailApplicant').textContent =
            props.applicant || '-';

        document.getElementById('detailDescription').textContent =
            props.description || 'Tidak ada keterangan';

        eventModal.show();
    }

    const calendar = new FullCalendar.Calendar(calendarElement, {

        initialView: 'dayGridMonth',
        locale: 'id',
        firstDay: 1,
        height: 'auto',
        timeZone: 'local',
        dayMaxEvents: 1,

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },

        buttonText: {
            today: 'Hari ini',
            month: 'Bulan',
            week: 'Minggu',
            day: 'Hari',
            list: 'Daftar'
        },

        events: {
            url: @json(route('calendar.events')),

            failure: function (error) {
                console.error('Gagal mengambil data kalender:', error);

                errorElement.classList.remove('d-none');

                todayEventsList.innerHTML = `
                    <div class="today-empty">
                        Gagal memuat kegiatan hari ini.
                    </div>
                `;
            }
        },

        eventOrder: 'start',

        eventDidMount: function (info) {
            const props = info.event.extendedProps;
            const isPending = String(props.status || '').toLowerCase() === 'pending';

            if (isPending) {
                info.el.style.borderLeft = '4px solid #d99a24';
            }
        },

        eventClick: function (info) {
            const props = info.event.extendedProps;

            if (props.isNationalCalendar === true) {
                return;
            }

            showEventDetail(info.event);
        },

        eventsSet: function (events) {
            renderTodayEvents(events);
        }
    });

    calendar.render();
});
</script>
@endpush
