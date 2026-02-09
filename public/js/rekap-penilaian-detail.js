document.addEventListener("DOMContentLoaded", function () {
    loadSatker();
});

/* ===============================
   CSRF SETUP
================================ */
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

/* ===============================
   LOAD SATKER
================================ */
function loadSatker() {
    $.ajax({
        url: `/rekap-penilaian/${PERIODE_ID}/data`,
        type: "GET",
        success: function (data) {
            console.log(data);
            
            renderSatker(data);
        },
        error: function () {
            alert("Gagal memuat data satker");
        },
    });
}

function renderSatker(data) {
    let html = "";

    data.forEach((row, index) => {
        html += `
            <tr>
                <td class="text-center">${index + 1}</td>
                <td class="text-center">${row.id_satker}</td>
                <td class="text-center">${row.jumlah_pegawai}</td>
                <td class="text-center">
                    <a href="/rekap-penilaian/${PERIODE_ID}/satker/${row.id_satker}"
                       class="btn btn-sm btn-info">
                        View
                    </a>
                </td>
            </tr>
        `;
    });

    $("#rekapSatkerTable").html(html);
}

/* ===============================
   KALKULASI
================================ */
$("#btnKalkulasi").on("click", function () {
    if (!confirm("Yakin ingin kalkulasi ulang penilaian?")) return;

    $.ajax({
        url: `/rekap-penilaian/${PERIODE_ID}/kalkulasi`,
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function () {
            alert("Kalkulasi berhasil");
            loadSatker();
        },
        error: function (xhr) {
            alert(xhr.responseJSON?.message || "Kalkulasi gagal");
        },
    });
});
