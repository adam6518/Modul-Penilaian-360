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
        // State untuk menyimpan hasil all data
        let periodePegawaiData = []

        // Fungsi untuk menampilkan list periode saat klik tombol "Tambah Periode"
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

        // Fungsi memanggil all data periode pegawai
        function loadData() {
            $.ajax({
                url: "https://api.jsonbin.io/v3/b/6954850a43b1c97be90f7a7b",
                type: "GET",
                success: function(res) {
                    let data = []

                    if (Array.isArray(res.record)) {
                        // JSONBin record langsung array
                        data = res.record
                    } else if (Array.isArray(res.record?.data)) {
                        // JSONBin record punya property data
                        data = res.record.data
                    }

                    periodePegawaiData = data
                    renderTable(data)
                },
                error: function(err) {
                    document.getElementById('periodePegawaiTableBody').innerHTML = `
                <tr>
                    <td colspan="8" class="text-center text-danger">
                        Gagal memuat data
                    </td>
                </tr>
            `;
                }
            })
        }

        // Fungsi memunculkan tabel periode pegawai    
        function renderTable(data) {
            let html = '';

            if (!Array.isArray(data)) data = []

            if (!data.length) {
                html = `
            <tr>
                <td colspan="8" class="text-center text-muted">
                    Data tidak tersedia
                </td>
            </tr>
        `;
            } else {
                data.forEach((item, index) => {
                    html += `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td class="text-center">${item.id_periode}</td>
                            <td class="text-center">${item.id_atasan}</td>
                            <td class="text-center">${item.nama_pegawai}</td>
                            <td class="text-center">${item.nip}</td>
                            <td class="text-center">${item.id_pegawai}</td>
                            <td class="text-center">${item.id_satker}</td>
                            <td class="text-center d-flex">
                                <button class="btn btn-sm btn-primary mx-2" onclick="edit(${item.id})">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="hapus(${item.id})">Hapus</button>
                            </td>
                        </tr>
            `;
                });
            }

            $('#periodePegawaiTableBody').html(html);
        }

        // Fungsi untuk hapus data
        function hapus(id) {
            fetch(`/periode-pegawai/delete/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => loadData());
        }

        $(document).ready(function() {
            loadData() // initial load

            //Search
            $('thead input').on('keyup change', function() {
                let filtered = periodePegawaiData

                $('thead input').each(function() {
                    const keyword = $(this).val().toLowerCase()
                    const field = $(this).data('field')

                    if (keyword) {
                        filtered = filtered.filter(item => {
                            return (item[field] ?? '')
                                .toString()
                                .toLowerCase()
                                .includes(keyword)
                        })
                    }
                })

                renderTable(filtered)
            })

        })
    </script>
@endsection
