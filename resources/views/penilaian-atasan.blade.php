@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/periode-pegawai.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/periode-pegawai.css') }}">
@endpush

@section('content')
    <h1 class="fw-bold mb-4">Periode Pegawai</h1>
    <div class="d-flex gap-3">
        <div id="formTambah" class="mb-4">
            <div class="d-flex gap-2">
                {{--  <input type="hidden" id="nama_periode">  --}}
                <div>
                    <button id="btnPeriode"
                        class="btn dropdown-toggle btn-sm border border-black border-2 text-start text-center" type="button"
                        data-bs-toggle="dropdown">
                        -- Pilih Periode --
                    </button>

                    <ul class="dropdown-menu border border-black text-start w-25" id="periodeDropdown">
                    </ul>
                </div>
                <div>
                    <button id="btnTampil" class="btn btn-primary btn-sm">
                        Tampilkan
                    </button>
                </div>
            </div>
        </div>
        <div>
            <div class="d-flex mb-3 gap-3">
                {{-- LEFT ACTION --}}
                <div class="d-flex gap-2">
                    <button id="btnSync" class="btn btn-warning btn-sm d-none">
                        Sync Periode Pegawai
                    </button>

                    <button id="btnDeletePeriode" class="btn btn-danger btn-sm d-none">
                        Hapus Semua Data Periode Ini
                    </button>
                </div>
                {{-- RIGHT ACTION --}}
                <div class="justify-content-end align-items-end">
                    <button id="btnTambah" class="btn btn-success btn-sm">
                        Tambah Periode Pegawai
                    </button>
                </div>
                {{-- MODAL TAMBAH PERIODE PEGAWAI --}}
                <div class="modal fade" id="modalTambahPeriodePegawai" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Periode Pegawai</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <label class="form-label fw-semibold">Pilih Periode</label>

                                <div class="dropdown w-100">
                                    <button id="modalBtnPeriode"
                                        class="btn btn-outline-secondary dropdown-toggle w-100 text-center"
                                        data-bs-toggle="dropdown">
                                        -- Pilih Periode --
                                    </button>

                                    <ul class="dropdown-menu w-100" id="modalPeriodeDropdown"></ul>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button id="btnModalSimpan" class="btn btn-success">
                                    Tambahkan
                                </button>
                            </div>
                        </div>
                    </div>
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
