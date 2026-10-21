@extends('layouts.app', ['title' => 'Penilaian Atasan'])

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/penilaian-atasan.css') }}">
@endpush

@push('scripts')
    <script>
        window.USER_PENILAI = @json($userPenilai);
        window.INDIKATOR = @json($indikator);
        window.APP_ROLE = @json(session('role'));
    </script>
    <script src="{{ asset('js/penilaian-atasan.js') }}"></script>
@endpush

@section('content')
    <div class="evaluation-page">

        <section class="evaluation-hero evaluation-hero-supervisor">
            <div class="evaluation-hero-content">
                <div class="evaluation-eyebrow">
                    <i class="bi bi-person-up"></i>
                    EVALUATION WORKSPACE
                </div>
                <h1>Penilaian Atasan</h1>
                <p>
                    Berikan penilaian secara objektif kepada atasan Anda berdasarkan
                    indikator perilaku dan nilai yang berlaku pada periode terpilih.
                </p>

                <div class="evaluation-hero-tags">
                    <span><i class="bi bi-shield-check"></i> Penilaian terstruktur</span>
                    <span><i class="bi bi-clipboard2-check"></i> Berbasis indikator</span>
                </div>
            </div>

            <div class="evaluation-hero-visual" aria-hidden="true">
                <div class="evaluation-visual-circle circle-large"></div>
                <div class="evaluation-visual-circle circle-small"></div>
                <div class="evaluation-visual-card">
                    <i class="bi bi-person-check-fill"></i>
                    <span>Performance Review</span>
                    <strong>360°</strong>
                </div>
            </div>
        </section>

        <section class="evaluation-context-panel">
            <div class="evaluation-context-heading">
                <div class="evaluation-context-icon">
                    <i class="bi bi-calendar2-check"></i>
                </div>
                <div>
                    <h2>Periode penilaian</h2>
                    <p>Pilih periode untuk memuat daftar atasan yang perlu dinilai.</p>
                </div>
            </div>

            <div class="evaluation-context-actions">
                <div class="dropdown">
                    <button id="btnPeriode" class="btn btn-light dropdown-toggle evaluation-period-button" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-calendar3"></i>
                        <span>-- Pilih Periode --</span>
                    </button>
                    <ul class="dropdown-menu" id="periodeDropdown"></ul>
                </div>

                <button id="btnTampil" type="button" class="btn btn-primary evaluation-load-button">
                    <i class="bi bi-arrow-right-circle"></i>
                    Tampilkan daftar
                </button>
            </div>
        </section>

        <section class="evaluation-overview-grid">
            <article class="evaluation-overview-card">
                <div class="evaluation-overview-icon overview-blue">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <span>Daftar ternilai</span>
                    <strong id="evaluationTargetCount">—</strong>
                    <small>Jumlah atasan yang dimuat</small>
                </div>
            </article>

            <article class="evaluation-overview-card">
                <div class="evaluation-overview-icon overview-teal">
                    <i class="bi bi-check2-square"></i>
                </div>
                <div>
                    <span>Terpilih</span>
                    <strong id="evaluationSelectedCount">0</strong>
                    <small>Pegawai yang dipilih</small>
                </div>
            </article>

            <article class="evaluation-overview-card">
                <div class="evaluation-overview-icon overview-purple">
                    <i class="bi bi-ui-checks"></i>
                </div>
                <div>
                    <span>Indikator</span>
                    <strong>{{ count($indikator) }}</strong>
                    <small>Parameter penilaian tersedia</small>
                </div>
            </article>
        </section>

        <section id="formNilaiGlobal" class="evaluation-bulk-panel d-none">
            <div class="evaluation-section-heading">
                <div>
                    <span class="evaluation-section-kicker">BULK INPUT</span>
                    <h2>Pengisian nilai massal</h2>
                    <p>Masukkan nilai untuk indikator yang tersedia, lalu terapkan ke pegawai terpilih.</p>
                </div>
                <div class="evaluation-bulk-badge">
                    <i class="bi bi-lightning-charge-fill"></i>
                    Aksi massal
                </div>
            </div>

            <div class="evaluation-bulk-grid">
                <div class="evaluation-score-field">
                    <label for="nilai_ber">BER</label>
                    <input type="number" id="nilai_ber" class="form-control form-control-sm" min="0" step="0.01"
                        placeholder="0">
                </div>
                <div class="evaluation-score-field">
                    <label for="nilai_a1">A</label>
                    <input type="number" id="nilai_a1" class="form-control form-control-sm" min="0" step="0.01"
                        placeholder="0">
                </div>
                <div class="evaluation-score-field">
                    <label for="nilai_k1">K</label>
                    <input type="number" id="nilai_k1" class="form-control form-control-sm" min="0" step="0.01"
                        placeholder="0">
                </div>
                <div class="evaluation-score-field">
                    <label for="nilai_h">H</label>
                    <input type="number" id="nilai_h" class="form-control form-control-sm" min="0" step="0.01"
                        placeholder="0">
                </div>
                <div class="evaluation-score-field">
                    <label for="nilai_l">L</label>
                    <input type="number" id="nilai_l" class="form-control form-control-sm" min="0" step="0.01"
                        placeholder="0">
                </div>
                <div class="evaluation-score-field">
                    <label for="nilai_a2">A</label>
                    <input type="number" id="nilai_a2" class="form-control form-control-sm" min="0" step="0.01"
                        placeholder="0">
                </div>
                <div class="evaluation-score-field">
                    <label for="nilai_k2">K</label>
                    <input type="number" id="nilai_k2" class="form-control form-control-sm" min="0"
                        step="0.01" placeholder="0">
                </div>
            </div>

            <div class="evaluation-bulk-footer">
                <span><i class="bi bi-info-circle"></i> Pilih pegawai terlebih dahulu agar nilai dapat diterapkan.</span>
                <button id="btnApplyNilai" type="button" class="btn btn-primary">
                    <i class="bi bi-check2-all"></i>
                    Terapkan nilai
                </button>
            </div>
        </section>

        <section class="evaluation-workspace-panel">
            <div class="evaluation-workspace-heading">
                <div>
                    <span class="evaluation-section-kicker">EVALUATION LIST</span>
                    <h2>Daftar atasan</h2>
                    <p>Pilih pegawai dan isi nilai sesuai indikator yang tersedia.</p>
                </div>

                <div class="evaluation-list-tools">
                    <div class="evaluation-search">
                        <i class="bi bi-search"></i>
                        <input type="search" data-field="id_penilai" placeholder="Cari nama ternilai...">
                    </div>
                </div>
            </div>

            <div class="evaluation-guidance-strip">
                <i class="bi bi-info-circle-fill"></i>
                <span>
                    Pastikan periode sudah dipilih. Gunakan checkbox untuk memilih pegawai,
                    lalu isi nilai setiap indikator sebelum menyimpan.
                </span>
            </div>

            <div class="table-responsive evaluation-table-wrap">
                <table class="table evaluation-table align-middle">
                    <thead>
                        <tr>
                            <th class="evaluation-person-column">
                                <label class="evaluation-select-all">
                                    <input type="checkbox" id="checkAll">
                                    <span>Pegawai ternilai</span>
                                </label>
                            </th>
                            <th>Nama penilai</th>
                            @foreach ($indikator as $item)
                                <th class="text-center">{{ $item->referensi }}</th>
                            @endforeach
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="PenilaianAtasanTableBody">
                        <tr>
                            <td colspan="{{ count($indikator) + 3 }}">
                                <div class="evaluation-empty-state">
                                    <div class="evaluation-empty-icon">
                                        <i class="bi bi-calendar2-week"></i>
                                    </div>
                                    <h3>Belum ada daftar penilaian</h3>
                                    <p>Pilih periode dan tekan Tampilkan daftar untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="evaluation-table-footer">
                <span><i class="bi bi-arrows-angle-expand"></i> Geser tabel secara horizontal untuk melihat seluruh
                    indikator.</span>
                <span class="evaluation-secure-label"><i class="bi bi-shield-lock"></i> Penilaian terstruktur</span>
            </div>
        </section>

        <section class="evaluation-submit-panel">
            <div class="evaluation-submit-copy">
                <div class="evaluation-submit-icon">
                    <i class="bi bi-clipboard2-check"></i>
                </div>
                <div>
                    <h3>Siap menyimpan penilaian?</h3>
                    <p>Periksa kembali nilai dan pegawai yang dipilih sebelum mengirim data.</p>
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
            const body = document.getElementById('PenilaianAtasanTableBody');
            const selectedCount = document.getElementById('evaluationSelectedCount');
            const targetCount = document.getElementById('evaluationTargetCount');
            const checkAll = document.getElementById('checkAll');

            function updateEvaluationCounters() {
                const checkboxes = body.querySelectorAll('.checkTernilai');
                const selected = body.querySelectorAll('.checkTernilai:checked');

                if (selectedCount) selectedCount.textContent = selected.length;
                if (targetCount) targetCount.textContent = checkboxes.length;

                if (checkAll && checkboxes.length) {
                    checkAll.checked = selected.length === checkboxes.length;
                    checkAll.indeterminate = selected.length > 0 && selected.length < checkboxes.length;
                }
            }

            if (body) {
                const observer = new MutationObserver(updateEvaluationCounters);
                observer.observe(body, {
                    childList: true,
                    subtree: true
                });

                body.addEventListener('change', function(event) {
                    if (event.target.matches('.checkTernilai')) {
                        updateEvaluationCounters();
                    }
                });
            }

            if (checkAll && body) {
                checkAll.addEventListener('change', function() {
                    body.querySelectorAll('.checkTernilai').forEach(function(checkbox) {
                        checkbox.checked = checkAll.checked;
                    });
                    updateEvaluationCounters();
                });
            }

            if (body) {
                updateEvaluationCounters();
            }
        });
    </script>
@endsection
