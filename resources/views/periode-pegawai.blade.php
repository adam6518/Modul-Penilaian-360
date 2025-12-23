@extends('layouts.app')

@section('content')
    <style>
        #btnTambah {
            background-color: #2E7D32;
        }

        .btn-primary {
            background-color: #1F3A5F;
        }

        .btn-danger {
            background-color: #C62828;
        }

        .btn-secondary {
            background-color: #4A6FA5;
        }
    </style>

    <h1 class="fw-bold mb-4">Periode Pegawai</h1>

    {{-- Button Tambah --}}
    <div class="mb-3">
        <button id="btnTambah" class="btn btn-success btn-sm">Tambah Periode Pegawai</button>
    </div>

    {{-- Hidden Form --}}
    <div id="formTambah" class="card shadow-sm mb-4 d-none">
        <div class="card-body">
            <div class="row g-3">
                <input type="hidden" id="nama_periode">
                <div class="col-md-4">
                    <button id="btnPeriode" class="btn dropdown-toggle btn-l border border-black border-2 text-start w-50"
                        type="button" data-bs-toggle="dropdown">
                        -- Pilih Periode --
                    </button>

                    <ul class="dropdown-menu border border-black text-start" id="periodeDropdown">
                        <li><a class="dropdown-item">Action</a></li>
                    </ul>
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
                                        data-col="1">
                                </div>
                            </th>

                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari ID Atasan"
                                        data-col="2">
                                </div>
                            </th>

                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Cari Nama Pegawai" data-col="3">
                                </div>
                            </th>
                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari NIP"
                                        data-col="3">
                                </div>
                            </th>
                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari ID Pegawai"
                                        data-col="3">
                                </div>
                            </th>
                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari ID Satker"
                                        data-col="3">
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

    <script>
        document.getElementById('btnTambah').addEventListener('click', function() {
            document.getElementById('formTambah').classList.remove('d-none');
            this.classList.add('d-none');
            loadPeriode();
        });
        document.getElementById('btnBatal').addEventListener('click', function() {
            document.getElementById('formTambah').classList.add('d-none');
            document.getElementById('btnTambah').classList.remove('d-none');
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function loadPeriode() {
            fetch('/periode/list')
                .then(res => res.json())
                .then(data => {
                    let list = '<li><a class="dropdown-item"></a></li>';
                    data.forEach(p => {
                        list += `<li>
                        <a href="#"
                           class="dropdown-item"
                           onclick="selectPeriode(${p.id}, '${p.nama_periode}')">
                           ${p.nama_periode}
                        </a>
                    </li>`;
                        {{--  option += `<option value="${p.id}">${p.nama_periode}</option>`;  --}}
                    });
                    document.getElementById('periodeDropdown').innerHTML = list;
                });
        }

        function selectPeriode(id, nama) {
            document.getElementById('periode_id').value = id;
            document.getElementById('btnPeriode').innerText = nama;
        }

        function loadData() {
            fetch('https://api.jsonbin.io/v3/qs/694a1a7c43b1c97be9ffd42c')
                .then(res => res.json())
                .then(res => {
                    const data = res.record; // ⬅️ INI KUNCI UTAMA

                    let html = '';
                    let no = 1;

                    if (!Array.isArray(data) || data.length === 0) {
                        html = `
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Data tidak tersedia
                        </td>
                    </tr>
                `;
                    } else {
                        data.forEach(row => {
                            html += `
                        <tr>
                            <td class="text-center">${no++}</td>
                            <td class="text-center">${row.id_periode}</td>
                            <td class="text-center">${row.id_atasan}</td>
                            <td class="text-center">${row.nama_pegawai}</td>
                            <td class="text-center">${row.nip}</td>
                            <td class="text-center">${row.id_pegawai}</td>
                            <td class="text-center">${row.id_satker}</td>
                            <td class="text-center d-flex">
                                <button class="btn btn-sm btn-primary mx-2" onclick="edit(${row.id})">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="hapus(${row.id})">Hapus</button>
                            </td>
                        </tr>
                    `;
                        });
                    }

                    document.getElementById('periodePegawaiTableBody').innerHTML = html;
                })
                .catch(err => {
                    console.error('API ERROR:', err);
                    document.getElementById('periodePegawaiTableBody').innerHTML = `
                <tr>
                    <td colspan="8" class="text-center text-danger">
                        Gagal memuat data
                    </td>
                </tr>
            `;
                });
        }

        document.addEventListener('DOMContentLoaded', loadData);

        function hapus(id) {
            fetch(`/periode-pegawai/delete/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => loadData());
        }

        document.addEventListener('DOMContentLoaded', loadData);
    </script>
@endsection
