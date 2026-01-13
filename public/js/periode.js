// Pertama kali halaman dibuka akan menjalankan loadData()
document.addEventListener("DOMContentLoaded", function () {
    const btnTambah = document.getElementById("btnTambah");
    const btnBatal = document.getElementById("btnBatal");
    const formTambah = document.getElementById("formTambah");

    if (btnTambah) {
        btnTambah.addEventListener("click", function () {
            formTambah.classList.remove("d-none");
            btnTambah.classList.add("d-none");
            loadPeriode();
        });
    }

    if (btnBatal) {
        btnBatal.addEventListener("click", function () {
            formTambah.classList.add("d-none");
            btnTambah.classList.remove("d-none");
        });
    }

    loadData();
});

// State untuk menyimpan hasil all data
let periodeData = [];

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// UTILITY: tampilkan pesan sederhana
function showMessage(msg, type = "success") {
    alert(msg);
}

// Fungsi untuk menampilkan data saat pertama kali halaman dibuka
function loadData() {
    $.ajax({
        url: "/periode/data",
        type: "GET",
        success: function (data) {
            console.log(data);
            
            periodeData = data;
            renderTable(data);
        },
    });
}

// Fungsi untuk menampilkan status di tabel periode
function renderStatus(status) {
    if (status == 1) return '<span class="badge bg-success">Aktif</span>';
    if (status == 0) return '<span class="badge bg-secondary">Selesai</span>';
    return "";
}

// Fungsi untuk menampilkan tabel beserta datanya
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

$(document).ready(function () {
    loadData();

    // Search
    $("thead input").on("keyup change", function () {
        const colIndex = $(this).data("col");
        const keyword = $(this).val().toLowerCase();

        const filtered = periodeData.filter((item) => {
            let value = "";

            if (colIndex == 1) value = item.nama_periode;
            if (colIndex == 2) value = item.tanggal_awal;
            if (colIndex == 3) value = item.tanggal_akhir;

            return (value ?? "").toString().toLowerCase().includes(keyword);
        });

        renderTable(filtered);
    });

    // tombol tambah / batal (UI)
    $("#btnTambah").on("click", function () {
        $("#periode_id").val("");
        $("#formTambah").removeClass("d-none");
        $(this).addClass("d-none");
    });

    $("#btnBatal").on("click", function () {
        $("#formTambah").addClass("d-none");
        $("#btnTambah").removeClass("d-none");
    });

    // CREATE — ikat ke button dengan id spesifik
    $("#btnSimpan").on("click", function (e) {
        e.preventDefault();

        const id = $("#periode_id").val();

        const payload = {
            nama_periode: $("#nama_periode").val(),
            tanggal_awal: $("#tanggal_awal").val(),
            tanggal_akhir: $("#tanggal_akhir").val(),
        };

        let url = "/periode/store";
        let method = "POST";

        if (id) {
            url = "/periode/update/" + id;
        }

        $.ajax({
            url: url,
            method: method,
            data: payload,
            dataType: "json",
            headers: {
                Accept: "application/json",
            },
        })
            .done(function () {
                loadData();

                // reset form
                $("#periode_id").val("");
                $("#nama_periode").val("");
                $("#tanggal_awal").val("");
                $("#tanggal_akhir").val("");

                $("#formTambah").addClass("d-none");
                $("#btnTambah").removeClass("d-none");

                showMessage("Data berhasil disimpan.");
            })
            .fail(function (jqXHR) {
                if (jqXHR.status === 422) {
                    let msgs = [];
                    $.each(jqXHR.responseJSON.errors, function (_, v) {
                        msgs.push(v.join(", "));
                    });
                    showMessage(msgs.join(" | "), "error");
                } else {
                    showMessage("Terjadi kesalahan server.", "error");
                }
            });
    });

    // EDIT / UPDATE
    $(document).on("click", ".editBtn", function () {
        $("#periode_id").val($(this).data("id"));
        $("#nama_periode").val($(this).data("nama"));
        $("#tanggal_awal").val($(this).data("awal"));
        $("#tanggal_akhir").val($(this).data("akhir"));

        $("#formTambah").removeClass("d-none");
        $("#btnTambah").addClass("d-none");
    });

    // DELETE
    $(document).on("click", ".deleteBtn", function () {
        if (!confirm("Yakin ingin menghapus periode ini?")) return;

        let id = $(this).data("id");

        $.ajax({
            url: "/periode/delete/" + id,
            type: "DELETE",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                Accept: "application/json",
            },
        })
            .done(function () {
                loadData();
                showMessage("Periode berhasil dihapus.");
            })
            .fail(function (jqXHR) {
                console.error("Delete gagal:", jqXHR);
                showMessage("Gagal menghapus periode.", "error");
            });
    });

    // (Opsional) Edit handler skeleton — implement nanti
    $(document).on("click", ".btnEdit", function () {
        const id = $(this).data("id");
        // implement edit flow (modal atau inline)
        alert("Edit belum diimplement. id=" + id);
    });
});
