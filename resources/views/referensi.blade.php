@extends('layouts.app', ['title' => 'Konfigurasi Referensi'])

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/referensi.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/referensi.js') }}"></script>
@endpush

@section('content')
    <div class="module-page reference-page">

        <section class="module-hero reference-hero">
            <div class="module-hero-copy">
                <div class="module-eyebrow">
                    <i class="bi bi-sliders"></i>
                    WORKSPACE / KONFIGURASI
                </div>
                <h1>Indikator & Bobot</h1>
                <p>
                    Kelola referensi indikator yang menjadi dasar penghitungan nilai
                    penilaian kinerja. Pastikan kode, jenis, dan bobot sesuai dengan
                    aturan evaluasi yang berlaku.
                </p>
                <div class="reference-hero-pills">
                    <span><i class="bi bi-diagram-3"></i> Konfigurasi indikator</span>
                    <span><i class="bi bi-percent"></i> Pengaturan bobot</span>
                </div>
            </div>

            <div class="reference-hero-visual" aria-hidden="true">
                <div class="reference-orb orb-one"></div>
                <div class="reference-orb orb-two"></div>
                <div class="reference-settings-card">
                    <div class="reference-settings-top">
                        <span class="reference-settings-icon"><i class="bi bi-toggles"></i></span>
                        <span class="reference-settings-status">CONFIGURATION</span>
                    </div>
                    <div class="reference-settings-line line-long"></div>
                    <div class="reference-settings-line line-medium"></div>
                    <div class="reference-settings-progress">
                        <span></span>
                    </div>
                    <div class="reference-settings-footer">
                        <span>Indicator setup</span>
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            </div>
        </section>

        <section class="reference-overview">
            <div class="reference-overview-copy">
                <span class="reference-section-label">KONFIGURASI SAAT INI</span>
                <h2>Kontrol indikator penilaian</h2>
                <p>
                    Data di bawah merupakan ringkasan dari daftar referensi yang dimuat
                    oleh aplikasi. Periksa kesesuaian bobot sebelum proses evaluasi.
                </p>
            </div>

            <div class="reference-metric-grid">
                <article class="reference-metric">
                    <div class="reference-metric-icon metric-indigo">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <span>Total referensi</span>
                    <strong id="referenceTotal">—</strong>
                    <small>Data yang ditampilkan</small>
                </article>

                <article class="reference-metric">
                    <div class="reference-metric-icon metric-teal">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                    <span>Referensi aktif</span>
                    <strong id="referenceActive">—</strong>
                    <small>Status aktif dalam sistem</small>
                </article>

                <article class="reference-metric">
                    <div class="reference-metric-icon metric-amber">
                        <i class="bi bi-percent"></i>
                    </div>
                    <span>Jumlah bobot</span>
                    <strong id="referenceWeight">—</strong>
                    <small>Akumulasi bobot yang tampil</small>
                </article>
            </div>
        </section>

        <section class="reference-workspace">
            <div class="reference-workspace-heading">
                <div>
                    <div class="reference-section-label">MASTER DATA</div>
                    <h2>Daftar referensi</h2>
                    <p>Kelola indikator dan parameter yang digunakan dalam evaluasi.</p>
                </div>

                <button id="btnTambah" type="button" class="btn btn-primary reference-add-btn">
                    <i class="bi bi-plus-lg"></i>
                    Tambah referensi
                </button>
            </div>

            <section id="formTambah" class="reference-editor d-none">
                <div class="reference-editor-header">
                    <div class="reference-editor-symbol">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <h3>Editor referensi</h3>
                        <p>Isi seluruh field yang diperlukan sebelum menyimpan.</p>
                    </div>
                    <span class="reference-editor-tag">MASTER DATA</span>
                </div>

                <div class="reference-editor-body">
                    <input type="hidden" id="referensi_id">

                    <div class="row g-4">
                        <div class="col-12 col-lg-6">
                            <label for="referensi" class="form-label">Nama referensi</label>
                            <input id="referensi" type="text" class="form-control"
                                placeholder="Contoh: Berorientasi Pelayanan">
                            <div class="form-text">Nama yang ditampilkan pada tabel atau form penilaian.</div>
                        </div>

                        <div class="col-12 col-sm-6 col-lg-3">
                            <label for="kode" class="form-label">Kode indikator</label>
                            <select id="kode" class="form-select">
                                <option value="">Pilih kode</option>
                                <option value="atasan">Atasan</option>
                                <option value="sejawat">Sejawat</option>
                                <option value="bawahan">Bawahan</option>
                                @for ($i = 1; $i <= 7; $i++)
                                    <option value="col_0{{ $i }}">col_0{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-12 col-sm-6 col-lg-3">
                            <label for="jenis" class="form-label">Jenis referensi</label>
                            <input id="jenis" type="text" class="form-control" placeholder="Contoh: penilaian">
                        </div>

                        <div class="col-12 col-lg-5">
                            <label for="nilai" class="form-label">Bobot penilaian (%)</label>
                            <div class="reference-weight-input">
                                <input id="nilai" type="number" class="form-control" min="0" max="100"
                                    step="0.01" placeholder="0.00">
                                <span>%</span>
                            </div>
                            <div class="form-text">Masukkan angka tanpa tanda persen.</div>
                        </div>

                        <div class="col-12 col-lg-7">
                            <div class="reference-editor-info">
                                <i class="bi bi-info-circle"></i>
                                <div>
                                    <strong>Periksa kode dan jenis</strong>
                                    <p>
                                        Kode indikator dan jenis referensi harus konsisten dengan
                                        mekanisme pemrosesan data penilaian.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="reference-editor-footer">
                    <button id="btnBatal" type="button" class="btn btn-light">
                        Batalkan
                    </button>
                    <button id="btnSimpan" type="button" class="btn btn-primary">
                        <i class="bi bi-check2-circle"></i>
                        Simpan referensi
                    </button>
                </div>
            </section>

            <div class="reference-table-panel">
                <div class="reference-table-toolbar">
                    <div class="reference-table-intro">
                        <div class="reference-table-intro-icon">
                            <i class="bi bi-table"></i>
                        </div>
                        <div>
                            <h3>Master referensi</h3>
                            <p>Gunakan pencarian untuk menemukan data tertentu.</p>
                        </div>
                    </div>

                    <div class="reference-search">
                        <i class="bi bi-search"></i>
                        <input type="search" id="referenceSearch" placeholder="Cari nama atau kode...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table reference-table align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th>Referensi</th>
                                <th>Kode</th>
                                <th>Jenis</th>
                                <th>Bobot</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                            <tr class="reference-filter-row">
                                <th></th>
                                <th><input type="text" class="form-control form-control-sm"
                                        placeholder="Cari referensi" data-col="1"></th>
                                <th><input type="text" class="form-control form-control-sm" placeholder="Cari kode"
                                        data-col="2"></th>
                                <th><input type="text" class="form-control form-control-sm" placeholder="Cari jenis"
                                        data-col="3"></th>
                                <th><input type="text" class="form-control form-control-sm" placeholder="Cari bobot"
                                        data-col="4"></th>
                                <th><input type="text" class="form-control form-control-sm" placeholder="Cari status"
                                        data-col="5"></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="referensiTableBody">
                            <tr>
                                <td colspan="7">
                                    <div class="module-loading">
                                        <span class="spinner-border spinner-border-sm"></span>
                                        Memuat data referensi...
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="reference-table-footer">
                    <span><i class="bi bi-database-check"></i> Master data referensi</span>
                    <span>Bobot ditampilkan dalam persentase</span>
                </div>
            </div>
        </section>

        <section class="reference-guidance">
            <div class="reference-guidance-icon"><i class="bi bi-shield-check"></i></div>
            <div>
                <h3>Validasi konfigurasi</h3>
                <p>
                    Total bobot 100% merupakan patokan yang lazim digunakan apabila seluruh
                    indikator membentuk satu komposisi nilai. Pastikan aturan pembobotan ini
                    sesuai dengan ketentuan yang digunakan dalam project Anda.
                </p>
            </div>
        </section>
    </div>
@endsection
