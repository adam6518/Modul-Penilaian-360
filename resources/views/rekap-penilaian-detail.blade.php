@extends('layouts.app')
@push('scripts')
    <script>
        const PERIODE_ID = {{ $periode->id }};
        {{--  const PERIODE_EXCEL = {{ $periodeExcel }};  --}}
    </script>
    </script>
    <script src="{{ asset('js/rekap-penilaian-detail.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/rekap-penilaian.css') }}">
@endpush
@section('content')
    <h1 class="fw-bold mb-3">Rekap Penilaian - {{ $periode->nama_periode }}</h1>
    <span class="text-bg-dark p-2 rounded-2" style="font-size: 10px">Harap Klik Tombol "Kalkulasi Penilaian" Terlebih Dahulu
        Sebelum Export Excel
    </span>
    <div class="d-flex gap-2 mt-3">
        <div class="mb-3">
            <a href="/rekap-penilaian/{{ $periode->id }}/export/excel" class="btn btn-success btn-sm">
                Export Excel
            </a>
        </div>
        <div class="d-flex mb-3">
            <button id="btnKalkulasi" class="btn btn-warning btn-sm">
                Kalkulasi Penilaian
            </button>
        </div>
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
