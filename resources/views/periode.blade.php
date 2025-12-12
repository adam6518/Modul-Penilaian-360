@extends('layouts.app', ['title' => 'Periode'])

@section('content')
    <h1 class="fw-bold mb-4">Periode</h1>
    {{--  <div class="input-group mb-3 border border-secondary rounded-2" style="max-width: 100%;">
        <span class="input-group-text" <svg class="rounded-4" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
            viewBox="0 -960 960 960" fill="#888">
            <svg class="rounded-4" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 -960 960 960"
                fill="#888">
                <path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109
                                                                    75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252
                                                                    252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75
                                                                    0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
            </svg>
        </span>
        <input type="text" class="form-control form-control-sm border-start-0" placeholder="Cari informasi di sini...">
    </div>  --}}

    {{-- Button Tambah --}}
    <div class="mb-3">
        <button id="btnTambah" class="btn btn-success btn-sm">Tambah Periode</button>
    </div>

    {{-- Hidden Form --}}
    <div id="formTambah" class="card shadow-sm mb-4 d-none">
        <div class="card-body">

            <div class="row g-3">
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
        document.getElementById('btnTambah').addEventListener('click', function() {
            document.getElementById('formTambah').classList.remove('d-none');
            this.classList.add('d-none');
        });

        document.getElementById('btnBatal').addEventListener('click', function() {
            document.getElementById('formTambah').classList.add('d-none');
            document.getElementById('btnTambah').classList.remove('d-none');
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
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
                    let rows = "";
                    data.forEach((item, index) => {
                        rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.nama_periode}</td>
                        <td>${item.tanggal_awal}</td>
                        <td>${item.tanggal_akhir}</td>
                        <td>
                            <button class="btn btn-primary btn-sm editBtn" data-id="${item.id}">Edit</button>
                            <button class="btn btn-danger btn-sm deleteBtn" data-id="${item.id}">Hapus</button>
                        </td>
                    </tr>
                `;
                    });
                    $("#periodeTableBody").html(rows);
                }
            });
        }

        $(document).ready(function() {
            loadData(); // initial load

            // tombol tambah / batal (UI)
            $('#btnTambah').on('click', function() {
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

                // ambil nilai
                const payload = {
                    nama_periode: $('#nama_periode').val(),
                    tanggal_awal: $("#tanggal_awal").val(),
                    tanggal_akhir: $("#tanggal_akhir").val()
                    {{--  _token: '{{ csrf_token() }}'  --}}
                };

                // simple client validation
                if (!payload.nama_periode || !payload.tanggal_awal || !payload.tanggal_akhir) {
                    showMessage('Mohon isi semua field', 'error');
                    return;
                }

                $.ajax({
                        url: '/periode/store',
                        method: 'POST',
                        data: payload,
                        dataType: 'json',
                        headers: {
                            'Accept': 'application/json' // penting: minta JSON agar validation errors jadi JSON (422)
                        }
                    })
                    .done(function(response) {
                        // sukses -> refresh table
                        loadData();

                        // reset form
                        $('#nama_periode').val('');
                        $('#tanggal_awal').val('');
                        $('#tanggal_akhir').val('');

                        $('#formTambah').addClass('d-none');
                        $('#btnTambah').removeClass('d-none');

                        showMessage('Periode berhasil ditambahkan.');
                    })
                    .fail(function(jqXHR) {
                        // handling error (validation atau server)
                        if (jqXHR.status === 422) {
                            // validation errors
                            const errors = jqXHR.responseJSON.errors;
                            let messages = [];
                            for (let k in errors) {
                                messages.push(errors[k].join(', '));
                            }
                            showMessage('Validasi: ' + messages.join(' | '), 'error');
                        } else {
                            // other errors
                            console.error('Request gagal:', jqXHR);
                            showMessage('Terjadi kesalahan server. Cek console/network.');
                        }
                    });
            });

            // DELETE
            $(document).on('click', '.deleteBtn', function() {
                if (!confirm('Yakin ingin menghapus periode ini?')) return;

                let id = $(this).data('id');

                $.ajax({
                        url: '/periode/delete/' + id,
                        type: 'DELETE',
                        {{--  data: {
                            _token: '{{ csrf_token() }}'
                        },  --}}
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
