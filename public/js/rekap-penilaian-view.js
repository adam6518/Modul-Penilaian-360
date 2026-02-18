document.addEventListener("DOMContentLoaded", function () {
    loadPegawai();
});

/* ===============================
   CSRF SETUP
================================ */
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function loadPegawai() {
    $.ajax({
        url: `/rekap-penilaian/${PERIODE_ID}/satker/${SATKER_ID}/data`,
        type: "GET",
        success: function (data) {
            console.log(data);

            renderPegawai(data);
        },
        error: function () {
            alert("Gagal memuat data pegawai");
        },
    });
}

function renderPegawai(data) {
    let html = "";

    data.forEach((row, index) => {
        html += `<tr>
            <td class="text-center">${index + 1}</td>
            <td>${row.nama_pegawai}</td>`;

        for (let i = 1; i <= JUMLAH_INDIKATOR; i++) {
            const key = `col_0${i}`;
            html += `<td class="text-center">${row[key] ?? "-"}</td>`;
        }

        html += `
            <td class="text-center fw-bold">
                ${parseFloat(row.total).toFixed(2)}
            </td>
        </tr>`;
    });

    $("#rekapPegawaiTable").html(html);
}
