@extends('layouts.app', ['title' => 'Manajemen Periode'])

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/periode.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/periode.js') }}"></script>
@endpush

@section('content')
    <div class="module-page period-page">

        <section class="module-hero period-hero">
            <div class="module-hero-copy">
                <div class="module-eyebrow">
                    <i class="bi bi-calendar-range"></i>
                    WORKSPACE / MANAJEMEN
                </div>
                <h1>Manajemen Periode</h1>
                <p>
                    Atur siklus penilaian kinerja secara terstruktur. Setiap periode menjadi
                    dasar pengelolaan pegawai dan proses evaluasi 360°.
                </p>
                <div class="hero-meta">
                    <span><i class="bi bi-shield-check"></i> Administrasi penilaian</span>
                    <span><i class="bi bi-arrow-repeat"></i> Siklus evaluasi</span>
                </div>
            </div>

            <div class="module-hero-visual" aria-hidden="true">
                <div class="period-calendar-art">
                    <div class="calendar-art-top">
                        <span></span><span></span><span></span>
                    </div>
                    <div class="calendar-art-heading">
                        <i class="bi bi-calendar3"></i>
                        <span>Evaluation Cycle</span>
                    </div>
                    <div class="calendar-art-grid">
                        @for ($i = 1; $i <= 21; $i++)
                            <span class="{{ in_array($i, [4, 5, 11, 12, 18]) ? 'selected' : '' }}">
                                {{ $i }}
                            </span>
                        @endfor
                    </div>
                    <div class="calendar-art-footer">
                        <span class="calendar-art-dot"></span>
                        Periode terjadwal
                    </div>
                </div>
            </div>
        </section>

        <section class="module-toolbar">
            <div class="module-toolbar-copy">
                <h2>Daftar periode</h2>
                <p>Kelola rentang waktu yang digunakan dalam evaluasi pegawai.</p>
            </div>

            <button id="btnTambah" type="button" class="btn btn-primary module-primary-btn">
                <i class="bi bi-plus-lg"></i>
                Buat periode baru
            </button>
        </section>

        <section id="formTambah" class="module-form-panel d-none">
            <div class="module-form-heading">
                <div class="module-form-icon">
                    <i class="bi bi-calendar2-plus"></i>
                </div>
                <div>
                    <h3 id="formPeriodeTitle">Informasi periode</h3>
                    <p>Lengkapi nama dan rentang tanggal periode penilaian.</p>
                </div>
            </div>

            <div class="module-form-content">
                <input type="hidden" id="periode_id">

                <div class="row g-4">
                    <div class="col-12">
                        <label for="nama_periode" class="form-label">Nama periode</label>
                        <input id="nama_periode" type="text" class="form-control"
                            placeholder="Contoh: Penilaian Semester I 2026">
                        <div class="form-text">Gunakan nama yang mudah dikenali oleh administrator dan pegawai.</div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="tanggal_awal" class="form-label">Tanggal mulai</label>
                        <div class="module-input-icon">
                            <i class="bi bi-calendar-event"></i>
                            <input id="tanggal_awal" type="date" class="form-control">
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="tanggal_akhir" class="form-label">Tanggal berakhir</label>
                        <div class="module-input-icon">
                            <i class="bi bi-calendar-check"></i>
                            <input id="tanggal_akhir" type="date" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="module-form-footer">
                <span class="module-form-note">
                    <i class="bi bi-info-circle"></i>
                    Periksa kembali rentang tanggal sebelum menyimpan.
                </span>
                <div class="d-flex gap-2">
                    <button id="btnBatal" type="button" class="btn btn-light">
                        Batal
                    </button>
                    <button id="btnSimpan" type="button" class="btn btn-primary">
                        <i class="bi bi-check2-circle"></i>
                        Simpan periode
                    </button>
                </div>
            </div>
        </section>

        <section class="module-table-panel">
            <div class="module-table-heading">
                <div class="module-table-heading-copy">
                    <div class="module-table-icon">
                        <i class="bi bi-calendar2-week"></i>
                    </div>
                    <div>
                        <h3>Semua periode</h3>
                        <p>Informasi periode yang tersimpan dalam sistem.</p>
                    </div>
                </div>

                <div class="module-table-actions">
                    <div class="module-search">
                        <i class="bi bi-search"></i>
                        <input type="search" id="searchPeriode" placeholder="Cari periode..." aria-label="Cari periode">
                    </div>
                    <button type="button" id="refreshPeriode" class="btn btn-light module-icon-btn"
                        aria-label="Muat ulang halaman">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </div>

            <div class="table-responsive module-table-wrap">
                <table class="table module-table align-middle">
                    <thead>
                        <tr>
                            <th class="module-number-col">No.</th>
                            <th>Nama periode</th>
                            <th>Tanggal mulai</th>
                            <th>Tanggal berakhir</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="periodeTableBody">
                        <tr>
                            <td colspan="6">
                                <div class="module-loading">
                                    <span class="spinner-border spinner-border-sm"></span>
                                    Memuat data periode...
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="module-table-footer">
                <span>Data periode penilaian</span>
                <span><i class="bi bi-database-check"></i> Terhubung ke sistem</span>
            </div>
        </section>

        <section class="module-tip">
            <div class="module-tip-icon"><i class="bi bi-lightbulb"></i></div>
            <div>
                <strong>Catatan pengelolaan periode</strong>
                <p>
                    Pastikan periode sudah sesuai sebelum mengimpor pegawai atau memulai penilaian.
                    Perubahan periode dapat memengaruhi konteks data evaluasi.
                </p>
            </div>
        </section>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const search = document.getElementById('searchPeriode');
                const refresh = document.getElementById('refreshPeriode');
                const body = document.getElementById('periodeTableBody');

                if (search && body) {
                    search.addEventListener('input', function() {
                        const keyword = this.value.toLowerCase().trim();

                        body.querySelectorAll('tr').forEach(function(row) {
                            row.style.display = row.innerText.toLowerCase().includes(keyword) ?
                                '' :
                                'none';
                        });
                    });
                }

                if (refresh) {
                    refresh.addEventListener('click', function() {
                        window.location.reload();
                    });
                }
            });
        </script>
    @endpush
@endsection
