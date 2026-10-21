@extends('layouts.app', ['title' => 'Penilaian Bawahan'])

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/penilaian-bawahan.css') }}">
@endpush

@push('scripts')
    <script>
        window.USER_PENILAI = @json($userPenilai);
        window.INDIKATOR = @json($indikator);
        window.APP_ROLE = @json(session('role'));
    </script>
    <script src="{{ asset('js/penilaian-bawahan.js') }}"></script>
@endpush

@section('content')
    <div class="evaluation-page evaluation-subordinate">

        {{-- HERO --}}
        <section class="evaluation-hero">
            <div class="evaluation-hero-content">
                <div class="evaluation-eyebrow">
                    <i class="bi bi-person-down"></i>
                    PERFORMANCE MANAGEMENT / 360°
                </div>

                <h1>Penilaian Bawahan</h1>

                <p>
                    Evaluasi kinerja bawahan secara objektif berdasarkan indikator perilaku
                    BerAKHLAK. Gunakan periode yang sesuai dan pastikan setiap nilai
                    mencerminkan hasil pengamatan Anda.
                </p>

                <div class="evaluation-hero-tags">
                    <span><i class="bi bi-person-check"></i> Evaluasi bawahan</span>
                    <span><i class="bi bi-list-check"></i> Berbasis indikator</span>
                    <span><i class="bi bi-shield-check"></i> Penilaian terstruktur</span>
                </div>
            </div>

            <div class="evaluation-hero-visual" aria-hidden="true">
                <div class="evaluation-orbit evaluation-orbit-large"></div>
                <div class="evaluation-orbit evaluation-orbit-small"></div>

                <div class="evaluation-hero-visual-card">
                    <div class="evaluation-visual-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <span>EMPLOYEE REVIEW</span>
                    <strong>360°</strong>
                    <div class="evaluation-visual-progress">
                        <span></span>
                    </div>
                </div>

                <div class="evaluation-visual-floating evaluation-floating-one">
                    <i class="bi bi-check2-circle"></i>
                </div>

                <div class="evaluation-visual-floating evaluation-floating-two">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
            </div>
        </section>

        {{-- PERIODE --}}
        <section class="evaluation-context-panel">
            <div class="evaluation-context-heading">
                <div class="evaluation-context-icon">
                    <i class="bi bi-calendar2-week"></i>
                </div>

                <div>
                    <h2>Periode penilaian</h2>
                    <p>Pilih periode untuk memuat daftar bawahan yang perlu Anda nilai.</p>
                </div>
            </div>

            <div class="evaluation-context-actions">
                <div class="dropdown evaluation-period-dropdown-wrapper">
                    <button id="btnPeriode" class="btn btn-light dropdown-toggle evaluation-period-button" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-calendar3"></i>
                        <span>-- Pilih Periode --</span>
                    </button>

                    <ul class="dropdown-menu" id="periodeDropdown"></ul>
                </div>

                <button id="btnTampil" type="button" class="btn btn-primary evaluation-load-button">
                    <i class="bi bi-arrow-right-circle"></i>
                    Tampilkan data
                </button>
            </div>
        </section>

        {{-- RINGKASAN --}}
        <section class="evaluation-overview-grid">
            <article class="evaluation-overview-card">
                <div class="evaluation-overview-icon overview-icon-primary">
                    <i class="bi bi-people"></i>
                </div>

                <div class="evaluation-overview-copy">
                    <span>Total bawahan</span>
                    <strong id="evaluationTargetCount">—</strong>
                    <small>Bawahan dalam daftar penilaian</small>
                </div>
            </article>

            <article class="evaluation-overview-card">
                <div class="evaluation-overview-icon overview-icon-success">
                    <i class="bi bi-check2-square"></i>
                </div>

                <div class="evaluation-overview-copy">
                    <span>Terpilih</span>
                    <strong id="evaluationSelectedCount">0</strong>
                    <small>Bawahan yang dipilih</small>
                </div>
            </article>

            <article class="evaluation-overview-card">
                <div class="evaluation-overview-icon overview-icon-purple">
                    <i class="bi bi-ui-checks"></i>
                </div>

                <div class="evaluation-overview-copy">
                    <span>Indikator</span>
                    <strong>{{ count($indikator) }}</strong>
                    <small>Parameter penilaian tersedia</small>
                </div>
            </article>
        </section>

        {{-- INPUT MASSAL --}}
        <section id="formNilaiGlobal" class="evaluation-bulk-panel d-none">
            <div class="evaluation-section-heading">
                <div>
                    <span class="evaluation-section-kicker">BULK INPUT</span>
                    <h2>Pengisian nilai massal</h2>
                    <p>
                        Masukkan nilai indikator, pilih bawahan pada tabel, lalu terapkan
                        nilai secara massal.
                    </p>
                </div>

                <span class="evaluation-bulk-badge">
                    <i class="bi bi-lightning-charge-fill"></i>
                    Aksi massal
                </span>
            </div>

            <div class="evaluation-bulk-grid">
                <div class="evaluation-score-field">
                    <label for="nilai_ber">BER</label>
                    <input type="number" id="nilai_ber" class="form-control" min="0" step="0.01" placeholder="0">
                </div>

                <div class="evaluation-score-field">
                    <label for="nilai_a1">A</label>
                    <input type="number" id="nilai_a1" class="form-control" min="0" step="0.01" placeholder="0">
                </div>

                <div class="evaluation-score-field">
                    <label for="nilai_k1">K</label>
                    <input type="number" id="nilai_k1" class="form-control" min="0" step="0.01" placeholder="0">
                </div>

                <div class="evaluation-score-field">
                    <label for="nilai_h">H</label>
                    <input type="number" id="nilai_h" class="form-control" min="0" step="0.01" placeholder="0">
                </div>

                <div class="evaluation-score-field">
                    <label for="nilai_l">L</label>
                    <input type="number" id="nilai_l" class="form-control" min="0" step="0.01"
                        placeholder="0">
                </div>

                <div class="evaluation-score-field">
                    <label for="nilai_a2">A</label>
                    <input type="number" id="nilai_a2" class="form-control" min="0" step="0.01"
                        placeholder="0">
                </div>

                <div class="evaluation-score-field">
                    <label for="nilai_k2">K</label>
                    <input type="number" id="nilai_k2" class="form-control" min="0" step="0.01"
                        placeholder="0">
                </div>
            </div>

            <div class="evaluation-bulk-footer">
                <p>
                    <i class="bi bi-info-circle"></i>
                    Nilai akan diterapkan pada bawahan yang dicentang.
                </p>

                <button id="btnApplyNilai" type="button" class="btn btn-primary">
                    <i class="bi bi-check2-all"></i>
                    Terapkan nilai
                </button>
            </div>
        </section>

        {{-- DAFTAR BAWAHAN --}}
        <section class="evaluation-workspace-panel">
            <div class="evaluation-workspace-heading">
                <div>
                    <span class="evaluation-section-kicker">EVALUATION WORKSPACE</span>
                    <h2>Daftar bawahan</h2>
                    <p>
                        Pilih bawahan yang akan dinilai dan lengkapi nilai setiap indikator.
                    </p>
                </div>

                <div class="evaluation-list-tools">
                    <label class="evaluation-search">
                        <i class="bi bi-search"></i>
                        <input id="searchBawahan" type="search" placeholder="Cari nama atau NIP..."
                            aria-label="Cari bawahan">
                    </label>
                </div>
            </div>

            <div class="evaluation-guidance-strip">
                <i class="bi bi-info-circle-fill"></i>
                <span>
                    Pilih periode sebelum mengisi penilaian. Pastikan nilai seluruh indikator
                    sudah sesuai sebelum menyimpan.
                </span>
            </div>

            <div class="evaluation-table-wrap">
                <div class="table-responsive">
                    <table class="table evaluation-table align-middle">
                        <thead>
                            <tr>
                                <th class="evaluation-person-column">
                                    <label class="evaluation-select-all">
                                        <input type="checkbox" id="checkAll">
                                        <span>Bawahan</span>
                                    </label>
                                </th>

                                <th>Identitas penilai</th>

                                @foreach ($indikator as $item)
                                    <th class="text-center">
                                        {{ $item->referensi }}
                                    </th>
                                @endforeach

                                <th class="text-center">Status</th>
                            </tr>
                        </thead>

                        <tbody id="PenilaianBawahanTableBody">
                            <tr>
                                <td colspan="{{ count($indikator) + 3 }}">
                                    <div class="evaluation-empty-state">
                                        <div class="evaluation-empty-icon">
                                            <i class="bi bi-calendar2-week"></i>
                                        </div>

                                        <h3>Belum ada daftar bawahan</h3>

                                        <p>
                                            Pilih periode dan klik Tampilkan data untuk memulai.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="evaluation-table-footer">
                <span>
                    <i class="bi bi-arrows-angle-expand"></i>
                    Geser tabel secara horizontal untuk melihat seluruh indikator.
                </span>

                <span class="evaluation-secure-label">
                    <i class="bi bi-shield-lock"></i>
                    Penilaian terstruktur
                </span>
            </div>
        </section>

        {{-- SIMPAN --}}
        <section class="evaluation-submit-panel">
            <div class="evaluation-submit-copy">
                <div class="evaluation-submit-icon">
                    <i class="bi bi-clipboard2-check"></i>
                </div>

                <div>
                    <h3>Periksa penilaian sebelum menyimpan</h3>
                    <p>
                        Pastikan pegawai dan nilai indikator sudah sesuai sebelum mengirim data.
                    </p>
                </div>
            </div>

            <button id="btnSubmitPenilaian" type="button" class="btn btn-success evaluation-submit-button d-none">
                <i class="bi bi-cloud-check"></i>
                Simpan penilaian
            </button>
        </section>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.getElementById('PenilaianBawahanTableBody');
            const selectedCount = document.getElementById('evaluationSelectedCount');
            const targetCount = document.getElementById('evaluationTargetCount');
            const checkAll = document.getElementById('checkAll');
            const searchInput = document.getElementById('searchBawahan');

            function updateCounters() {
                const checkboxes = tableBody ?
                    tableBody.querySelectorAll('.checkTernilai') :
                    [];

                const selected = tableBody ?
                    tableBody.querySelectorAll('.checkTernilai:checked') :
                    [];

                if (selectedCount) {
                    selectedCount.textContent = selected.length;
                }

                if (targetCount) {
                    targetCount.textContent = checkboxes.length;
                }

                if (checkAll) {
                    checkAll.checked =
                        checkboxes.length > 0 &&
                        selected.length === checkboxes.length;

                    checkAll.indeterminate =
                        selected.length > 0 &&
                        selected.length < checkboxes.length;
                }
            }

            if (tableBody) {
                tableBody.addEventListener('change', function(event) {
                    if (event.target.matches('.checkTernilai')) {
                        updateCounters();
                    }
                });

                new MutationObserver(updateCounters).observe(tableBody, {
                    childList: true,
                    subtree: true
                });
            }

            if (checkAll && tableBody) {
                checkAll.addEventListener('change', function() {
                    tableBody.querySelectorAll('.checkTernilai').forEach(function(checkbox) {
                        checkbox.checked = checkAll.checked;
                        checkbox.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));
                    });

                    updateCounters();
                });
            }

            if (searchInput && tableBody) {
                searchInput.addEventListener('input', function() {
                    const keyword = this.value.toLowerCase().trim();

                    tableBody.querySelectorAll('tr').forEach(function(row) {
                        row.style.display = row.textContent.toLowerCase().includes(keyword) ?
                            '' :
                            'none';
                    });
                });
            }

            updateCounters();
        });
    </script>
@endsection
