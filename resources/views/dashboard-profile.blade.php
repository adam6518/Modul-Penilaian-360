@extends('layouts.app', ['title' => 'Dashboard Profile'])

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard-profile.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/dashboard-profile.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    <div class="profile-dashboard">

        <section class="profile-dashboard-hero">
            <div class="profile-dashboard-hero-copy">
                <div class="profile-dashboard-eyebrow">
                    <i class="bi bi-grid-1x2"></i>
                    PERFORMANCE OVERVIEW
                </div>
                <h1>{{ $role === 'admin' ? 'Dashboard Evaluasi Kinerja' : 'Dashboard Penilaian Saya' }}</h1>
                <p>
                    @if ($role === 'admin')
                        Pantau progres evaluasi, hasil penilaian pegawai, dan kondisi siklus penilaian dari satu dashboard.
                    @else
                        Lihat ringkasan hasil penilaian dan progres evaluasi Anda dalam periode yang sedang berjalan.
                    @endif
                </p>
                <div class="profile-dashboard-meta">
                    <span><i class="bi bi-shield-check"></i> Performance management</span>
                    <span><i class="bi bi-arrow-repeat"></i> Penilaian 360°</span>
                </div>
            </div>

            <div class="profile-dashboard-hero-visual" aria-hidden="true">
                <div class="profile-dashboard-orbit orbit-outer"></div>
                <div class="profile-dashboard-orbit orbit-inner"></div>
                <div class="profile-dashboard-hero-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div class="profile-dashboard-float">
                    <i class="bi bi-check2-circle"></i>
                </div>
            </div>
        </section>

        @if ($role === 'admin')
            <section class="profile-dashboard-section">
                <div class="profile-section-heading">
                    <div>
                        <span class="profile-section-kicker">ORGANIZATION OVERVIEW</span>
                        <h2>Ringkasan evaluasi</h2>
                        <p>Gambaran umum cakupan dan status penilaian.</p>
                    </div>
                    <a href="{{ route('rekap-penilaian.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        Buka rekap
                    </a>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <article class="profile-kpi-card kpi-employees">
                            <div class="profile-kpi-top">
                                <div class="profile-kpi-icon"><i class="bi bi-people-fill"></i></div>
                                <span class="profile-kpi-label">DATA PEGAWAI</span>
                            </div>
                            <div class="profile-kpi-value">{{ number_format($totalPegawai) }}</div>
                            <div class="profile-kpi-description">Pegawai dalam cakupan data dashboard</div>
                            <div class="profile-kpi-bottom">
                                <span><i class="bi bi-database"></i> Ringkasan organisasi</span>
                            </div>
                        </article>
                    </div>

                    <div class="col-12 col-md-4">
                        <article class="profile-kpi-card kpi-completed">
                            <div class="profile-kpi-top">
                                <div class="profile-kpi-icon"><i class="bi bi-check2-circle"></i></div>
                                <span class="profile-kpi-label">SUDAH DINILAI</span>
                            </div>
                            <div class="profile-kpi-value">{{ number_format($sudahDinilai) }}</div>
                            <div class="profile-kpi-description">Jumlah pegawai yang tercatat sudah dinilai</div>
                            <div class="profile-kpi-bottom">
                                <span><i class="bi bi-clipboard-check"></i> Status penilaian</span>
                            </div>
                        </article>
                    </div>

                    <div class="col-12 col-md-4">
                        <article class="profile-kpi-card kpi-pending">
                            <div class="profile-kpi-top">
                                <div class="profile-kpi-icon"><i class="bi bi-hourglass-split"></i></div>
                                <span class="profile-kpi-label">BELUM DINILAI</span>
                            </div>
                            <div class="profile-kpi-value">{{ number_format($belumDinilai) }}</div>
                            <div class="profile-kpi-description">Jumlah pegawai yang masih perlu ditinjau</div>
                            <div class="profile-kpi-bottom">
                                <span><i class="bi bi-exclamation-circle"></i> Perlu perhatian</span>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            @php
                $totalStatus = (float) $sudahDinilai + (float) $belumDinilai;
                $progressStatus = $totalStatus > 0 ? round(((float) $sudahDinilai / $totalStatus) * 100, 1) : 0;
            @endphp

            <section class="profile-progress-panel">
                <div class="profile-progress-copy">
                    <div class="profile-progress-icon"><i class="bi bi-activity"></i></div>
                    <div>
                        <span class="profile-section-kicker">EVALUATION COVERAGE</span>
                        <h2>Cakupan penilaian</h2>
                        <p>Perbandingan jumlah pegawai yang sudah dan belum dinilai berdasarkan ringkasan yang tersedia.</p>
                    </div>
                </div>

                <div class="profile-progress-value">{{ number_format($progressStatus, 1) }}%</div>

                <div class="progress profile-progress-bar">
                    <div class="progress-bar" role="progressbar" style="width: {{ $progressStatus }}%"
                        aria-valuenow="{{ $progressStatus }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="profile-progress-legend">
                    <span><i class="legend-dot legend-done"></i> Sudah dinilai
                        <strong>{{ number_format($sudahDinilai) }}</strong></span>
                    <span><i class="legend-dot legend-pending"></i> Belum dinilai
                        <strong>{{ number_format($belumDinilai) }}</strong></span>
                </div>
            </section>

            <section class="profile-dashboard-section">
                <div class="profile-section-heading">
                    <div>
                        <span class="profile-section-kicker">EMPLOYEE PERFORMANCE</span>
                        <h2>Ringkasan hasil pegawai</h2>
                        <p>Nilai per indikator dan total hasil yang tersedia dalam data dashboard.</p>
                    </div>
                </div>

                <div class="profile-employee-grid">
                    @forelse ($pegawai as $p)
                        <article class="profile-employee-card">
                            <div class="profile-employee-top">
                                <div class="profile-employee-avatar">
                                    {{ strtoupper(substr($p->nama_pegawai ?? 'P', 0, 1)) }}
                                </div>
                                <div class="profile-employee-identity">
                                    <h3>{{ $p->nama_pegawai }}</h3>
                                    <span>NIP {{ $p->nip ?: '—' }}</span>
                                </div>
                                <div class="profile-employee-more">
                                    <i class="bi bi-person-vcard"></i>
                                </div>
                            </div>

                            <div class="profile-score-grid">
                                @foreach ([['label' => 'BER', 'field' => 'col_01'], ['label' => 'A', 'field' => 'col_02'], ['label' => 'K', 'field' => 'col_03'], ['label' => 'H', 'field' => 'col_04'], ['label' => 'L', 'field' => 'col_05'], ['label' => 'A', 'field' => 'col_06'], ['label' => 'K', 'field' => 'col_07']] as $indicator)
                                    <div class="profile-score-item">
                                        <span>{{ $indicator['label'] }}</span>
                                        <strong>{{ number_format((float) ($p->{$indicator['field']} ?? 0), 2) }}</strong>
                                    </div>
                                @endforeach
                            </div>

                            <div class="profile-employee-total">
                                <span>Total nilai</span>
                                <strong>{{ number_format((float) ($p->total ?? 0), 2) }}</strong>
                            </div>
                        </article>
                    @empty
                        <div class="profile-dashboard-empty">
                            <i class="bi bi-people"></i>
                            <h3>Belum ada hasil pegawai</h3>
                            <p>Data hasil penilaian akan tampil di sini setelah tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            @if ($totalPage > 1)
                <nav class="profile-pagination" aria-label="Navigasi halaman pegawai">
                    <div class="profile-pagination-copy">
                        Halaman {{ $currentPage }} dari {{ $totalPage }}
                    </div>
                    <ul class="pagination">
                        <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="?page={{ max(1, $currentPage - 1) }}" aria-label="Sebelumnya">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $totalPage; $i++)
                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li class="page-item {{ $currentPage >= $totalPage ? 'disabled' : '' }}">
                            <a class="page-link" href="?page={{ min($totalPage, $currentPage + 1) }}"
                                aria-label="Berikutnya">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            @endif
        @endif

        @if ($role === 'user')
            <section class="profile-user-welcome">
                <div class="profile-user-welcome-icon"><i class="bi bi-person-check"></i></div>
                <div>
                    <span class="profile-section-kicker">PERSONAL OVERVIEW</span>
                    <h2>Perkembangan penilaian Anda</h2>
                    <p>Gunakan ringkasan berikut untuk memantau hasil dan progres penilaian.</p>
                </div>
            </section>

            @if ($nilaiSaya)
                <section class="profile-personal-score-panel">
                    <div class="profile-personal-score-heading">
                        <div>
                            <span class="profile-section-kicker">PERSONAL RESULT</span>
                            <h2>Hasil penilaian Anda</h2>
                            <p>Nilai per indikator yang tersedia pada hasil evaluasi.</p>
                        </div>
                        <div class="profile-total-score">
                            <span>Total nilai</span>
                            <strong>{{ number_format((float) $nilaiSaya->total, 2) }}</strong>
                        </div>
                    </div>

                    <div class="profile-personal-indicators">
                        @foreach ([['label' => 'BER', 'field' => 'col_01'], ['label' => 'A', 'field' => 'col_02'], ['label' => 'K', 'field' => 'col_03'], ['label' => 'H', 'field' => 'col_04'], ['label' => 'L', 'field' => 'col_05'], ['label' => 'A', 'field' => 'col_06'], ['label' => 'K', 'field' => 'col_07']] as $indicator)
                            <div class="profile-personal-indicator">
                                <div class="profile-indicator-label">{{ $indicator['label'] }}</div>
                                <strong>{{ number_format((float) ($nilaiSaya->{$indicator['field']} ?? 0), 2) }}</strong>
                                <div class="profile-indicator-track">
                                    <span
                                        style="width: {{ min(100, max(0, (float) ($nilaiSaya->{$indicator['field']} ?? 0))) }}%"></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @else
                <section class="profile-no-result">
                    <div class="profile-no-result-icon"><i class="bi bi-clipboard-data"></i></div>
                    <h2>Hasil penilaian belum tersedia</h2>
                    <p>Nilai pribadi akan ditampilkan setelah data hasil penilaian tersedia pada sistem.</p>
                </section>
            @endif

            <section class="profile-user-progress-grid">
                <article class="profile-user-progress-card">
                    <div class="profile-user-progress-top">
                        <div class="profile-user-progress-icon"><i class="bi bi-send-check"></i></div>
                        <span>PROGRES MEMBERI PENILAIAN</span>
                    </div>
                    <div class="profile-user-progress-value">
                        {{ $sudahDinilai }} <small>/ {{ $totalHarusDinilai }}</small>
                    </div>
                    <p>Jumlah pegawai yang sudah Anda nilai.</p>
                    <div class="progress profile-progress-bar">
                        <div class="progress-bar" style="width: {{ min(100, max(0, (float) $persen)) }}%"></div>
                    </div>
                    <div class="profile-user-progress-bottom">
                        <span>Progres</span>
                        <strong>{{ number_format((float) $persen, 1) }}%</strong>
                    </div>
                </article>

                <article class="profile-user-progress-card profile-user-progress-secondary">
                    <div class="profile-user-progress-top">
                        <div class="profile-user-progress-icon"><i class="bi bi-person-check"></i></div>
                        <span>PROGRES MENERIMA PENILAIAN</span>
                    </div>
                    <div class="profile-user-progress-value">
                        {{ $jumlahMenilaiSaya }} <small>/ {{ $totalYangHarusMenilaiDia }}</small>
                    </div>
                    <p>Jumlah pegawai yang telah memberikan penilaian kepada Anda.</p>
                    @php
                        $receivedProgress =
                            (float) $totalYangHarusMenilaiDia > 0
                                ? min(100, ((float) $jumlahMenilaiSaya / (float) $totalYangHarusMenilaiDia) * 100)
                                : 0;
                    @endphp
                    <div class="progress profile-progress-bar">
                        <div class="progress-bar" style="width: {{ $receivedProgress }}%"></div>
                    </div>
                    <div class="profile-user-progress-bottom">
                        <span>Progres</span>
                        <strong>{{ number_format($receivedProgress, 1) }}%</strong>
                    </div>
                </article>
            </section>

            <section class="profile-quick-links">
                <div>
                    <span class="profile-section-kicker">NEXT STEP</span>
                    <h2>Lanjutkan aktivitas penilaian</h2>
                    <p>Pilih jenis penilaian yang ingin Anda kerjakan.</p>
                </div>
                <div class="profile-quick-link-actions">
                    <a href="{{ route('penilaian-atasan.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-person-up"></i> Atasan
                    </a>
                    <a href="{{ route('penilaian-bawahan.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-person-down"></i> Bawahan
                    </a>
                    <a href="{{ route('penilaian-sejawat.index') }}" class="btn btn-primary">
                        <i class="bi bi-people"></i> Sejawat
                    </a>
                </div>
            </section>
        @endif

    </div>
@endsection
