@extends('layouts.app')
@push('scripts')
    <script>
        const PERIODE_ID = {{ $periodeId }};
        const SATKER_ID = {{ $satkerId }};
        const JUMLAH_INDIKATOR = {{ count($indikator) }};
    </script>
    <script src="{{ asset('js/rekap-penilaian-view.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/rekap-penilaian.css') }}">
@endpush
@section('content')
    <h1 class="fw-bold mb-4">
        Rekap Pegawai – Satker {{ $satkerId }}
    </h1>
    <div class="mb-3 text-end">
        <a href="/rekap-penilaian/{{ $periodeId }}/satker/{{ $satkerId }}/export/pdf" class="btn btn-danger btn-sm">
            Export PDF
        </a>
    </div>


    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        @foreach ($indikator as $item)
                            <th>{{ $item->referensi }}</th>
                        @endforeach
                        <th>Total Nilai</th>
                    </tr>
                </thead>
                <tbody id="rekapPegawaiTable"></tbody>
            </table>
        </div>
    </div>
@endsection
