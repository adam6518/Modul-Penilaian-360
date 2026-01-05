@extends('layouts.app', ['title' => 'Periode'])

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
    {{-- Simple JS --}}
    <script>
        {{--  document.getElementById('btnTambah').addEventListener('click', function() {
            document.getElementById('formTambah').classList.remove('d-none');
            this.classList.add('d-none');
        });  --}}

        document.getElementById('btnBatal').addEventListener('click', function() {
            document.getElementById('formTambah').classList.add('d-none');
            document.getElementById('btnTambah').classList.remove('d-none');
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // State untuk menyimpan hasil all data
        let periodeData = [];

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // UTILITY: tampilkan pesan sederhana (bisa ganti ke toast)
        function showMessage(msg, type = 'success') {
            alert(msg); // sementara. Bisa ganti ke toast bootstrap nanti.
        }

        // Load data saat page pertama kali dibuka
        function loadData() {

            $.ajax({
                url: "/periode/data",
                type: "GET",
                success: function(data) {
                    periodeData = data
                    renderTable(data)
                }
            });
        }

        function renderStatus(status) {
            if (status == 1) return '<span class="badge bg-success">Aktif</span>';
            if (status == 0) return '<span class="badge bg-secondary">Selesai</span>';
            return '';
        }

        function renderTable(data) {
            let html = "";

            data.forEach((item, index) => {
                html += `
        <tr>
            <td>${index + 1}</td>
            <td>${item.nama_periode}</td>
            <td>${item.tanggal_awal}</td>
            <td>${item.tanggal_akhir}</td>
            <td>${renderStatus(item.status)}</td>
            <td>
                <button
                    type="button"
                    class="btn btn-primary btn-sm editBtn"
                    data-id="${item.id}"
                    data-nama="${item.nama_periode}"
                    data-awal="${item.tanggal_awal}"
                    data-akhir="${item.tanggal_akhir}">
                    Edit
                </button>
                <button
                    type="button"
                    class="btn btn-danger btn-sm deleteBtn"
                    data-id="${item.id}">
                    Hapus
                </button>
            </td>
        </tr>
        `;
            });

            $("#periodeTableBody").html(html);
        }

        $(document).ready(function() {
            loadData(); // initial load

            // Search
            $('thead input').on('keyup change', function() {
                const colIndex = $(this).data('col');
                const keyword = $(this).val().toLowerCase();

                const filtered = periodeData.filter(item => {
                    let value = '';

                    if (colIndex == 1) value = item.nama_periode;
                    if (colIndex == 2) value = item.tanggal_awal;
                    if (colIndex == 3) value = item.tanggal_akhir;

                    return (value ?? '').toString().toLowerCase().includes(keyword);
                });

                renderTable(filtered);
            });


            // tombol tambah / batal (UI)
            $('#btnTambah').on('click', function() {
                $('#periode_id').val('');
                $('#formTambah').removeClass('d-none');
                $(this).addClass('d-none');
            });

            $('#btnBatal').on('click', function() {
                $('#formTambah').addClass('d-none');
                $('#btnTambah').removeClass('d-none');
            });

            // CREATE — ikat ke button dengan id spesifik
            $('#btnSimpan').on('click', function(e) {
                e.preventDefault();

                const id = $('#periode_id').val();

                const payload = {
                    nama_periode: $('#nama_periode').val(),
                    tanggal_awal: $('#tanggal_awal').val(),
                    tanggal_akhir: $('#tanggal_akhir').val()
                };

                let url = '/periode/store';
                let method = 'POST';

                if (id) {
                    url = '/periode/update/' + id;
                }

                $.ajax({
                        url: url,
                        method: method,
                        data: payload,
                        dataType: 'json',
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .done(function() {
                        loadData();

                        // reset
                        $('#periode_id').val('');
                        $('#nama_periode').val('');
                        $('#tanggal_awal').val('');
                        $('#tanggal_akhir').val('');

                        $('#formTambah').addClass('d-none');
                        $('#btnTambah').removeClass('d-none');

                        showMessage('Data berhasil disimpan.');
                    })
                    .fail(function(jqXHR) {
                        if (jqXHR.status === 422) {
                            let msgs = [];
                            $.each(jqXHR.responseJSON.errors, function(_, v) {
                                msgs.push(v.join(', '));
                            });
                            showMessage(msgs.join(' | '), 'error');
                        } else {
                            showMessage('Terjadi kesalahan server.', 'error');
                        }
                    });
            });


            // EDIT
            $(document).on('click', '.editBtn', function() {
                $('#periode_id').val($(this).data('id'));
                $('#nama_periode').val($(this).data('nama'));
                $('#tanggal_awal').val($(this).data('awal'));
                $('#tanggal_akhir').val($(this).data('akhir'));

                $('#formTambah').removeClass('d-none');
                $('#btnTambah').addClass('d-none');
            });


            // DELETE
            $(document).on('click', '.deleteBtn', function() {
                if (!confirm('Yakin ingin menghapus periode ini?')) return;

                let id = $(this).data('id');

                $.ajax({
                        url: '/periode/delete/' + id,
                        type: 'DELETE',
                        dataType: 'json',
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .done(function() {
                        loadData();
                        showMessage('Periode berhasil dihapus.');
                    })
                    .fail(function(jqXHR) {
                        console.error('Delete gagal:', jqXHR);
                        showMessage('Gagal menghapus periode.', 'error');
                    });
            });

            // (Opsional) Edit handler skeleton — implement nanti
            $(document).on('click', '.btnEdit', function() {
                const id = $(this).data('id');
                // implement edit flow (modal atau inline)
                alert('Edit belum diimplement. id=' + id);
            });
        });
    </script>
@endsection
