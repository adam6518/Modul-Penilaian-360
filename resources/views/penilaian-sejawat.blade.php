@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/penilaian-sejawat.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/penilaian-sejawat.css') }}">
@endpush

@section('content')
    <h1 class="fw-bold mb-4">Penilaian Sejawat</h1>
    <script>
        window.USER_PENILAI = @json($userPenilai); //userPenilai berasal dari func index di controller
    </script>
    <div id="formTambah" class="mb-4">
        <div class="d-flex gap-2">
            <div>
                <button id="btnPeriode" class="btn dropdown-toggle btn-sm border border-black border-2 text-start text-center"
                    type="button" data-bs-toggle="dropdown">
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
    <div class="row g-2 mb-3 d-none" id="formNilaiGlobal">
        <div class="col">
            <input type="number" class="form-control form-control-sm" id="nilai_ber" placeholder="Ber">
        </div>
        <div class="col">
            <input type="number" class="form-control form-control-sm" id="nilai_a1" placeholder="A">
        </div>
        <div class="col">
            <input type="number" class="form-control form-control-sm" id="nilai_k1" placeholder="K">
        </div>
        <div class="col">
            <input type="number" class="form-control form-control-sm" id="nilai_h" placeholder="H">
        </div>
        <div class="col">
            <input type="number" class="form-control form-control-sm" id="nilai_l" placeholder="L">
        </div>
        <div class="col">
            <input type="number" class="form-control form-control-sm" id="nilai_a2" placeholder="A">
        </div>
        <div class="col">
            <input type="number" class="form-control form-control-sm" id="nilai_k2" placeholder="K">
        </div>

        <div class="col-auto">
            <button id="btnApplyNilai" class="btn btn-primary btn-sm">
                Terapkan Nilai
            </button>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive overflow-x-auto">
                <table class="table table-hover align-middle table-bordered">
                    <thead class="table-dark text-center table-group-divider">
                        <tr>
                            <th>
                                <input type="checkbox" id="checkAll">
                                <span class="ms-1">Nama Ternilai</span>
                            </th>
                            <th>Nama Penilai</th>
                            <th>Ber</th>
                            <th>A</th>
                            <th>K</th>
                            <th>H</th>
                            <th>L</th>
                            <th>A</th>
                            <th>K</th>
                            <th>Aksi</th>
                        </tr>
                        {{-- Search Row (Responsive Bootstrap Only) --}}
                        <tr class="bg-light">
                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Cari Nama Ternilai" data-field="id_penilai">
                                </div>
                            </th>
                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                </div>
                            </th>
                            <th>
                            </th>
                            <th>
                            </th>
                            <th>
                            </th>
                            <th>
                            </th>
                            <th>
                            </th>
                            <th>
                            </th>
                            <th>
                            </th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="PenilaianAtasanTableBody">
                        {{-- DI SINI LOOPING DI JAVASCRIPT  --}}
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="d-flex justify-content-end mt-3">
        <button id="btnSubmitPenilaian" class="btn btn-success d-none">
            Simpan Penilaian
        </button>
    </div>
@endsection
