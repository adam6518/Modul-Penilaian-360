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
let periodePegawaiData = [];

// State untuk menyimpan id periode yang dipilih
let selectedPeriode = null;

// Fungsi untuk menampilkan list periode saat klik tombol "Tambah Periode"
// function loadPeriode() {
//     fetch("/periode/list")
//         .then((res) => res.json())
//         .then((data) => {
//             let list = '<li><a class="dropdown-item"></a></li>';
//             data.forEach((p) => {
//                 list += `<li>
//                         <a href="#"
//                            class="dropdown-item"
//                            onclick="selectPeriode(${p.id}, '${p.nama_periode}')">
//                            ${p.nama_periode}
//                         </a>
//                     </li>`;
//                 // {{--  option += `<option value="${p.id}">${p.nama_periode}</option>`;  --}};
//             });
//             document.getElementById("periodeDropdown").innerHTML = list;
//         });
// }
function loadPeriode() {
    $.ajax({
        url: "/periode/data",
        method: "GET",
        success: function (data) {
            let html = "";

            if (!Array.isArray(data) || data.length === 0) {
                html = `<li>
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
                        </li>
                    `;
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
                </li>
            `);
        },
    });
}

// function selectPeriode(id, nama) {
//     document.getElementById("periode_id").value = id;
//     document.getElementById("btnPeriode").innerText = nama;
// }

function selectPeriode(id, nama) {
    selectedPeriode = id;
    $("#btnPeriode").text(nama);
    $("#btnSimpan").on("click", function () {
        if (!selectedPeriode) {
            alert("Silakan pilih periode terlebih dahulu");
            return;
        }

        loadData(selectedPeriode);

        // tutup form
        $("#formTambah").addClass("d-none");
        $("#btnTambah").removeClass("d-none");
    });
}

// Fungsi memanggil all data periode pegawai
// function loadData() {
//     $.ajax({
//         url: "https://api.jsonbin.io/v3/b/6954850a43b1c97be90f7a7b",
//         type: "GET",
//         success: function (res) {
//             let data = [];

//             if (Array.isArray(res.record)) {
//                 // JSONBin record langsung array
//                 data = res.record;
//             } else if (Array.isArray(res.record?.data)) {
//                 // JSONBin record punya property data
//                 data = res.record.data;
//             }

//             periodePegawaiData = data;
//             renderTable(data);
//         },
//         error: function (err) {
//             document.getElementById("periodePegawaiTableBody").innerHTML = `
//                 <tr>
//                     <td colspan="8" class="text-center text-danger">
//                         Gagal memuat data
//                     </td>
//                 </tr>
//             `;
//         },
//     });
// }
function loadData(periodeId) {
    // $.ajax({
    //     url: "/periode-pegawai/data",
    //     method: "GET",
    //     data: { periode_id: periodeId },
    //     success: function (data) {
    //         periodePegawaiData = data;
    //         renderTable(data);
    //     },
    // });
    $.ajax({
        url: "https://api.jsonbin.io/v3/b/6954850a43b1c97be90f7a7b",
        method: "GET",
        success: function (res) {
            let data = [];

            if (Array.isArray(res.record?.data)) {
                data = res.record.data;
            } else if (Array.isArray(res.record)) {
                data = res.record;
            }

            // FILTER BERDASARKAN ID PERIODE
            const filtered = data.filter(
                (item) => Number(item.id_periode) === Number(periodeId)
            );

            periodePegawaiData = filtered;
            renderTable(filtered);
        },
        error: function () {
            renderTable([]);
        },
    });
}

// Fungsi memunculkan tabel periode pegawai
function renderTable(data) {
    let html = "";

    if (!Array.isArray(data)) data = [];

    if (!data.length) {
        html = `
            <tr>
                <td colspan="8" class="text-center text-muted">
                    Data tidak tersedia
                </td>
            </tr>
        `;
    } else {
        data.forEach((item, index) => {
            html += `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td class="text-center">${item.id_periode}</td>
                            <td class="text-center">${item.id_atasan}</td>
                            <td class="text-center">${item.nama_pegawai}</td>
                            <td class="text-center">${item.nip}</td>
                            <td class="text-center">${item.id_pegawai}</td>
                            <td class="text-center">${item.id_satker}</td>
                            <td class="text-center d-flex">
                                <button class="btn btn-sm btn-primary mx-2" onclick="edit(${
                                    item.id
                                })">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="hapus(${
                                    item.id
                                })">Hapus</button>
                            </td>
                        </tr>
            `;
        });
    }

    $("#periodePegawaiTableBody").html(html);
}

// Fungsi untuk hapus data
function hapus(id) {
    fetch(`/periode-pegawai/delete/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
        },
    }).then(() => loadData());
}

$(document).ready(function () {
    loadData(); // initial load

    //Search
    $("thead input").on("keyup change", function () {
        let filtered = periodePegawaiData;

        $("thead input").each(function () {
            const keyword = $(this).val().toLowerCase();
            const field = $(this).data("field");

            if (keyword) {
                filtered = filtered.filter((item) => {
                    return (item[field] ?? "")
                        .toString()
                        .toLowerCase()
                        .includes(keyword);
                });
            }
        });

        renderTable(filtered);
    });
});
