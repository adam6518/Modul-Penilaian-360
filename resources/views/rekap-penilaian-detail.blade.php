@extends('layouts.app', ['title' => 'Detail Rekap Penilaian'])

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/rekap-penilaian.css') }}">
@endpush

@push('scripts')
    <script>
        const PERIODE_ID = {{ $periode->id }};
    </script>
    <script src="{{ asset('js/rekap-penilaian-detail.js') }}"></script>
@endpush

@section('content')
    <div class="report-page">
        <div class="report-breadcrumb">
            <a href="{{ route('rekap-penilaian.index') }}">
                <i class="bi bi-arrow-left"></i> Semua periode
            </a>
            <i class="bi bi-chevron-right"></i>
            <span>Detail periode</span>
        </div>

        <section class="report-hero report-detail-hero">
            <div class="report-hero-copy">
                <div class="report-eyebrow"><i class="bi bi-folder2-open"></i> PERIOD REPORT</div>
                <h1>{{ $periode->nama_periode }}</h1>
                <p>
                    Tinjau ringkasan data satuan kerja pada periode ini. Jalankan kalkulasi
                    sebelum mengekspor laporan agar hasil yang diekspor sesuai dengan data
                    yang telah diproses.
                </p>
                <div class="report-detail-tags">
                    <span><i class="bi bi-hash"></i> Periode ID {{ $periode->id }}</span>
                    <span><i class="bi bi-diagram-3"></i> Rekap per satuan kerja</span>
                </div>
            </div>
            <div class="report-hero-icon" aria-hidden="true">
                <i class="bi bi-clipboard-data"></i>
            </div>
        </section>

        <section class="report-operation-notice">
            <div class="report-notice-icon"><i class="bi bi-info-circle"></i></div>
            <div>
                <strong>Langkah sebelum ekspor</strong>
                <p>Jalankan kalkulasi penilaian terlebih dahulu jika hasil periode belum diperbarui.</p>
            </div>
        </section>

        <section class="report-section-heading report-detail-heading">
            <div>
                <span class="report-section-kicker">PERIOD BREAKDOWN</span>
                <h2>Ringkasan satuan kerja</h2>
                <p>Pilih satuan kerja untuk membuka daftar pegawai dan hasil penilaiannya.</p>
            </div>
            <div class="report-detail-actions">
                <button id="btnKalkulasi" type="button" class="btn btn-primary">
                    <i class="bi bi-calculator"></i> Kalkulasi penilaian
                </button>
                <a href="/rekap-penilaian/{{ $periode->id }}/export/excel" class="btn btn-outline-primary">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Ekspor Excel
                </a>
            </div>
        </section>

        <section class="report-list-panel">
            <div class="report-list-toolbar">
                <div class="report-list-title">
                    <div class="report-list-icon"><i class="bi bi-diagram-3"></i></div>
                    <div>
                        <h3>Daftar satuan kerja</h3>
                        <p>Ringkasan pegawai berdasarkan satuan kerja.</p>
                    </div>
                </div>
                <span class="report-data-badge"><i class="bi bi-database-check"></i> Rekap periode</span>
            </div>

            <div class="table-responsive">
                <table class="table report-table align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID satuan kerja</th>
                            <th>Jumlah pegawai</th>
                            <th class="text-end">Detail</th>
                        </tr>
                    </thead>
                    <tbody id="rekapSatkerTable">
                        <tr>
                            <td colspan="4">
                                <div class="report-empty-state">
                                    <span class="spinner-border spinner-border-sm"></span>
                                    Memuat data satuan kerja...
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="report-list-footer">
                <span><i class="bi bi-shield-check"></i> Rincian mengikuti data hasil kalkulasi</span>
                <span>Periode ID: {{ $periode->id }}</span>
            </div>
        </section>
    </div>
@endsection
