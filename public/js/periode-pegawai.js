document.addEventListener("DOMContentLoaded", function () {
    const btnTambah = document.getElementById("btnTambah");
    const btnBatal = document.getElementById("btnBatal");
    const formTambah = document.getElementById("formTambah");
    const btnTampil = document.getElementById("btnTampil");

    if (btnTambah) {
        btnTambah.addEventListener("click", function () {
            formTambah.classList.remove("d-none");
            btnTambah.classList.add("d-none");
            btnTampil.classList.add("d-none");
        });
    }

    if (btnTampil) {
        btnTampil.addEventListener("click", function () {
            formTambah.classList.remove("d-none");
            btnTambah.classList.add("d-none");
            btnTampil.classList.add("d-none");
            loadPeriode();
        });
    }

    if (btnBatal) {
        btnBatal.addEventListener("click", function () {
            formTambah.classList.add("d-none");
            btnTambah.classList.remove("d-none");
        });
    }
});

let selectedPeriode = null;
let periodePegawaiData = [];

/* ===============================
   CSRF SETUP
================================ */
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

/* ===============================
   LOAD PERIODE (DROPDOWN)
================================ */
function loadPeriode() {
    $.ajax({
        url: "/periode-pegawai/list",
        method: "GET",
        dataType: "json",
        success: function (data) {
            let html = "";

            if (!data.length) {
                html = `
                    <li>
                        <span class="dropdown-item text-muted">
                            Tidak ada periode
                        </span>
                    </li>`;
            } else {
                data.forEach((p) => {
                    html += `
                        <li>
                            <a href="#"
                               class="dropdown-item"
                               onclick="selectPeriode(${p.id}, '${p.nama_periode}')">
                                ${p.nama_periode}
                            </a>
                        </li>`;
                });
            }

            $("#periodeDropdown").html(html);
        },
        error: function () {
            $("#periodeDropdown").html(`
                <li>
                    <span class="dropdown-item text-danger">
                        Gagal memuat periode
                    </span>
                </li>`);
        },
    });
}

/* ===============================
   PILIH PERIODE
================================ */
function selectPeriode(id, nama) {
    selectedPeriode = id;
    $("#btnPeriode").text(nama);
}

/* ===============================
   IMPORT JSON → DB
================================ */
function importData() {
    if (!selectedPeriode) {
        alert("Pilih periode terlebih dahulu");
        return;
    }

    $.ajax({
        url: "/periode-pegawai/import",
        method: "POST",
        data: {
            periode_id: selectedPeriode,
        },
        success: function () {
            alert("Data berhasil ditambahkan ke database");
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert("Gagal menambahkan data");
        },
    });
}

/* ===============================
   LOAD DATA DARI DB
================================ */
function loadFromDb() {
    if (!selectedPeriode) {
        alert("Pilih periode terlebih dahulu");
        return;
    }

    $.ajax({
        url: "/periode-pegawai/show",
        method: "GET",
        data: {
            periode_id: selectedPeriode,
        },
        dataType: "json",
        success: function (data) {
            periodePegawaiData = data;
            renderTable(data);
        },
        error: function () {
            renderTable([]);
        },
    });
}

/* ===============================
   HAPUS DATA DARI DB
================================ */
function hapusData(id) {
    if (!confirm("Yakin ingin menghapus data ini?")) {
        return;
    }

    $.ajax({
        url: `/periode-pegawai/delete/${id}`,
        type: "DELETE",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function () {
            alert("Data berhasil dihapus");

            // reload table
            if (selectedPeriode) {
                tampilkanData(selectedPeriode);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert("Gagal menghapus data");
        },
    });
}

/* ===============================
   RENDER TABLE
================================ */
function renderTable(data) {
    let html = "";

    if (!data.length) {
        html = `
            <tr>
                <td colspan="8" class="text-center text-muted">
                    Data tidak tersedia
                </td>
            </tr>`;
    } else {
        data.forEach((item, index) => {
            html += `
                <tr>
                    <td class="text-center">${index + 1}</td>
                    <td class="text-center">${item.id_periode}</td>
                    <td class="text-center">${item.id_atasan}</td>
                    <td>${item.nama_pegawai}</td>
                    <td>${item.nip}</td>
                    <td>${item.id_pegawai}</td>
                    <td>${item.id_satker}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-danger" onClick="hapusData(${
                            item.id
                        })">
                            Hapus
                        </button>
                    </td>
                </tr>`;
        });
    }

    $("#periodePegawaiTableBody").html(html);
}

/* ===============================
   BUTTON HANDLER
================================ */
$(document).ready(function () {
    // MODE TAMBAH
    $("#btnTambah").on("click", function () {
        loadPeriode();

        $("#btnSimpan").text("Tambah").off("click").on("click", importData);

        $("#formTambah").removeClass("d-none");
    });

    // MODE TAMPIL
    $("#btnTampil").on("click", function () {
        loadPeriode();

        $("#btnSimpan").text("Tampilkan").off("click").on("click", loadFromDb);

        $("#formTambah").removeClass("d-none");
    });

    // DELETE ALL PERIODE
    $("#btnDeletePeriode").on("click", function () {
        if (!selectedPeriode) {
            alert("Silakan pilih periode terlebih dahulu");
            return;
        }

        if (!confirm("Yakin hapus semua data periode ini?")) {
            return;
        }

        $.ajax({
            url: "/periode-pegawai/delete-periode",
            method: "POST",
            data: {
                periode_id: selectedPeriode,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function () {
                alert("Data periode berhasil dihapus");
                renderTable([]);
            },
            error: function (xhr) {
                alert("Gagal menghapus data periode");
                console.error(xhr.responseText);
            },
        });
    });

    // BATAL
    $("#btnBatal").on("click", function () {
        selectedPeriode = null;
        $("#btnPeriode").text("-- Pilih Periode --");
        $("#formTambah").addClass("d-none");
    });
});
