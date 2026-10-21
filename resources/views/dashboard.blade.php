@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    @php
        $role = session('role', 'user');
        $isAdmin = $role === 'admin';
        $nama = $isAdmin ? 'Administrator' : session('active_user_nama', 'Pegawai');
    @endphp

    <section class="page-heading">
        <div class="page-heading-main">
            <div class="page-eyebrow">PERFORMANCE WORKSPACE</div>
            <h1 class="page-title">
                Selamat datang, {{ $nama }}
                <span aria-hidden="true">👋</span>
            </h1>
            <p class="page-description">
                @if ($isAdmin)
                    Kelola siklus penilaian, data pegawai, indikator, dan pantau hasil evaluasi dalam satu tempat.
                @else
                    Pantau perkembangan penilaian Anda dan berikan evaluasi kepada rekan kerja melalui satu platform.
                @endif
            </p>
        </div>

        <a href="{{ route('dashboard-profile.index') }}" class="btn btn-primary">
            <i class="bi bi-grid-1x2"></i>
            Buka Dashboard Profile
        </a>
    </section>

    <section class="welcome-banner mb-4">
        <div class="welcome-banner-content">
            <span class="welcome-banner-tag">
                <i class="bi bi-stars"></i>
                {{ $isAdmin ? 'ADMINISTRATOR WORKSPACE' : 'EMPLOYEE WORKSPACE' }}
            </span>

            <h2>
                {{ $isAdmin ? 'Bangun evaluasi kinerja yang lebih terukur.' : 'Setiap masukan membantu kita berkembang.' }}
            </h2>

            <p>
                {{ $isAdmin
                    ? 'Pastikan periode, data pegawai, dan konfigurasi indikator siap sebelum proses penilaian dimulai.'
                    : 'Selesaikan penilaian sesuai periode dan berkontribusi pada budaya kerja yang kolaboratif.' }}
            </p>

            <div class="welcome-banner-actions">
                @if ($isAdmin)
                    <a href="{{ route('periode.index') }}" class="btn btn-light">
                        <i class="bi bi-calendar-plus"></i>
                        Kelola Periode
                    </a>
                    <a href="{{ route('rekap-penilaian.index') }}" class="btn btn-outline-light">
                        <i class="bi bi-bar-chart-line"></i>
                        Lihat Rekap
                    </a>
                @else
                    <a href="{{ route('penilaian-atasan.index') }}" class="btn btn-light">
                        <i class="bi bi-play-circle"></i>
                        Mulai Penilaian
                    </a>
                    <a href="{{ route('dashboard-profile.index') }}" class="btn btn-outline-light">
                        <i class="bi bi-person-lines-fill"></i>
                        Lihat Profil
                    </a>
                @endif
            </div>
        </div>

        <div class="welcome-banner-art" aria-hidden="true">
            <div class="art-orbit art-orbit-one"></div>
            <div class="art-orbit art-orbit-two"></div>
            <div class="art-main-icon">
                <i class="bi bi-bullseye"></i>
            </div>
            <div class="art-floating art-floating-one">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <div class="art-floating art-floating-two">
                <i class="bi bi-check2-circle"></i>
            </div>
        </div>
    </section>

    <section class="mb-5">
        <div class="section-heading">
            <div>
                <h2 class="section-title">Akses cepat</h2>
                <p class="section-description">Pilih modul yang ingin Anda gunakan.</p>
            </div>
        </div>

        <div class="row g-3">
            @if ($isAdmin)
                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('periode.index') }}" class="quick-action-card">
                        <div class="quick-action-icon icon-blue">
                            <i class="bi bi-calendar3"></i>
                        </div>
                        <div class="quick-action-title">Periode Penilaian</div>
                        <div class="quick-action-description">Atur jadwal dan siklus evaluasi.</div>
                        <span class="quick-action-link">Buka modul <i class="bi bi-arrow-up-right"></i></span>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('periode-pegawai.index') }}" class="quick-action-card">
                        <div class="quick-action-icon icon-teal">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="quick-action-title">Data Pegawai</div>
                        <div class="quick-action-description">Kelola anggota dalam setiap periode.</div>
                        <span class="quick-action-link">Buka modul <i class="bi bi-arrow-up-right"></i></span>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('referensi.index') }}" class="quick-action-card">
                        <div class="quick-action-icon icon-purple">
                            <i class="bi bi-sliders"></i>
                        </div>
                        <div class="quick-action-title">Indikator & Bobot</div>
                        <div class="quick-action-description">Kelola konfigurasi referensi penilaian.</div>
                        <span class="quick-action-link">Buka modul <i class="bi bi-arrow-up-right"></i></span>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('rekap-penilaian.index') }}" class="quick-action-card">
                        <div class="quick-action-icon icon-orange">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                        </div>
                        <div class="quick-action-title">Rekap & Laporan</div>
                        <div class="quick-action-description">Tinjau hasil dan laporan evaluasi.</div>
                        <span class="quick-action-link">Buka modul <i class="bi bi-arrow-up-right"></i></span>
                    </a>
                </div>
            @else
                <div class="col-12 col-sm-6 col-xl-4">
                    <a href="{{ route('penilaian-atasan.index') }}" class="quick-action-card">
                        <div class="quick-action-icon icon-blue">
                            <i class="bi bi-person-up"></i>
                        </div>
                        <div class="quick-action-title">Penilaian Atasan</div>
                        <div class="quick-action-description">Berikan evaluasi terhadap atasan Anda.</div>
                        <span class="quick-action-link">Buka modul <i class="bi bi-arrow-up-right"></i></span>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-4">
                    <a href="{{ route('penilaian-bawahan.index') }}" class="quick-action-card">
                        <div class="quick-action-icon icon-teal">
                            <i class="bi bi-person-down"></i>
                        </div>
                        <div class="quick-action-title">Penilaian Bawahan</div>
                        <div class="quick-action-description">Evaluasi anggota tim yang menjadi tanggung jawab Anda.</div>
                        <span class="quick-action-link">Buka modul <i class="bi bi-arrow-up-right"></i></span>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-4">
                    <a href="{{ route('penilaian-sejawat.index') }}" class="quick-action-card">
                        <div class="quick-action-icon icon-purple">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="quick-action-title">Penilaian Sejawat</div>
                        <div class="quick-action-description">Berikan umpan balik kepada rekan kerja.</div>
                        <span class="quick-action-link">Buka modul <i class="bi bi-arrow-up-right"></i></span>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <section class="workflow-panel">
        <div class="section-heading">
            <div>
                <h2 class="section-title">Alur kerja penilaian 360°</h2>
                <p class="section-description">Gambaran umum tahapan dalam proses evaluasi kinerja.</p>
            </div>
            <span class="workflow-label">
                <i class="bi bi-diagram-3"></i>
                Workflow
            </span>
        </div>

        <div class="workflow-grid">
            <div class="workflow-step">
                <div class="workflow-step-number">01</div>
                <div class="workflow-step-icon"><i class="bi bi-calendar-check"></i></div>
                <h3>Persiapan</h3>
                <p>Periode dan data pegawai disiapkan oleh administrator.</p>
            </div>

            <div class="workflow-connector"><i class="bi bi-arrow-right"></i></div>

            <div class="workflow-step">
                <div class="workflow-step-number">02</div>
                <div class="workflow-step-icon"><i class="bi bi-clipboard2-check"></i></div>
                <h3>Penilaian</h3>
                <p>Evaluasi dilakukan berdasarkan relasi kerja dan indikator.</p>
            </div>

            <div class="workflow-connector"><i class="bi bi-arrow-right"></i></div>

            <div class="workflow-step">
                <div class="workflow-step-number">03</div>
                <div class="workflow-step-icon"><i class="bi bi-calculator"></i></div>
                <h3>Pengolahan</h3>
                <p>Nilai diproses sesuai mekanisme kalkulasi aplikasi.</p>
            </div>

            <div class="workflow-connector"><i class="bi bi-arrow-right"></i></div>

            <div class="workflow-step">
                <div class="workflow-step-number">04</div>
                <div class="workflow-step-icon"><i class="bi bi-graph-up"></i></div>
                <h3>Evaluasi Hasil</h3>
                <p>Hasil penilaian ditinjau melalui rekap dan statistik.</p>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .welcome-banner {
            position: relative;
            display: flex;
            align-items: center;
            min-height: 285px;
            overflow: hidden;
            border-radius: 24px;
            background: linear-gradient(115deg, #172a50 0%, #243d78 55%, #3557a5 100%);
            box-shadow: 0 18px 40px rgba(27, 48, 93, .15);
            color: #fff;
        }

        .welcome-banner-content {
            position: relative;
            z-index: 2;
            width: 72%;
            padding: 36px 40px;
        }

        .welcome-banner-tag {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 10px;
            border: 1px solid rgba(255, 255, 255, .16);
            border-radius: 8px;
            background: rgba(255, 255, 255, .08);
            color: #cbd8ff;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .welcome-banner h2 {
            max-width: 590px;
            margin: 18px 0 10px;
            font-size: clamp(23px, 3vw, 33px);
            font-weight: 800;
            letter-spacing: -1.1px;
            line-height: 1.25;
        }

        .welcome-banner p {
            max-width: 580px;
            margin-bottom: 20px;
            color: #c0cce7;
            font-size: 12px;
            line-height: 1.9;
        }

        .welcome-banner-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
        }

        .welcome-banner .btn {
            min-height: 38px;
            font-size: 11px;
        }

        .welcome-banner .btn-light {
            border-color: #fff;
            background: #fff;
            color: #213b78;
        }

        .welcome-banner .btn-outline-light {
            border-color: rgba(255, 255, 255, .35);
            color: #fff;
        }

        .welcome-banner .btn-outline-light:hover {
            background: rgba(255, 255, 255, .1);
        }

        .welcome-banner-art {
            position: absolute;
            top: 0;
            right: 0;
            width: 36%;
            height: 100%;
            pointer-events: none;
        }

        .art-orbit {
            position: absolute;
            top: 50%;
            left: 50%;
            border: 1px solid rgba(255, 255, 255, .13);
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        .art-orbit-one {
            width: 245px;
            height: 245px;
        }

        .art-orbit-two {
            width: 180px;
            height: 180px;
        }

        .art-main-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            display: grid;
            place-items: center;
            width: 108px;
            height: 108px;
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 32px;
            background: linear-gradient(145deg, rgba(255, 255, 255, .22), rgba(255, 255, 255, .06));
            box-shadow: 0 20px 50px rgba(0, 0, 0, .15);
            color: #fff;
            font-size: 49px;
            transform: translate(-50%, -50%) rotate(-7deg);
        }

        .art-floating {
            position: absolute;
            display: grid;
            place-items: center;
            width: 47px;
            height: 47px;
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 15px;
            background: rgba(255, 255, 255, .14);
            box-shadow: 0 12px 30px rgba(0, 0, 0, .12);
            color: #fff;
            font-size: 20px;
            backdrop-filter: blur(8px);
        }

        .art-floating-one {
            top: 24%;
            left: 19%;
        }

        .art-floating-two {
            right: 17%;
            bottom: 22%;
        }

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .section-title {
            margin: 0;
            color: var(--text-primary);
            font-size: 16px;
            font-weight: 800;
            letter-spacing: -.4px;
        }

        .section-description {
            margin: 5px 0 0;
            color: var(--text-secondary);
            font-size: 11px;
        }

        .quick-action-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 210px;
            padding: 21px;
            border: 1px solid var(--border);
            border-radius: 17px;
            background: #fff;
            box-shadow: var(--shadow-sm);
            transition: transform 180ms ease, box-shadow 180ms ease, border-color 180ms ease;
        }

        .quick-action-card:hover {
            transform: translateY(-4px);
            border-color: #d3ddff;
            box-shadow: var(--shadow-md);
        }

        .quick-action-icon {
            display: grid;
            place-items: center;
            width: 43px;
            height: 43px;
            margin-bottom: 17px;
            border-radius: 13px;
            font-size: 20px;
        }

        .icon-blue {
            background: #edf2ff;
            color: #4169e1;
        }

        .icon-teal {
            background: #e4f8f5;
            color: #12998e;
        }

        .icon-purple {
            background: #f2ecff;
            color: #8862d9;
        }

        .icon-orange {
            background: #fff2e5;
            color: #cf8436;
        }

        .quick-action-title {
            margin-bottom: 7px;
            color: var(--text-primary);
            font-size: 13px;
            font-weight: 800;
        }

        .quick-action-description {
            flex: 1;
            color: var(--text-secondary);
            font-size: 11px;
            line-height: 1.8;
        }

        .quick-action-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 17px;
            padding-top: 12px;
            border-top: 1px solid var(--border);
            color: var(--primary);
            font-size: 10px;
            font-weight: 800;
        }

        .workflow-panel {
            padding: 25px;
            border: 1px solid var(--border);
            border-radius: 20px;
            background: #fff;
            box-shadow: var(--shadow-sm);
        }

        .workflow-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 8px;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 10px;
            font-weight: 800;
        }

        .workflow-grid {
            display: grid;
            grid-template-columns: 1fr 22px 1fr 22px 1fr 22px 1fr;
            align-items: center;
            gap: 8px;
            margin-top: 25px;
        }

        .workflow-step {
            position: relative;
            min-height: 174px;
            padding: 19px 16px;
            border: 1px solid var(--border);
            border-radius: 15px;
            background: #fbfcff;
        }

        .workflow-step-number {
            position: absolute;
            top: 13px;
            right: 13px;
            color: #d1d8e7;
            font-size: 11px;
            font-weight: 800;
        }

        .workflow-step-icon {
            display: grid;
            place-items: center;
            width: 39px;
            height: 39px;
            margin-bottom: 15px;
            border-radius: 12px;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 17px;
        }

        .workflow-step h3 {
            margin-bottom: 7px;
            color: var(--text-primary);
            font-size: 12px;
            font-weight: 800;
        }

        .workflow-step p {
            margin: 0;
            color: var(--text-secondary);
            font-size: 10px;
            line-height: 1.8;
        }

        .workflow-connector {
            display: grid;
            place-items: center;
            color: #9caedb;
            font-size: 17px;
        }

        @media (max-width: 1199.98px) {
            .welcome-banner-content {
                width: 78%;
                padding: 30px;
            }

            .welcome-banner-art {
                width: 30%;
                opacity: .7;
            }

            .workflow-grid {
                grid-template-columns: 1fr 20px 1fr;
                row-gap: 13px;
            }

            .workflow-grid .workflow-connector:nth-of-type(4) {
                display: none;
            }
        }

        @media (max-width: 767.98px) {
            .welcome-banner {
                min-height: auto;
            }

            .welcome-banner-content {
                width: 100%;
                padding: 26px 23px;
            }

            .welcome-banner-art {
                right: -100px;
                width: 260px;
                opacity: .16;
            }

            .welcome-banner h2 {
                font-size: 25px;
            }

            .workflow-panel {
                padding: 18px;
            }

            .workflow-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .workflow-step {
                min-height: auto;
            }

            .workflow-connector {
                display: none;
            }

            .workflow-step-icon {
                margin-bottom: 10px;
            }
        }
    </style>
@endpush
