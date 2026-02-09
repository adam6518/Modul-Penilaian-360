@extends('layouts.app', ['title' => 'referensi'])

@push('scripts')
    <script src="{{ asset('js/referensi.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/referensi.css') }}">
@endpush

@section('content')
    <h1 class="fw-bold mb-4">Referensi</h1>

    {{-- Button Tambah --}}
    <div class="mb-3">
        <button id="btnTambah" class="btn btn-success btn-sm">Tambah Referensi</button>
    </div>

    {{-- Hidden Form --}}
    <div id="formTambah" class="card shadow-sm mb-4 d-none">
        <div class="card-body">
            <div class="row g-3">
                <input type="hidden" id="referensi_id">

                <div class="col-md-4">
                    <label class="form-label">Referensi</label>
                    <input id="referensi" type="text" class="form-control form-control-sm">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kode</label>
                    <select id="kode" class="form-select form-select-sm">
                        <option value="">-- pilih --</option>
                        <option value="atasan">Atasan</option>
                        <option value="sejawat">Sejawat</option>
                        <option value="bawahan">Bawahan</option>
                        <option value="col_01">col_01</option>
                        <option value="col_02">col_02</option>
                        <option value="col_03">col_03</option>
                        <option value="col_04">col_04</option>
                        <option value="col_05">col_05</option>
                        <option value="col_06">col_06</option>
                        <option value="col_07">col_07</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jenis</label>
                    <input id="jenis" type="text" class="form-control form-control-sm">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nilai (%)</label>
                    <input class="form-control form-control-sm" id="nilai" type="number" name="nilai" step="0.01"
                        min="0" max="100" inputmode="decimal" placeholder="Contoh: 20 (Tanpa Ketik %)">
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <button id="btnSimpan" class="btn btn-primary btn-sm">Simpan</button>
                    <button id="btnBatal" class="btn btn-secondary btn-sm">Batal</button>
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
                            <th>Referensi</th>
                            <th>Kode</th>
                            <th>Jenis</th>
                            <th>Nilai</th>
                            <th>Status Akhir</th>
                            <th>Aksi</th>
                        </tr>
                        {{-- Search Row (Responsive Bootstrap Only) --}}
                        <tr class="bg-light">
                            <th></th>

                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari Referensi"
                                        data-col="1">
                                </div>
                            </th>

                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari Kode"
                                        data-col="2">
                                </div>
                            </th>

                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari Nilai"
                                        data-col="3">
                                </div>
                            </th>

                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari Status"
                                        data-col="4">
                                </div>
                            </th>

                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="referensiTableBody">

                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
