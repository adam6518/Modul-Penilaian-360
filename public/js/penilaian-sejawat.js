let selectedPeriode = null;

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
    // periodeAktif = false;
    $("#btnPeriode").text(nama);
}

/* ===============================
   AMBIL TERNILAI TERPILIH
================================ */
function getSelectedTernilai() {
    return $(".checkTernilai:checked")
        .map(function () {
            return $(this).val();
        })
        .get();
}

/* ===============================
  PREVIEW
================================ */
function renderPreview(id, field) {
    // console.log(field);

    return `
        <td>
            <span class="preview-${field}-${id}">-</span>
            <input type="hidden"
                   class="nilai-hidden"
                   data-id="${id}"
                   data-field="${field}">
        </td>
    `;
}

/* ===============================
   RENDER CHECKBOX ROW
================================ */
function renderCheckboxTernilai(data) {
    let html = "";
    console.log(data);
    
    if (!data.length) {
        html = `
            <tr>
                <td colspan="${window.INDIKATOR.length + 3}" class="text-center text-muted">
                    Tidak ada atasan
                </td>
            </tr>`;
    } else {
        data.forEach((row) => {
            html += `
                <tr data-id="${row.id_sejawat}" data-nama="${row.nama_sejawat.toLowerCase()}">
                    <td>
                        <input type="checkbox" class="checkTernilai" value="${row.id_sejawat}">
                        <span class="ms-2">${row.nama_sejawat}</span>
                    </td>
                    <td>${window.USER_PENILAI.nama}</td>

                    ${window.INDIKATOR.map((ind) =>
                        renderPreview(row.id_sejawat, ind.kode),
                    ).join("")}
                    <td></td>
                </tr>
            `;
        });
    }

    $("#PenilaianAtasanTableBody").html(html);
}

/* ===============================
   RENDER INPUT
================================ */
function renderInput(id, field) {
    console.log(field);

    return `
        <td>
            <input type="number"
                   class="form-control form-control-sm nilai-input"
                   data-id="${id}"
                   data-field="${field}"
                   min="0"
                   step="0.01">
        </td>
    `;
}

/* ===============================
   LOAD ATASAN
================================ */
function loadSejawat() {
    if (!selectedPeriode) {
        alert("Pilih periode terlebih dahulu");
        return;
    }

    $.ajax({
        url: "/penilaian-sejawat/sejawat",
        method: "GET",
        data: { periode_id: selectedPeriode },
        success: function (data) {
            renderCheckboxTernilai(data);
        },
        error: function () {
            alert("Gagal memuat data ternilai");
        },
    });
}

/* ===============================
   GET SEMUA NILAI SAAT SUBMIT
================================ */
function collectPenilaianData() {
    const result = {};

    $(".nilai-hidden").each(function () {
        const id = $(this).data("id");
        const field = $(this).data("field");
        const value = $(this).val();

        if (!result[id]) {
            result[id] = { id_ternilai: id };
        }

        result[id][field] = value || 0;
    });

    return Object.values(result);
}

/* ===============================
   BUTTON HANDLER
================================ */

$(document).ready(function () {
    loadPeriode();
    // MODE TAMPIL
    $("#btnTampil").on("click", function () {
        loadSejawat();

        $("#formTambah").removeClass("d-none");
        $("#btnSubmitPenilaian").removeClass("d-none");
        $("#formNilaiGlobal").removeClass("d-none");
    });

    //SUBMIT PENILAIAN
    $("#btnSubmitPenilaian").on("click", function () {
        if (!selectedPeriode) {
            alert("Pilih periode terlebih dahulu");
            return;
        }

        const penilaian = collectPenilaianData();

        if (!penilaian.length) {
            alert("Tidak ada data penilaian");
            return;
        }

        $.ajax({
            url: "/penilaian-sejawat/store",
            method: "POST",
            data: {
                periode_id: selectedPeriode,
                penilaian: penilaian,
            },
            success: function (res) {
                alert(`Berhasil menyimpan ${res.inserted} penilaian`);
            },
            error: function (xhr) {
                alert(xhr.responseJSON?.message || "Gagal menyimpan penilaian");
            },
        });
    });

    // TERAPKAN NILAI
    $("#btnApplyNilai").on("click", function () {
        const nilai = {
            col_01: $("#nilai_ber").val(),
            col_02: $("#nilai_a1").val(),
            col_03: $("#nilai_k1").val(),
            col_04: $("#nilai_h").val(),
            col_05: $("#nilai_l").val(),
            col_06: $("#nilai_a2").val(),
            col_07: $("#nilai_k2").val(),
        };

        $(".checkTernilai:checked").each(function () {
            const id = $(this).val();

            Object.keys(nilai).forEach((field) => {
                // set preview
                $(`.preview-${field}-${id}`).text(nilai[field] || "-");

                // set hidden value
                $(`input[data-id="${id}"][data-field="${field}"]`).val(
                    nilai[field] || 0,
                );
            });
        });
    });

    // CHECKBOX
    $(document).on("change", "#checkAll", function () {
        $(".checkTernilai").prop("checked", this.checked);
    });

    // SEARCH
    $(document).on("keyup", "input[data-field='id_penilai']", function () {
        const keyword = $(this).val().toLowerCase();

        $("#PenilaianAtasanTableBody tr").each(function () {
            const nama = $(this).data("nama") || "";
            $(this).toggle(nama.includes(keyword));
        });
    });
});
