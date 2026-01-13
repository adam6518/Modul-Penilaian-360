@extends('layouts.app', ['title' => 'Periode'])

@push('scripts')
    <script src="{{ asset('js/periode.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/periode.css') }}">
@endpush

@section('content')
    <h1 class="fw-bold mb-4">Periode</h1>

    {{-- Button Tambah --}}
    <div class="mb-3">
        <button id="btnTambah" class="btn btn-success btn-sm">Tambah Periode</button>
    </div>

    {{-- Hidden Form --}}
    <div id="formTambah" class="card shadow-sm mb-4 d-none">
        <div class="card-body">
            <div class="row g-3">
                <input type="hidden" id="periode_id">

                <div class="col-md-4">
                    <label class="form-label">Nama Periode</label>
                    <input id="nama_periode" type="text" class="form-control form-control-sm">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tanggal Awal</label>
                    <input id="tanggal_awal" type="date" class="form-control form-control-sm">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tanggal Akhir</label>
                    <input id="tanggal_akhir" type="date" class="form-control form-control-sm">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <button id="btnSimpan" class="btn btn-primary btn-sm">Simpan</button>
                <button id="btnBatal" class="btn btn-secondary btn-sm">Batal</button>
            </div>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered">
                    <thead class="table-dark text-center table-group-divider">
                        <tr>
                            <th>No</th>
                            <th>Nama Periode</th>
                            <th>Tanggal Awal</th>
                            <th>Tanggal Akhir</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        {{-- Search Row (Responsive Bootstrap Only) --}}
                        <tr class="bg-light">
                            <th></th>

                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Cari Nama Periode" data-col="1">
                                </div>
                            </th>

                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari Tgl Awal"
                                        data-col="2">
                                </div>
                            </th>

                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari Tgl Akhir"
                                        data-col="3">
                                </div>
                            </th>

                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="periodeTableBody">

                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
