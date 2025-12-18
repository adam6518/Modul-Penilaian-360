@extends('layouts.app', ['title' => 'referensi'])

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
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari Nilai"
                                        data-col="2">
                                </div>
                            </th>

                            <th>
                                <div class="d-flex flex-column flex-lg-row gap-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Cari Status"
                                        data-col="3">
                                </div>
                            </th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="referensiTableBody">

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
        let referensiData = [];

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
                url: "/referensi/data",
                type: "GET",
                success: function(data) {
                    referensiData = data
                    renderTable(data)
                }
            })
        }

        function renderStatus(status) {
            if (status == 1) return '<span class="badge bg-success">Aktif</span>';
            return '';
        }

        function renderTable(data) {
            let rows = '';
            data.forEach((item, index) => {
                rows += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.referensi}</td>
                <td>
                    ${item.nilai !== null && !isNaN(item.nilai)
                    ? parseFloat(item.nilai).toFixed(2) + '%'
                    : '-'}
                </td>
                <td>${renderStatus(item.status)}</td>
                <td>
                    <button class="btn btn-primary btn-sm editBtn"
                        data-id="${item.id}"
                        data-referensi="${item.referensi}"
                        data-nilai="${item.nilai}">
                        Edit
                    </button>
                    <button class="btn btn-danger btn-sm deleteBtn"
                        data-id="${item.id}">
                        Hapus
                    </button>
                </td>
            </tr>
        `;
            });
            $('#referensiTableBody').html(rows);
        }

        $(document).ready(function() {
            loadData(); // initial load

            // Search
            $('thead input').on('keyup change', function() {
                const colIndex = $(this).data('col');
                const keyword = $(this).val().toLowerCase();

                const filtered = referensiData.filter(item => {
                    let value = '';

                    if (colIndex == 1) value = item.referensi;
                    if (colIndex == 2) value = parseFloat(item.nilai).toFixed(2);

                    return value.toLowerCase().includes(keyword);
                });

                renderTable(filtered);
            });


            // tombol tambah / batal (UI)
            $('#btnTambah').on('click', function() {
                $('#formTambah').removeClass('d-none');
                $(this).addClass('d-none');
            });

            $('#btnBatal').on('click', function() {
                resetForm();
            });

            // CREATE — ikat ke button dengan id spesifik
            $('#btnSimpan').on('click', function(e) {
                e.preventDefault();

                let nilaiRaw = $('#nilai').val();

                // normalisasi koma ke titik (defensive)
                nilaiRaw = nilaiRaw.replace(',', '.');

                const id = $('#referensi_id').val();

                const payload = {
                    referensi: $('#referensi').val(),
                    nilai: parseFloat(nilaiRaw)
                };

                let url = '/referensi/store';
                if (id) url = '/referensi/update/' + id;
                if (isNaN(payload.nilai)) {
                    showMessage('Nilai harus berupa angka (gunakan titik, bukan koma)', 'error');
                    return;
                }


                $.post(url, payload)
                    .done(function() {
                        loadData();
                        resetForm();
                        showToast('Data berhasil disimpan');
                    })
                    .fail(function(xhr) {
                        showToast('Validasi gagal', 'error');
                    });
            });

            // EDIT
            // Set form value
            $(document).on('click', '.editBtn', function() {
                $('#referensi_id').val($(this).data('id'));
                $('#referensi').val($(this).data('referensi'))
                $('#nilai').val(parseFloat(nilai).toFixed(2));

                // Tampilkan form
                $('#formTambah').removeClass('d-none');
                $('#btnTambah').addClass('d-none');
            })

            // RESET FORM SETELAH EDIT SELESAI
            function resetForm() {
                $('#referensi_id').val('');
                $('#referensi').val('');
                $('#nilai').val('');
                $('#formTambah').addClass('d-none');
                $('#btnTambah').removeClass('d-none');
            }

            // DELETE
            $(document).on('click', '.deleteBtn', function() {
                if (!confirm('Yakin hapus referensi ini?')) return;

                const id = $(this).data('id');

                $.ajax({
                    url: '/referensi/delete/' + id,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: {
                        'Accept': 'application/json'
                    }
                }).done(function() {
                    loadData();
                    showToast('Referensi berhasil dihapus');
                }).fail(function(jqXHR) {
                    console.error('Delete gagal:', jqXHR);
                    showMessage('Gagal menghapus referensi.', 'error')
                })
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
