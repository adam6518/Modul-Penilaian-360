@extends('layouts.app', ['title' => 'Hasil Penilaian Pegawai'])

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/rekap-penilaian.css') }}">
@endpush

@push('scripts')
    <script>
        const PERIODE_ID = {{ $periodeId }};
        const SATKER_ID = {{ $satkerId }};
        const JUMLAH_INDIKATOR = {{ count($indikator) }};
    </script>
    <script src="{{ asset('js/rekap-penilaian-view.js') }}"></script>
@endpush

@section('content')
    <div class="report-page">
        <div class="report-breadcrumb">
            <a href="{{ route('rekap-penilaian.index') }}">
                <i class="bi bi-arrow-left"></i> Rekap penilaian
            </a>
            <i class="bi bi-chevron-right"></i>
            <span>Detail pegawai</span>
        </div>

        <section class="report-hero report-employee-hero">
            <div class="report-hero-copy">
                <div class="report-eyebrow"><i class="bi bi-people"></i> EMPLOYEE REPORT</div>
                <h1>Hasil Penilaian Pegawai</h1>
                <p>
                    Rincian hasil evaluasi per pegawai untuk satuan kerja yang dipilih.
                    Gunakan laporan ini untuk meninjau nilai indikator dan total hasil.
                </p>
                <div class="report-detail-tags">
                    <span><i class="bi bi-calendar3"></i> Periode ID {{ $periodeId }}</span>
                    <span><i class="bi bi-diagram-3"></i> Satker ID {{ $satkerId }}</span>
                    <span><i class="bi bi-list-check"></i> {{ count($indikator) }} indikator</span>
                </div>
            </div>
            <div class="report-hero-icon" aria-hidden="true">
                <i class="bi bi-person-lines-fill"></i>
            </div>
        </section>

        <section class="report-section-heading report-detail-heading">
            <div>
                <span class="report-section-kicker">EMPLOYEE BREAKDOWN</span>
                <h2>Rincian nilai</h2>
                <p>Unduh laporan PDF atau telusuri nilai indikator pada tabel berikut.</p>
            </div>
            <a href="/rekap-penilaian/{{ $periodeId }}/satker/{{ $satkerId }}/export/pdf" class="btn btn-primary">
                <i class="bi bi-file-earmark-pdf"></i> Ekspor PDF
            </a>
        </section>

        <section class="report-list-panel">
            <div class="report-list-toolbar">
                <div class="report-list-title">
                    <div class="report-list-icon"><i class="bi bi-table"></i></div>
                    <div>
                        <h3>Hasil per pegawai</h3>
                        <p>Nilai indikator dan total penilaian yang telah diproses.</p>
                    </div>
                </div>

                <div class="report-search">
                    <i class="bi bi-search"></i>
                    <input id="searchRekapPegawai" type="search" placeholder="Cari nama pegawai...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table report-table report-score-table align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama pegawai</th>
                            @foreach ($indikator as $item)
                                <th class="text-end">{{ $item->referensi }}</th>
                            @endforeach
                            <th class="text-end">Total nilai</th>
                        </tr>
                    </thead>
                    <tbody id="rekapPegawaiTable">
                        <tr>
                            <td colspan="{{ count($indikator) + 3 }}">
                                <div class="report-empty-state">
                                    <span class="spinner-border spinner-border-sm"></span>
                                    Memuat hasil penilaian pegawai...
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="report-list-footer">
                <span><i class="bi bi-database-check"></i> Data hasil penilaian</span>
                <span><i class="bi bi-arrows-angle-expand"></i> Tabel mendukung scroll horizontal</span>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const search = document.getElementById('searchRekapPegawai');
            const tbody = document.getElementById('rekapPegawaiTable');

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
