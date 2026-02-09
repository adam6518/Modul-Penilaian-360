@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/rekap-penilaian.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/rekap-penilaian.css') }}">
@endpush
@section('content')
    <h1 class="fw-bold mb-4">Rekap Penilaian</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Periode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="rekapPeriodeTable"></tbody>
            </table>
        </div>
    </div>
@endsection
