document.addEventListener("DOMContentLoaded", function () {
    loadPeriode();
});

/* ===============================
   CSRF SETUP
================================ */
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function loadPeriode() {
    $.ajax({
        url: "/rekap-penilaian/data",
        type: "GET",
        success: function (data) {
            console.log(data);

            renderTable(data);
        },
        error: function () {
            alert("Gagal memuat data periode");
        },
    });
}

function renderTable(data) {
    let html = "";

    data.forEach((row, index) => {
        // console.log(row);

        html += `
            <tr>
                <td class="text-center">${index + 1}</td>
                <td>${row.nama_periode}</td>
                <td class="text-center">
                    <a href="/rekap-penilaian/${row.id}"
                       class="btn btn-sm btn-primary">
                        Detail
                    </a>
                </td>
            </tr>
        `;
    });

    $("#rekapPeriodeTable").html(html);
}
