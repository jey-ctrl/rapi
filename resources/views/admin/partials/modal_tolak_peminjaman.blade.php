{{-- =====================================================
     MODAL PENOLAKAN PEMINJAMAN
===================================================== --}}

<div class="modal fade" id="modalTolak" tabindex="-1"
    aria-labelledby="modalTolakLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content modal-tolak-content">

            {{-- HEADER --}}
            <div class="modal-header modal-tolak-header">

                <div>
                    <h5 class="modal-title" id="modalTolakLabel">
                        <i class="bi bi-x-circle me-2"></i>
                        Tolak Peminjaman
                    </h5>

                    <small>
                        Periksa data sebelum menolak pengajuan.
                    </small>
                </div>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Tutup">
                </button>

            </div>


            {{-- FORM PENOLAKAN --}}
            <form id="formTolak" method="POST">

                @csrf
                @method('PUT')

                <div class="modal-body modal-tolak-body">

                    {{-- INFORMASI PEMINJAMAN --}}
                    <div class="modal-tolak-section-heading">

                        <div>
                            <h6>Data Peminjaman</h6>

                            <p>
                                Informasi pengajuan peminjaman yang akan ditolak.
                            </p>
                        </div>

                        <span class="modal-tolak-index">01</span>

                    </div>


                    {{-- KARTU INFORMASI --}}
                    <div class="modal-tolak-info-box">

                        <div class="modal-tolak-info-grid">

                            <div class="modal-tolak-info-item">
                                <div class="modal-tolak-label">
                                    ID Pengajuan
                                </div>

                                <div class="modal-tolak-value" id="tolakId">
                                    -
                                </div>
                            </div>


                            <div class="modal-tolak-info-item">
                                <div class="modal-tolak-label">
                                    Nama Peminjam
                                </div>

                                <div class="modal-tolak-value" id="tolakPeminjam">
                                    -
                                </div>
                            </div>


                            <div class="modal-tolak-info-item">
                                <div class="modal-tolak-label">
                                    Nama Kegiatan
                                </div>

                                <div class="modal-tolak-value" id="tolakAgenda">
                                    -
                                </div>
                            </div>


                            <div class="modal-tolak-info-item">
                                <div class="modal-tolak-label">
                                    Ruangan
                                </div>

                                <div class="modal-tolak-value" id="tolakRuangan">
                                    -
                                </div>
                            </div>


                            <div class="modal-tolak-info-item">
                                <div class="modal-tolak-label">
                                    Tanggal Kegiatan
                                </div>

                                <div class="modal-tolak-value" id="tolakTanggal">
                                    -
                                </div>
                            </div>


                            <div class="modal-tolak-info-item">
                                <div class="modal-tolak-label">
                                    Waktu Kegiatan
                                </div>

                                <div class="modal-tolak-value" id="tolakWaktu">
                                    -
                                </div>
                            </div>

                        </div>

                    </div>


                    {{-- FORM ALASAN PENOLAKAN --}}
                    <div class="modal-tolak-section-heading">

                        <div>
                            <h6>Form Penolakan</h6>

                            <p>
                                Berikan alasan penolakan pengajuan peminjaman.
                            </p>
                        </div>

                        <span class="modal-tolak-index">02</span>

                    </div>


                    <div class="modal-tolak-form-group">

                        <label for="rejection_reason">
                            Alasan Penolakan
                            <span class="modal-tolak-required">*</span>
                        </label>

                        <textarea
                            name="rejection_reason"
                            id="rejection_reason"
                            rows="4"
                            maxlength="1000"
                            placeholder="Tuliskan alasan penolakan peminjaman..."
                            required></textarea>

                        <div class="modal-tolak-help">
                            Maksimal 1.000 karakter. Alasan ini akan disimpan
                            agar peminjam mengetahui penyebab pengajuannya ditolak.
                        </div>

                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="modal-tolak-footer">

                    <button type="button"
                        class="modal-tolak-button modal-tolak-secondary"
                        data-bs-dismiss="modal">

                        Batal

                    </button>


                    <button type="submit"
                        class="modal-tolak-button modal-tolak-primary"
                        onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan peminjaman ini?')">

                        <i class="bi bi-x-circle me-1"></i>
                        Konfirmasi Penolakan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- =====================================================
     CSS MODAL PENOLAKAN
===================================================== --}}

<style>

    /* MODAL UTAMA */
    #modalTolak .modal-dialog {
        max-width: 560px;
        width: calc(100% - 30px);
    }

    #modalTolak .modal-content {
        border: 1px solid #e1e5ea !important;
        border-radius: 7px !important;
        background: #ffffff !important;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(16, 39, 68, 0.12);
    }


    /* HEADER */
    #modalTolak .modal-tolak-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background: #ffffff !important;
        border-bottom: 1px solid #e1e5ea;
    }

    #modalTolak .modal-title {
        margin: 0;
        color: #102744 !important;
        font-size: 15px;
        font-weight: bold;
    }

    #modalTolak .modal-tolak-header small {
        display: block;
        margin-top: 3px;
        color: #707985;
        font-size: 11px;
    }

    #modalTolak .btn-close {
        box-shadow: none !important;
        opacity: 0.6;
    }


    /* BODY */
    #modalTolak .modal-tolak-body {
        padding: 22px;
        background: #ffffff;
    }


    /* JUDUL SECTION */
    #modalTolak .modal-tolak-section-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 13px;
    }

    #modalTolak .modal-tolak-section-heading h6 {
        margin: 0;
        color: #102744;
        font-size: 14px;
        font-weight: bold;
    }

    #modalTolak .modal-tolak-section-heading p {
        margin: 3px 0 0;
        color: #707985;
        font-size: 11px;
    }

    #modalTolak .modal-tolak-index {
        color: #9aa3ae;
        font-size: 12px;
        font-weight: bold;
    }


    /* KARTU INFORMASI */
    #modalTolak .modal-tolak-info-box {
        margin-bottom: 24px;
        padding: 18px;
        border: 1px solid #e1e5ea;
        border-radius: 6px;
        background: #f7f8fa;
    }

    #modalTolak .modal-tolak-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    #modalTolak .modal-tolak-info-item {
        min-width: 0;
    }

    #modalTolak .modal-tolak-label {
        margin-bottom: 4px;
        color: #707985;
        font-size: 11px;
    }

    #modalTolak .modal-tolak-value {
        color: #252b33;
        font-size: 13px;
        font-weight: bold;
        overflow-wrap: anywhere;
    }


    /* FORM ALASAN */
    #modalTolak .modal-tolak-form-group {
        margin-top: 3px;
    }

    #modalTolak .modal-tolak-form-group label {
        display: block;
        margin-bottom: 6px;
        color: #252b33;
        font-size: 12px;
        font-weight: bold;
    }

    #modalTolak .modal-tolak-required {
        color: #c0392b;
    }

    #modalTolak .modal-tolak-form-group textarea {
        display: block;
        width: 100%;
        min-height: 110px;
        padding: 11px 12px;
        border: 1px solid #e1e5ea;
        border-radius: 5px;
        background: #ffffff;
        color: #252b33;
        outline: none;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        line-height: 1.6;
        resize: vertical;
        box-shadow: none;
    }

    #modalTolak .modal-tolak-form-group textarea:focus {
        border-color: #17365d;
        outline: none;
        box-shadow: none;
    }

    #modalTolak .modal-tolak-form-group textarea::placeholder {
        color: #9aa3ae;
    }

    #modalTolak .modal-tolak-help {
        margin-top: 5px;
        color: #707985;
        font-size: 11px;
        line-height: 1.5;
    }


    /* FOOTER */
    #modalTolak .modal-tolak-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        padding: 16px 22px 20px;
        border-top: 1px solid #e1e5ea;
        background: #ffffff;
    }


    /* TOMBOL */
    #modalTolak .modal-tolak-button {
        display: inline-block;
        padding: 10px 16px;
        border: 1px solid transparent;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-weight: bold;
        transition: 0.2s;
    }

    #modalTolak .modal-tolak-secondary {
        border-color: #e1e5ea;
        background: #ffffff;
        color: #252b33;
    }

    #modalTolak .modal-tolak-secondary:hover {
        background: #f5f6f8;
    }

    #modalTolak .modal-tolak-primary {
        border-color: #17365d;
        background: #17365d;
        color: #ffffff;
    }

    #modalTolak .modal-tolak-primary:hover {
        border-color: #102744;
        background: #102744;
        color: #ffffff;
    }


    /* RESPONSIVE */
    @media (max-width: 500px) {

        #modalTolak .modal-dialog {
            width: calc(100% - 20px);
            margin: 10px auto;
        }

        #modalTolak .modal-tolak-body {
            padding: 15px;
        }

        #modalTolak .modal-tolak-info-grid {
            grid-template-columns: 1fr;
            gap: 13px;
        }

        #modalTolak .modal-tolak-footer {
            flex-direction: column-reverse;
            padding: 15px;
        }

        #modalTolak .modal-tolak-footer button {
            width: 100%;
        }

    }

</style>



{{-- =====================================================
     JAVASCRIPT MODAL PENOLAKAN
===================================================== --}}

<script>

    (function () {

        const modal = document.getElementById('modalTolak');

        if (!modal || modal.dataset.initialized === 'true') {
            return;
        }

        modal.dataset.initialized = 'true';


        document.addEventListener('click', function (event) {

            const button = event.target.closest(
                '[data-bs-target="#modalTolak"]'
            );

            if (!button) {
                return;
            }


            // MENGAMBIL ID PENGAJUAN
            const id = button.getAttribute('data-id');


            // MENGISI INFORMASI PEMINJAMAN
            document.getElementById('tolakId').textContent =
                id || '-';

            document.getElementById('tolakPeminjam').textContent =
                button.getAttribute('data-peminjam') || '-';

            document.getElementById('tolakAgenda').textContent =
                button.getAttribute('data-agenda') || '-';

            document.getElementById('tolakRuangan').textContent =
                button.getAttribute('data-ruangan') || '-';

            document.getElementById('tolakTanggal').textContent =
                button.getAttribute('data-tanggal') || '-';

            document.getElementById('tolakWaktu').textContent =
                button.getAttribute('data-waktu') || '-';


            // MENGATUR ACTION FORM
            document.getElementById('formTolak').action =
                "{{ url('/admin/events') }}/" +
                encodeURIComponent(id) +
                "/reject";


            // MENGOSONGKAN ALASAN SEBELUMNYA
            document.getElementById('rejection_reason').value = '';

        });

    })();

</script>