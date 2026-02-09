@extends('layouts.app')
@push('scripts')
    <script>
        const PERIODE_ID = {{ $periode->id }};
    </script>
    <script src="{{ asset('js/rekap-penilaian-detail.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/rekap-penilaian.css') }}">
@endpush
@section('content')
    <h1 class="fw-bold mb-3">Rekap Penilaian - {{ $periode->nama_periode }}</h1>

    <div class="d-flex justify-content-between mb-3">
        <div></div>
        <button id="btnKalkulasi" class="btn btn-warning btn-sm">
            Kalkulasi Penilaian
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>ID Satker</th>
                        <th>Jumlah Pegawai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="rekapSatkerTable"></tbody>
            </table>
        </div>
    </div>
@endsection
