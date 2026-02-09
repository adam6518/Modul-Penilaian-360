@extends('layouts.app')
@push('scripts')
    <script>
        const PERIODE_ID = {{ $periodeId }};
        const SATKER_ID = {{ $satkerId }};
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

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Ber</th>
                        <th>A</th>
                        <th>K</th>
                        <th>H</th>
                        <th>L</th>
                        <th>A</th>
                        <th>K</th>
                        <th>Total Nilai</th>
                    </tr>
                </thead>
                <tbody id="rekapPegawaiTable"></tbody>
            </table>
        </div>
    </div>
@endsection
