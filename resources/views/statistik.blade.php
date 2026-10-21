@extends('layouts.app', ['title' => 'Statistik Penilaian'])

@push('styles')
    <style>
        .analytics-page {
            --analytics-accent: #4169e1;
        }

        .analytics-hero {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 235px;
            overflow: hidden;
            padding: 35px 40px;
            border: 1px solid #dce6fb;
            border-radius: 24px;
            background: linear-gradient(110deg, #fff, #eef4ff);
        }

        .analytics-hero-copy {
            position: relative;
            z-index: 2;
            max-width: 700px;
        }

        .analytics-eyebrow {
            margin-bottom: 15px;
            color: #4169e1;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1.3px;
        }

        .analytics-hero h1 {
            margin: 0;
            color: #172746;
            font-size: clamp(28px, 3vw, 38px);
            font-weight: 800;
            letter-spacing: -1.4px;
        }

        .analytics-hero p {
            max-width: 620px;
            margin: 13px 0 0;
            color: #6d7b94;
            font-size: 12px;
            line-height: 1.9;
        }

        .analytics-hero-art {
            display: grid;
            width: 100px;
            height: 100px;
            flex-shrink: 0;
            place-items: center;
            border: 1px solid rgba(65, 105, 225, .12);
            border-radius: 30px;
            background: rgba(255, 255, 255, .8);
            box-shadow: 0 20px 45px rgba(49, 75, 149, .1);
            color: #4169e1;
            font-size: 43px;
            transform: rotate(5deg);
        }

        .analytics-section-heading {
            margin: 31px 0 18px;
        }

        .analytics-section-heading span {
            color: #4169e1;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1.2px;
        }

        .analytics-section-heading h2 {
            margin: 7px 0 0;
            color: #1a2947;
            font-size: 17px;
            font-weight: 800;
        }

        .analytics-section-heading p {
            margin: 6px 0 0;
            color: #8590a5;
            font-size: 10px;
        }

        .analytics-chart-card {
            height: 100%;
            min-height: 355px;
            padding: 22px;
            border: 1px solid #e3e8f1;
            border-radius: 18px;
            background: #fff;
            box-shadow: var(--shadow-sm);
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .analytics-chart-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .analytics-chart-heading {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 22px;
        }

        .analytics-chart-icon {
            display: grid;
            width: 41px;
            height: 41px;
            flex-shrink: 0;
            place-items: center;
            border-radius: 12px;
            background: #edf2ff;
            color: #4169e1;
            font-size: 18px;
        }

        .analytics-chart-heading h3 {
            margin: 2px 0 0;
            color: #1d2b48;
            font-size: 12px;
            font-weight: 800;
        }

        .analytics-chart-heading p {
            margin: 5px 0 0;
            color: #8a95a9;
            font-size: 10px;
        }

        .analytics-chart-canvas {
            position: relative;
            height: 255px;
        }

        .analytics-chart-canvas canvas {
            max-width: 100%;
        }

        @media (max-width: 767.98px) {
            .analytics-hero {
                min-height: auto;
                padding: 26px 22px;
            }

            .analytics-hero-art {
                display: none;
            }

            .analytics-chart-card {
                min-height: 320px;
                padding: 18px;
            }

            .analytics-chart-canvas {
                height: 230px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/statistik.js') }}"></script>
@endpush

@section('content')
    <div class="analytics-page">
        <section class="analytics-hero">
            <div class="analytics-hero-copy">
                <div class="analytics-eyebrow">
                    <i class="bi bi-graph-up-arrow"></i>
                    ANALYTICS / PERFORMANCE INTELLIGENCE
                </div>
                <h1>Statistik Penilaian</h1>
                <p>
                    Analisis progres evaluasi, distribusi hasil, capaian indikator BerAKHLAK,
                    dan pegawai dengan nilai tertinggi berdasarkan data yang tersedia.
                </p>
            </div>
            <div class="analytics-hero-art" aria-hidden="true">
                <i class="bi bi-bar-chart-line"></i>
            </div>
        </section>

        <section class="analytics-section-heading">
            <span>PERFORMANCE INSIGHTS</span>
            <h2>Ikhtisar analitik</h2>
            <p>Gunakan grafik berikut untuk memahami kondisi penilaian dari beberapa sudut pandang.</p>
        </section>

        <div class="row g-3">
            <div class="col-12 col-xl-6">
                <article class="analytics-chart-card">
                    <div class="analytics-chart-heading">
                        <div class="analytics-chart-icon"><i class="bi bi-check2-square"></i></div>
                        <div>
                            <h3>Progress Penilaian</h3>
                            <p>Perbandingan progres penilaian berdasarkan data sistem.</p>
                        </div>
                    </div>
                    <div class="analytics-chart-canvas">
                        <canvas id="progressChart"></canvas>
                    </div>
                </article>
            </div>

            <div class="col-12 col-xl-6">
                <article class="analytics-chart-card">
                    <div class="analytics-chart-heading">
                        <div class="analytics-chart-icon"><i class="bi bi-pie-chart"></i></div>
                        <div>
                            <h3>Distribusi Nilai</h3>
                            <p>Gambaran distribusi hasil evaluasi.</p>
                        </div>
                    </div>
                    <div class="analytics-chart-canvas">
                        <canvas id="distribusiChart"></canvas>
                    </div>
                </article>
            </div>

            <div class="col-12 col-xl-6">
                <article class="analytics-chart-card">
                    <div class="analytics-chart-heading">
                        <div class="analytics-chart-icon"><i class="bi bi-bar-chart-steps"></i></div>
                        <div>
                            <h3>Indikator BerAKHLAK</h3>
                            <p>Perbandingan nilai pada setiap indikator.</p>
                        </div>
                    </div>
                    <div class="analytics-chart-canvas">
                        <canvas id="indikatorChart"></canvas>
                    </div>
                </article>
            </div>

            <div class="col-12 col-xl-6">
                <article class="analytics-chart-card">
                    <div class="analytics-chart-heading">
                        <div class="analytics-chart-icon"><i class="bi bi-trophy"></i></div>
                        <div>
                            <h3>Top Pegawai</h3>
                            <p>Peringkat pegawai berdasarkan data yang digunakan grafik.</p>
                        </div>
                    </div>
                    <div class="analytics-chart-canvas">
                        <canvas id="topChart"></canvas>
                    </div>
                </article>
            </div>
        </div>
    </div>
@endsection
