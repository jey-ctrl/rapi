
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kalender Kegiatan | RAPI-Sekolah</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css"
        rel="stylesheet">

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
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar-custom">
        <div class="container-fluid px-3 px-md-4 d-flex
                    justify-content-between align-items-center gap-3">

            <a href="{{ route('home') }}" class="brand">
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
            <div class="hero-decoration" aria-hidden="true">▦</div>

            <span class="hero-label">
                KALENDER PUBLIK
            </span>

            <h1>Kalender Kegiatan Sekolah</h1>

            <p>
                Lihat jadwal kegiatan dan penggunaan ruangan sekolah
                dalam satu kalender yang mudah diakses.
            </p>
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
                        <span class="legend-dot"
                              style="background:#198754"></span>
                        Disetujui
                    </span>

                    <span class="legend-item">
                        <span class="legend-dot"
                              style="background:#d99a24"></span>
                        Menunggu / status lainnya
                    </span>

                    <span class="legend-item">
                        <span class="legend-dot"
                              style="background:#dc3545"></span>
                        Ditolak
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
                        <h5 class="modal-title fw-bold"
                            id="eventModalLabel">
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
                        <div class="detail-label">Waktu</div>
                        <div id="detailTime" class="detail-value">-</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Status</div>
                        <div>
                            <span id="detailStatus"
                                  class="badge text-bg-secondary">
                                -
                            </span>
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

            const modalElement = document.getElementById('eventModal');
            const eventModal = new bootstrap.Modal(modalElement);

            const calendar = new FullCalendar.Calendar(calendarElement, {
                initialView: 'dayGridMonth',
                locale: 'id',
                firstDay: 1,
                height: 'auto',
                timeZone: 'local',
                dayMaxEvents: true,

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
                    }
                },

                eventClick: function (info) {
                    const event = info.event;
                    const props = event.extendedProps;

                    document.getElementById('detailTitle').textContent =
                        event.title || '-';

                    document.getElementById('detailRoom').textContent =
                        props.room || '-';

                    document.getElementById('detailDate').textContent =
                        props.date || (
                            event.start
                                ? event.start.toLocaleDateString('id-ID')
                                : '-'
                        );

                    document.getElementById('detailTime').textContent =
                        (props.start_time || '-') + ' - ' +
                        (props.end_time || '-');

                    const status = props.status || 'Tidak diketahui';
                    const statusElement =
                        document.getElementById('detailStatus');

                    statusElement.textContent = status;
                    statusElement.className = 'badge';

                    const normalizedStatus = status.toLowerCase();

                    if (normalizedStatus.includes('setuju') ||
                        normalizedStatus === 'approved') {
                        statusElement.classList.add('text-bg-success');
                    } else if (normalizedStatus.includes('tolak') ||
                               normalizedStatus === 'rejected') {
                        statusElement.classList.add('text-bg-danger');
                    } else {
                        statusElement.classList.add('text-bg-warning');
                    }

                    eventModal.show();
                }
            });

            calendar.render();
        });
    </script>

</body>
</html>
