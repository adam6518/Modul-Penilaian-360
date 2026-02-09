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
        html += `
            <tr>
                <td class="text-center">${index + 1}</td>
                <td>${row.nama_pegawai}</td>
                <td class="text-center">
                    ${row.col_01}
                </td>
                <td class="text-center">
                    ${row.col_02}
                </td>
                <td class="text-center">
                    ${row.col_03}
                </td>
                <td class="text-center">
                    ${row.col_04}
                </td>
                <td class="text-center">
                    ${row.col_05}
                </td>
                <td class="text-center">
                    ${row.col_06}
                </td>
                <td class="text-center">
                    ${row.col_07}
                </td>
                <td class="text-center fw-bold">
                    ${parseFloat(row.total).toFixed(2)}
                </td>
            </tr>
        `;
    });

    $("#rekapPegawaiTable").html(html);
}
