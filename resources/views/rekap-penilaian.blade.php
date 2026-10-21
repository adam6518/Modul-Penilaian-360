@extends('layouts.app', ['title' => 'Rekap Penilaian'])

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/rekap-penilaian.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/rekap-penilaian.js') }}"></script>
@endpush

@section('content')
    <div class="report-page">
        <section class="report-hero">
            <div class="report-hero-copy">
                <div class="report-eyebrow"><i class="bi bi-bar-chart-line"></i> ANALYTICS / REPORTING</div>
                <h1>Rekap Penilaian</h1>
                <p>
                    Telusuri hasil evaluasi berdasarkan periode, tinjau data satuan kerja,
                    dan akses laporan untuk kebutuhan analisis kinerja.
                </p>
            </div>
            <div class="report-hero-icon" aria-hidden="true">
                <i class="bi bi-file-earmark-bar-graph"></i>
            </div>
        </section>

        <section class="report-section-heading">
            <div>
                <span class="report-section-kicker">REPORT LIBRARY</span>
                <h2>Periode evaluasi</h2>
                <p>Pilih periode untuk membuka rincian hasil penilaian.</p>
            </div>
        </section>

        <section class="report-list-panel">
            <div class="report-list-toolbar">
                <div class="report-list-title">
                    <div class="report-list-icon"><i class="bi bi-calendar2-week"></i></div>
                    <div>
                        <h3>Daftar periode</h3>
                        <p>Periode yang tersedia untuk ditinjau.</p>
                    </div>
                </div>
                <div class="report-search">
                    <i class="bi bi-search"></i>
                    <input id="searchRekapPeriode" type="search" placeholder="Cari periode...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table report-table align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Periode penilaian</th>
                            <th class="text-end">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody id="rekapPeriodeTable">
                        <tr>
                            <td colspan="3">
                                <div class="report-empty-state">
                                    <span class="spinner-border spinner-border-sm"></span>
                                    Memuat daftar periode...
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="report-list-footer">
                <span><i class="bi bi-database-check"></i> Data bersumber dari periode penilaian</span>
                <span><i class="bi bi-arrow-right-circle"></i> Pilih periode untuk melihat detail</span>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const search = document.getElementById('searchRekapPeriode');
            const tbody = document.getElementById('rekapPeriodeTable');

            if (search && tbody) {
                search.addEventListener('input', function() {
                    const keyword = this.value.toLowerCase().trim();

                    tbody.querySelectorAll('tr').forEach(function(row) {
                        row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' :
                            'none';
                    });
                });
            }
        });
    </script>
@endsection
