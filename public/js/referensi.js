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
let referensiData = [];

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
        url: "/referensi/data",
        type: "GET",
        success: function (data) {
            referensiData = data;
            renderTable(data);
        },
    });
}

// Fungsi untuk menampilkan status di tabel referensi
function renderStatus(status) {
    if (status == 1)
        return '<span class="text-center badge bg-success">Aktif</span>';
    return "";
}

// Fungsi untuk menampilkan tabel beserta datanya
function renderTable(data) {
    let rows = "";
    data.forEach((item, index) => {
        rows += `
            <tr>
                <td class="text-center">${index + 1}</td>
                <td class="text-center">${item.referensi}</td>
                <td class="text-center">${item.kode}</td>
                <td class="text-center">${item.jenis}</td>
                <td class="text-center">
                    ${
                        item.nilai !== null && !isNaN(item.nilai)
                            ? parseFloat(item.nilai).toFixed(2) + "%"
                            : "-"
                    }
                </td>
                <td class="text-center">${renderStatus(item.status)}</td>
                <td class="text-center">
                    <button class="btn btn-primary btn-sm editBtn"
                        data-id="${item.id}"
                        data-referensi="${item.referensi}"
                        data-kode="${item.kode}"
                        data-jenis="${item.jenis}"
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
    $("#referensiTableBody").html(rows);
}

$(document).ready(function () {
    loadData();

    // Search
    $("thead input").on("keyup change", function () {
        const colIndex = $(this).data("col");
        const keyword = $(this).val().toLowerCase();

        const filtered = referensiData.filter((item) => {
            let value = "";

            if (colIndex == 1) value = item.referensi;
            if (colIndex == 2) value = parseFloat(item.nilai).toFixed(2);

            return value.toLowerCase().includes(keyword);
        });

        renderTable(filtered);
    });

    // tombol tambah / batal (UI)
    $("#btnTambah").on("click", function () {
        $("#formTambah").removeClass("d-none");
        $(this).addClass("d-none");
    });

    $("#btnBatal").on("click", function () {
        resetForm();
    });

    // CREATE — ikat ke button dengan id spesifik
    $("#btnSimpan").on("click", function (e) {
        e.preventDefault();

        const id = $("#referensi_id").val();

        const payload = {
            referensi: $("#referensi").val(),
            kode: $("#kode").val(),
            jenis: $("#jenis").val(),
            nilai: parseFloat($("#nilai").val()),
        };

        if (!payload.kode) {
            alert("Kode wajib dipilih");
            return;
        }

        let url = "/referensi/store";
        if (id) url = "/referensi/update/" + id;

        $.ajax({
            url: url,
            method: "POST",
            data: payload,
            success: function () {
                loadData();
                resetForm();
                alert("Data berhasil disimpan");
            },
            error: function (xhr) {
                alert(xhr.responseJSON?.message || "Gagal menyimpan data");
            },
        });
    });

    // EDIT
    // Set form value
    $(document).on("click", ".editBtn", function () {
        $("#referensi_id").val($(this).data("id"));
        $("#referensi").val($(this).data("referensi"));
        $("#kode").val($(this).data("kode"));
        $("#jenis").val($(this).data("jenis"));
        $("#nilai").val($(this).data("nilai"));

        $("#formTambah").removeClass("d-none");
        $("#btnTambah").addClass("d-none");
    });

    // RESET FORM SETELAH EDIT SELESAI
    function resetForm() {
        $("#referensi_id").val("");
        $("#referensi").val("");
        $("#nilai").val("");
        $("#formTambah").addClass("d-none");
        $("#btnTambah").removeClass("d-none");
    }

    // DELETE
    $(document).on("click", ".deleteBtn", function () {
        if (!confirm("Yakin hapus referensi ini?")) return;

        const id = $(this).data("id");

        $.ajax({
            url: "/referensi/delete/" + id,
            type: "DELETE",
            dataType: "json",
            headers: {
                Accept: "application/json",
            },
        })
            .done(function () {
                loadData();
                showToast("Referensi berhasil dihapus");
            })
            .fail(function (jqXHR) {
                console.error("Delete gagal:", jqXHR);
                showMessage("Gagal menghapus referensi.", "error");
            });
    });

    // (Opsional) Edit handler skeleton — implement nanti
    $(document).on("click", ".btnEdit", function () {
        const id = $(this).data("id");
        // implement edit flow (modal atau inline)
        alert("Edit belum diimplement. id=" + id);
    });
});
