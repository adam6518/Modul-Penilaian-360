@extends('layouts.app', ['title' => 'Manajemen Periode Pegawai'])

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/periode-pegawai.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/periode-pegawai.js') }}"></script>
@endpush

@section('content')
    <div class="employee-period-page">

        <section class="employee-period-hero">
            <div class="employee-period-hero-copy">
                <div class="employee-period-eyebrow">
                    <i class="bi bi-people"></i>
                    WORKSPACE / DATA PEGAWAI
                </div>
                <h1>Periode Pegawai</h1>
                <p>
                    Kelola keanggotaan pegawai dalam siklus penilaian. Pastikan data pegawai,
                    atasan, dan satuan kerja sudah sesuai sebelum evaluasi dimulai.
                </p>
                <div class="employee-period-hero-tags">
                    <span><i class="bi bi-diagram-3"></i> Relasi pegawai</span>
                    <span><i class="bi bi-arrow-repeat"></i> Sinkronisasi data</span>
                </div>
            </div>

            <div class="employee-period-hero-visual" aria-hidden="true">
                <div class="employee-visual-orbit orbit-a"></div>
                <div class="employee-visual-orbit orbit-b"></div>
                <div class="employee-visual-main">
                    <i class="bi bi-people-fill"></i>
                    <span>Employee</span>
                    <strong>Directory</strong>
                </div>
                <div class="employee-visual-float">
                    <i class="bi bi-check2-circle"></i>
                </div>
            </div>
        </section>

        <section class="employee-period-context">
            <div class="employee-period-context-heading">
                <div class="employee-context-icon">
                    <i class="bi bi-calendar2-week"></i>
                </div>
                <div>
                    <h2>Konteks periode</h2>
                    <p>Pilih periode yang akan digunakan untuk menampilkan data pegawai.</p>
                </div>
            </div>

            <div class="employee-period-context-controls">
                <div class="dropdown">
                    <button id="btnPeriode" type="button" class="btn btn-light dropdown-toggle employee-period-dropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-calendar3"></i>
                        <span>-- Pilih Periode --</span>
                    </button>
                    <ul class="dropdown-menu" id="periodeDropdown"></ul>
                </div>

                <button id="btnTampil" type="button" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                    Tampilkan data
                </button>
            </div>
        </section>

        <section class="employee-period-actions">
            <div class="employee-action-card">
                <div class="employee-action-icon action-sync">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div class="employee-action-copy">
                    <h3>Sinkronisasi pegawai</h3>
                    <p>Perbarui data pegawai untuk periode yang sedang dipilih.</p>
                </div>
                <button id="btnSync" type="button" class="btn btn-outline-primary d-none">
                    <i class="bi bi-arrow-repeat"></i>
                    Sinkronisasi
                </button>
            </div>

            <div class="employee-action-card employee-action-add">
                <div class="employee-action-icon action-add">
                    <i class="bi bi-person-plus"></i>
                </div>
                <div class="employee-action-copy">
                    <h3>Tambah periode pegawai</h3>
                    <p>Tambahkan keanggotaan pada periode yang sesuai.</p>
                </div>
                <button id="btnTambah" type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modalTambahPeriodePegawai">
                    <i class="bi bi-plus-lg"></i>
                    Tambah data
                </button>
            </div>
        </section>

        <section class="employee-period-danger d-none" id="employeePeriodDangerPanel">
            <div class="employee-danger-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="employee-danger-copy">
                <h3>Operasi data periode</h3>
                <p>
                    Tindakan penghapusan dapat memengaruhi data pegawai pada periode terpilih.
                    Pastikan periode sudah benar sebelum melanjutkan.
                </p>
            </div>
            <button id="btnDeletePeriode" type="button" class="btn btn-outline-danger d-none">
                <i class="bi bi-trash3"></i>
                Hapus data periode
            </button>
        </section>

        <section class="employee-period-table-panel">
            <div class="employee-period-table-heading">
                <div class="employee-table-heading-copy">
                    <div class="employee-table-heading-icon">
                        <i class="bi bi-card-list"></i>
                    </div>
                    <div>
                        <h2>Direktori pegawai periode</h2>
                        <p>Data relasi pegawai yang terdaftar dalam periode terpilih.</p>
                    </div>
                </div>

                <div class="employee-table-tools">
                    <span class="employee-table-indicator">
                        <span></span>
                        Data periode
                    </span>
                </div>
            </div>

            <div class="employee-filter-panel">
                <div class="employee-filter-title">
                    <i class="bi bi-funnel"></i>
                    Filter data
                </div>

                <div class="employee-filter-grid">
                    <div>
                        <label for="filterPeriode" class="form-label">ID Periode</label>
                        <input id="filterPeriode" type="text" class="form-control form-control-sm"
                            placeholder="Cari ID periode" data-field="id_periode">
                    </div>
                    <div>
                        <label for="filterAtasan" class="form-label">ID Atasan</label>
                        <input id="filterAtasan" type="text" class="form-control form-control-sm"
                            placeholder="Cari ID atasan" data-field="id_atasan">
                    </div>
                    <div>
                        <label for="filterNama" class="form-label">Nama pegawai</label>
                        <input id="filterNama" type="text" class="form-control form-control-sm" placeholder="Cari nama"
                            data-field="nama_pegawai">
                    </div>
                    <div>
                        <label for="filterNip" class="form-label">NIP</label>
                        <input id="filterNip" type="text" class="form-control form-control-sm" placeholder="Cari NIP"
                            data-field="nip">
                    </div>
                    <div>
                        <label for="filterPegawai" class="form-label">ID Pegawai</label>
                        <input id="filterPegawai" type="text" class="form-control form-control-sm"
                            placeholder="Cari ID pegawai" data-field="id_pegawai">
                    </div>
                    <div>
                        <label for="filterSatker" class="form-label">ID Satker</label>
                        <input id="filterSatker" type="text" class="form-control form-control-sm"
                            placeholder="Cari ID satker" data-field="id_satker">
                    </div>
                </div>
            </div>

            <div class="table-responsive employee-period-table-wrap">
                <table class="table employee-period-table align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Periode</th>
                            <th>Atasan</th>
                            <th>Identitas pegawai</th>
                            <th>NIP</th>
                            <th>ID Pegawai</th>
                            <th>ID Satker</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="periodePegawaiTableBody">
                        <tr>
                            <td colspan="8">
                                <div class="employee-period-empty">
                                    <span class="spinner-border spinner-border-sm"></span>
                                    Memuat data pegawai...
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="employee-period-table-footer">
                <span><i class="bi bi-database-check"></i> Direktori periode pegawai</span>
                <span><i class="bi bi-arrows-angle-expand"></i> Tabel mendukung scroll horizontal</span>
            </div>
        </section>

        <div class="modal fade employee-period-modal" id="modalTambahPeriodePegawai" tabindex="-1"
            aria-labelledby="modalTambahPeriodePegawaiLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="employee-modal-title">
                            <div class="employee-modal-icon"><i class="bi bi-person-plus"></i></div>
                            <div>
                                <h2 class="modal-title" id="modalTambahPeriodePegawaiLabel">Tambah periode pegawai</h2>
                                <p>Pilih periode untuk menambahkan data keanggotaan.</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        <label class="form-label" for="modalBtnPeriode">Periode tujuan</label>
                        <div class="dropdown w-100">
                            <button id="modalBtnPeriode" type="button"
                                class="btn btn-light dropdown-toggle w-100 employee-modal-period-button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                -- Pilih Periode --
                            </button>
                            <ul class="dropdown-menu w-100" id="modalPeriodeDropdown"></ul>
                        </div>

                        <div class="employee-modal-note">
                            <i class="bi bi-info-circle"></i>
                            <span>
                                Pastikan periode tujuan benar sebelum menjalankan proses penambahan.
                            </span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button id="btnModalSimpan" type="button" class="btn btn-primary">
                            <i class="bi bi-check2-circle"></i>
                            Tambahkan
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dangerPanel = document.getElementById('employeePeriodDangerPanel');
            const deleteButton = document.getElementById('btnDeletePeriode');
            const syncButton = document.getElementById('btnSync');

            function updateDangerPanel() {
                const isVisible = deleteButton && !deleteButton.classList.contains('d-none');

                if (dangerPanel) {
                    dangerPanel.classList.toggle('d-none', !isVisible);
                }
            }

            if (deleteButton) {
                const observer = new MutationObserver(updateDangerPanel);
                observer.observe(deleteButton, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            }

            if (syncButton) {
                const observer = new MutationObserver(function() {
                    syncButton.setAttribute(
                        'aria-hidden',
                        syncButton.classList.contains('d-none') ? 'true' : 'false'
                    );
                });

                observer.observe(syncButton, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            }

            updateDangerPanel();
        });
    </script>
@endsection
