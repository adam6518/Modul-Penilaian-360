document.addEventListener("DOMContentLoaded", function () {
    const btnTambah = document.getElementById("btnTambah");
    const btnBatal = document / getElementById("btnBatal");
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
    if (status == 1) return '<span class="badge bg-success">Aktif</span>';
    return "";
}

// Fungsi untuk menampilkan tabel beserta datanya
function renderTable(data) {
    let rows = "";
    data.forEach((item, index) => {
        rows += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.referensi}</td>
                <td>
                    ${
                        item.nilai !== null && !isNaN(item.nilai)
                            ? parseFloat(item.nilai).toFixed(2) + "%"
                            : "-"
                    }
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

        let nilaiRaw = $("#nilai").val();

        // normalisasi koma ke titik
        nilaiRaw = nilaiRaw.replace(",", ".");

        const id = $("#referensi_id").val();

        const payload = {
            referensi: $("#referensi").val(),
            nilai: parseFloat(nilaiRaw),
        };

        let url = "/referensi/store";
        let method = "POST";

        if (id) url = "/referensi/update/" + id;
        if (isNaN(payload.nilai)) {
            showMessage(
                "Nilai harus berupa angka (gunakan titik, bukan koma)",
                "error"
            );
            return;
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
                resetForm();
                showMessage("Data berhasil disimpan.");
            })
            .fail(function (jqXHR) {
                if (jqXHR.status === 422) {
                    let msg = [];
                    const errors = jqXHR.responseJSON?.errors ?? {};

                    Object.values(errors).jqXHR.forEach((arr) => {
                        messages.push(arr.join(", "));
                    });
                    showToast(messages.join(" | "), "error");
                } else if (jqXHR.status === 401 || jqXHR.status === 403) {
                    showToast("Anda tidak memiliki akses.", "error");
                } else {
                    showToast("Terjadi kesalahan server.", "error");
                }
            });

        // $.post(url, payload)
        //     .done(function () {
        //         loadData();
        //         resetForm();
        //         showToast("Data berhasil disimpan");
        //     })
        //     .fail(function (xhr) {
        //         showToast("Validasi gagal", "error");
        //     });
    });

    // EDIT
    // Set form value
    $(document).on("click", ".editBtn", function () {
        $("#referensi_id").val($(this).data("id"));
        $("#referensi").val($(this).data("referensi"));
        $("#nilai").val(parseFloat(nilai).toFixed(2));

        // Tampilkan form
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
