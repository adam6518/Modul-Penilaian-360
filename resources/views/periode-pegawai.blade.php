@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/periode-pegawai.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/periode-pegawai.css') }}">
@endpush

@section('content')
    <h1 class="fw-bold mb-4">Periode Pegawai</h1>

    <div class="d-flex gap-5">
        {{-- Button Pilih Periode --}}
        <div class="mb-3">
            <button id="btnTampil" class="btn btn-secondary btn-sm w-sm">Tampilkan Periode Pegawai</button>
        </div>
        {{-- Button Hapus Periode --}}
        <div class="mb-3">
            <button id="btnDeletePeriode" class="btn btn-danger btn-sm" type="button">
                Hapus Semua Data Periode Ini
            </button>
        </div>

        {{-- Button Tambah Periode --}}
        <div class="mb-3">
            <button id="btnTambah" class="btn btn-success btn-sm w-sm">Tambah Periode Pegawai</button>
        </div>
    </div>

    {{-- Hidden Form --}}
    <div id="formTambah" class="card shadow-sm mb-4 d-none">
        <div class="card-body">
            <div class="row g-3">
                <input type="hidden" id="nama_periode">
                <div class="col-md-4">
                    <button id="btnPeriode"
                        class="btn dropdown-toggle btn-sm border border-black border-2 text-start w-75 text-center"
                        type="button" data-bs-toggle="dropdown">
                        -- Pilih Periode --
                    </button>

                    <ul class="dropdown-menu border border-black text-start w-25" id="periodeDropdown">
                    </ul>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <button id="btnSimpan" class="btn btn-primary btn-sm" type="button">Simpan</button>
                    <button id="btnBatal" class="btn btn-secondary btn-sm" type="button">Batal</button>
                </div>

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
                            <th>ID Periode</th>
                            <th>ID Atasan</th>
                            <th>Nama Pegawai</th>
                            <th>NIP</th>
                            <th>ID Pegawai</th>
                            <th>ID Satker</th>
                            <th>Aksi</th>
                        </tr>
                        {{-- Search Row (Responsive Bootstrap Only) --}}
                        <tr class="bg-light">

                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                </div>
                            </th>
                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari ID Periode"
                                        data-field="id_periode">
                                </div>
                            </th>

                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari ID Atasan"
                                        data-field="id_atasan">
                                </div>
                            </th>

                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Cari Nama Pegawai" data-field="nama_pegawai">
                                </div>
                            </th>
                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari NIP"
                                        data-field="nip">
                                </div>
                            </th>
                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari ID Pegawai"
                                        data-field="id_pegawai">
                                </div>
                            </th>
                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari ID Satker"
                                        data-field="id_satker">
                                </div>
                            </th>
                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="periodePegawaiTableBody">

                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
