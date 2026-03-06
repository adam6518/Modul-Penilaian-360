fetch("/statistik/data")
    .then((res) => res.json())
    .then((data) => {
        //// PROGRESS CHART
        new Chart(document.getElementById("progressChart"), {
            type: "doughnut",
            data: {
                labels: ["Sudah Dinilai", "Belum Dinilai"],
                datasets: [
                    {
                        data: [data.progress.sudah, data.progress.belum],
                    },
                ],
            },
        });

        //// DISTRIBUSI
        const distribusiLabel = data.distribusi.map((d) => d.kategori);
        const distribusiValue = data.distribusi.map((d) => d.jumlah);

        new Chart(document.getElementById("distribusiChart"), {
            type: "bar",
            data: {
                labels: distribusiLabel,
                datasets: [
                    {
                        label: "Jumlah Pegawai",
                        data: distribusiValue,
                    },
                ],
            },
        });

        //// RADAR BERAKHLAK
        new Chart(document.getElementById("indikatorChart"), {
            type: "radar",
            data: {
                labels: ["Ber", "A", "K", "H", "L", "A", "K"],
                datasets: [
                    {
                        label: "Rata-rata Nilai",
                        data: [
                            data.indikator.ber,
                            data.indikator.a1,
                            data.indikator.k1,
                            data.indikator.h,
                            data.indikator.l,
                            data.indikator.a2,
                            data.indikator.k2,
                        ],
                    },
                ],
            },
        });

        //// TOP PEGAWAI
        const topLabel = data.topPegawai.map((p) => p.nama_pegawai);
        const topValue = data.topPegawai.map((p) => p.total);

        new Chart(document.getElementById("topChart"), {
            type: "bar",
            data: {
                labels: topLabel,
                datasets: [
                    {
                        label: "Total Nilai",
                        data: topValue,
                    },
                ],
            },
        });
    });
