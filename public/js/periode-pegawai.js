document.addEventListener("DOMContentLoaded", function () {
    const btnTambah = document.getElementById("btnTambah");
    const formTambah = document.getElementById("formTambah");
    const btnTampil = document.getElementById("btnTampil");

    if (btnTambah) {
        btnTambah.addEventListener("click", function () {
            formTambah.classList.remove("d-none");
        });
    }

    if (btnTampil) {
        btnTampil.addEventListener("click", function () {
            loadPeriode();
        });
    }
});

let selectedPeriode = null;
let periodePegawaiData = [];
let periodeAktif = false;
let selectedPeriodeModal = null;

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
   PILIH DROPDOWN PERIODE MODAL
================================ */
function loadPeriodeForModal() {
    $.ajax({
        url: "/periode-pegawai/list",
        method: "GET",
        dataType: "json",
        success: function (data) {
            let html = "";

            if (!data.length) {
                html = `<li><span class="dropdown-item text-muted">Tidak ada periode</span></li>`;
            } else {
                data.forEach((p) => {
                    html += `
                        <li>
                            <a href="#"
                               class="dropdown-item"
                               onclick="selectPeriodeModal(${p.id}, '${p.nama_periode}')">
                                ${p.nama_periode}
                            </a>
                        </li>`;
                });
            }

            $("#modalPeriodeDropdown").html(html);
        },
    });
}

/* ===============================
   PILIH PERIODE
================================ */
function selectPeriode(id, nama) {
    selectedPeriode = id;
    periodeAktif = false;
    $("#btnPeriode").text(nama);

    // sembunyikan action sampai data ditampilkan
    $("#btnSync").addClass("d-none");
    $("#btnDeletePeriode").addClass("d-none");
}

/* ===============================
   PILIH PERIODE MODAL
================================ */
function selectPeriodeModal(id, nama) {
    selectedPeriodeModal = id;
    $("#modalBtnPeriode").text(nama);
}

/* ===============================
   CEK PERIODE EXISTS
================================ */
function checkPeriodeExists(periodeId, callback) {
    $.ajax({
        url: "/periode-pegawai/show",
        method: "GET",
        data: { periode_id: periodeId },
        success: function (data) {
            callback(data.length > 0);
        },
        error: function () {
            callback(false);
        },
    });
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
        success: function (res) {
            alert(`Berhasil menambahkan ${res.inserted} data`);
            loadFromDb();
        },
        error: function (xhr) {
            const res = xhr.responseJSON;
            alert(res?.message || "Gagal menambahkan data");
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

            // === PERIODE RESMI AKTIF ===
            periodeAktif = true;
            $("#btnSync").removeClass("d-none");
            $("#btnDeletePeriode").removeClass("d-none");
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
            loadFromDb();
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
   SYNC TABLE
================================ */
function syncPeriodePegawai() {
    if (!selectedPeriode) {
        alert("Pilih periode terlebih dahulu");
        return;
    }

    if (!confirm("Yakin ingin melakukan sync data periode pegawai?")) {
        return;
    }

    $.ajax({
        url: "/periode-pegawai/sync",
        method: "POST",
        data: {
            periode_id: selectedPeriode,
        },
        success: function (res) {
            alert(
                `Sync berhasil\n` +
                    `Tambah: ${res.summary.insert}\n` +
                    `Update: ${res.summary.update}\n` +
                    `Hapus: ${res.summary.delete}`,
            );

            // reload table setelah sync
            loadFromDb();
        },
        error: function (xhr) {
            const res = xhr.responseJSON;
            alert(res?.message || "Sync gagal");
            console.error(xhr.responseText);
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
    loadPeriode();
    // MODE TAMBAH
    $("#btnTambah").on("click", function () {
        selectedPeriodeModal = null;
        $("#modalBtnPeriode").text("-- Pilih Periode --");

        loadPeriodeForModal();

        const modal = new bootstrap.Modal(
            document.getElementById("modalTambahPeriodePegawai"),
        );
        modal.show();
        $("#btnSimpan").text("Tambah").off("click").on("click", importData);

        $("#formTambah").removeClass("d-none");
    });

    // SIMPAN DARI MODAL
    $("#btnModalSimpan").on("click", function () {
        if (!selectedPeriodeModal) {
            alert("Pilih periode terlebih dahulu");
            return;
        }

        checkPeriodeExists(selectedPeriodeModal, function (exists) {
            const endpoint = exists
                ? "/periode-pegawai/sync"
                : "/periode-pegawai/import";

            const actionLabel = exists ? "update (sync)" : "tambah";

            $.ajax({
                url: endpoint,
                method: "POST",
                data: {
                    periode_id: selectedPeriodeModal,
                },
                success: function (res) {
                    alert(
                        exists
                            ? `Sync berhasil\nTambah: ${res.summary.insert}\nUpdate: ${res.summary.update}\nHapus: ${res.summary.delete}`
                            : `Berhasil menambahkan ${res.inserted} data`,
                    );

                    bootstrap.Modal.getInstance(
                        document.getElementById("modalTambahPeriodePegawai"),
                    ).hide();

                    selectedPeriode = selectedPeriodeModal;
                    loadFromDb();
                },
                error: function (xhr) {
                    alert(xhr.responseJSON?.message || "Gagal memproses data");
                },
            });
        });
    });

    // MODE TAMPIL
    $("#btnTampil").on("click", function () {
        loadPeriode();

        $("#btnSimpan").text("Tampilkan").off("click").on("click", loadFromDb);

        $("#formTambah").removeClass("d-none");
        loadFromDb();
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
                // _token: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function () {
                alert("Data periode berhasil dihapus");
                renderTable([]);
                loadFromDb();

                // reset state
                periodeAktif = false;
                $("#btnSync").addClass("d-none");
                $("#btnDeletePeriode").addClass("d-none");
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
        periodeAktif = false;
        $("#btnPeriode").text("-- Pilih Periode --");
        $("#btnSync").addClass("d-none");
        $("#btnDeletePeriode").addClass("d-none");

        $("#formTambah").addClass("d-none");
    });

    // SYNC
    $("#btnSync").on("click", function () {
        syncPeriodePegawai();
    });
});
