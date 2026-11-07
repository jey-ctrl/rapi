
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kalender Kegiatan | RAPI-Sekolah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

    <style>
        :root {
            --navy: #17365d;
            --navy-dark: #102744;
            --blue: #2457a7;
            --background: #f4f6fa;
            --text: #263445;
            --muted: #718096;
            --border: #e5eaf1;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--background);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        .navbar-custom {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 15px 0;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--navy);
            font-weight: 800;
            font-size: 20px;
            text-decoration: none;
        }

        .brand-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--navy);
            color: white;
            font-size: 20px;
        }

        .brand small {
            display: block;
            color: var(--muted);
            font-size: 11px;
            font-weight: 500;
            margin-top: 3px;
        }

        .btn-login {
            background: var(--navy);
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid var(--navy);
            transition: .2s;
        }

        .btn-login:hover {
            background: var(--navy-dark);
            color: white;
        }

        .page-container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        .hero {
            position: relative;
            overflow: hidden;
            background: linear-gradient(120deg, var(--navy-dark), var(--navy), #28558b);
            color: white;
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 24px;
        }

        .hero-label {
            display: inline-block;
            background: rgba(255, 255, 255, .13);
            border: 1px solid rgba(255, 255, 255, .2);
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            margin-bottom: 16px;
        }

        .hero h1 {
            font-size: clamp(25px, 4vw, 36px);
            font-weight: 800;
            margin-bottom: 12px;
        }

        .hero p {
            color: #dce7f5;
            margin-bottom: 0;
            max-width: 650px;
            line-height: 1.7;
        }

        .hero-decoration {
            position: absolute;
            right: 40px;
            top: 10px;
            font-size: 130px;
            opacity: .08;
            pointer-events: none;
        }

        .section-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 4px 20px rgba(25, 48, 79, .04);
        }

        .section-heading {
            padding: 22px 24px;
            border-bottom: 1px solid var(--border);
        }

        .section-heading h2 {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 13px;
            margin: 0;
        }

        .calendar-content {
            padding: 24px;
        }

        .legend {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
            font-size: 13px;
            color: #526174;
        }

        .legend-item {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .legend-dot {
            display: inline-block;
            width: 9px;
            height: 9px;
            border-radius: 50%;
        }

        #calendar {
            min-height: 400px;
        }

        .fc {
            font-size: 13px;
        }

        .fc .fc-toolbar-title {
            color: var(--navy);
            font-size: 21px;
            font-weight: 800;
        }

        .fc .fc-button-primary {
            background: var(--navy);
            border-color: var(--navy);
            border-radius: 7px;
            box-shadow: none;
            text-transform: capitalize;
        }

        .fc .fc-button-primary:hover,
        .fc .fc-button-primary:focus,
        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background: var(--blue);
            border-color: var(--blue);
            box-shadow: none;
        }

        .fc .fc-daygrid-day-number {
            color: var(--text);
            text-decoration: none;
            padding: 8px;
        }

        .fc .fc-col-header-cell-cushion {
            color: var(--muted);
            text-decoration: none;
            padding: 10px 4px;
        }

        .fc .fc-day-today {
            background: #edf3fb !important;
        }

        .fc .fc-event {
            border: none;
            border-radius: 5px;
            padding: 3px 5px;
            cursor: pointer;
        }

        .fc .fc-day-sat .fc-daygrid-day-number,
        .fc .fc-day-sun .fc-daygrid-day-number,
        .fc .fc-day-sat .fc-col-header-cell-cushion,
        .fc .fc-day-sun .fc-col-header-cell-cushion {
            color: #dc3545;
        }

        /* ACARA HARI INI */
        .today-event {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 15px 0;
            border-bottom: 1px solid var(--border);
        }

        .today-event:last-child {
            border-bottom: none;
        }

        .today-event h6 {
            color: var(--navy);
            font-weight: 700;
            margin-bottom: 6px;
        }

        .today-event p {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 0;
        }

        .today-event-time {
            color: var(--navy);
            font-weight: 700;
            white-space: nowrap;
        }

        .today-status {
            display: inline-block;
            font-size: 11px;
            padding: 4px 9px;
            border-radius: 20px;
            margin-top: 7px;
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
            text-align: center;
            color: var(--muted);
            padding: 25px 10px;
        }

        .site-footer {
            text-align: center;
            padding: 24px 16px;
            color: var(--muted);
            font-size: 12px;
        }

        .detail-label {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 5px;
        }

        .detail-value {
            font-weight: 600;
            overflow-wrap: anywhere;
            white-space: pre-line;
        }

        .detail-item {
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        @media (max-width: 768px) {
            .page-container {
                padding: 20px 12px;
            }

            .hero {
                padding: 24px 20px;
                border-radius: 15px;
            }

            .hero-decoration {
                right: 10px;
                font-size: 90px;
            }

            .calendar-content {
                padding: 12px;
            }

            .section-heading {
                padding: 18px;
            }

            .fc .fc-toolbar {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .fc .fc-toolbar-title {
                font-size: 17px;
            }

            .fc .fc-toolbar-chunk {
                display: flex;
                flex-wrap: wrap;
                gap: 4px;
            }

            .fc .fc-button {
                padding: 6px 8px;
                font-size: 12px;
            }
        }

        @media (max-width: 576px) {
            .today-event {
                align-items: flex-start;
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar-custom">
        <div class="container-fluid px-3 px-md-4 d-flex justify-content-between align-items-center gap-3">

            <a href="{{ route('calendar') }}" class="brand">
                <span class="brand-icon">R</span>

                <span>
                    RAPI-Sekolah
                    <small>Sistem Informasi Peminjaman Ruangan</small>
                </span>
            </a>

            <a href="{{ route('login') }}" class="btn-login">
                Login
            </a>

        </div>
    </nav>

    <main class="page-container">

        <!-- HERO -->
        <section class="hero">
            <div class="hero-decoration" aria-hidden="true">◆</div>

            <span class="hero-label">KALENDER PUBLIK</span>

            <h1>Kalender Kegiatan Sekolah</h1>

            <p>
                Lihat jadwal kegiatan dan penggunaan ruangan sekolah
                dalam satu kalender yang mudah diakses.
            </p>
        </section>

        <!-- ACARA HARI INI -->
        <section class="section-card mb-4">

            <div class="section-heading">
                <h2>Acara Hari Ini</h2>
                <p id="todayDate">Daftar kegiatan sekolah hari ini</p>
            </div>

            <div class="calendar-content">
                <div id="todayEventsList">
                    <div class="today-empty">
                        Memuat kegiatan hari ini...
                    </div>
                </div>
            </div>

        </section>

        <!-- KALENDER -->
        <section class="section-card">

            <div class="section-heading">
                <h2>Jadwal Kegiatan</h2>
                <p>
                    Pilih agenda pada kalender untuk melihat detailnya.
                </p>
            </div>

            <div class="calendar-content">

                <div class="legend">

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
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="site-footer">
        &copy; {{ date('Y') }} RAPI-Sekolah.
        Sistem Informasi Peminjaman Ruangan Sekolah.
    </footer>

    <!-- MODAL DETAIL KEGIATAN -->
    <div class="modal fade" id="eventModal" tabindex="-1"
         aria-labelledby="eventModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">

                <div class="modal-header px-4 py-3">
                    <div>
                        <div class="detail-label">DETAIL AGENDA</div>

                        <h5 class="modal-title fw-bold" id="eventModalLabel">
                            Informasi Kegiatan
                        </h5>
                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                </div>

                <div class="modal-body px-4">

                    <h5 id="detailTitle"
                        class="fw-bold mb-3"
                        style="color:var(--navy)">
                    </h5>

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

                <div class="modal-footer px-4">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const calendarElement = document.getElementById('calendar');
            const errorElement = document.getElementById('calendarError');
            const todayEventsList = document.getElementById('todayEventsList');
            const todayDateElement = document.getElementById('todayDate');

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

                // Hanya kegiatan sekolah yang masuk ke daftar Acara Hari Ini.
                // Hari libur dan peringatan nasional tidak ikut ditampilkan di sini.
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
                            <div class="small">Belum terdapat agenda kegiatan sekolah yang tercatat.</div>
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
                                ${escapeHtml(props.start_time || '-')} - ${escapeHtml(props.end_time || '-')}
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

                    failure: function () {
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

                    // Hari libur dan peringatan nasional tidak membuka modal kegiatan.
                    if (props.isNationalCalendar === true) {
                        return;
                    }

                    // Kegiatan sekolah tetap membuka detail.
                    showEventDetail(info.event);
                },

                eventsSet: function (events) {
                    renderTodayEvents(events);
                }
            });

            calendar.render();
        });
    </script>

</body>
</html>
