# Modul Penilaian 360 Derajat

## Deskripsi

Modul **Penilaian 360 Derajat** adalah sebuah modul aplikasi yang
dirancang untuk mendukung proses evaluasi kinerja pegawai secara
menyeluruh (360°). Modul ini memungkinkan setiap pegawai memberikan
penilaian kepada pihak-pihak yang berinteraksi langsung dalam struktur
organisasi, yaitu:

-   Atasan
-   Bawahan
-   Rekan sejawat dengan atasan yang sama

Modul ini dikembangkan sebagai **komponen dari sistem aplikasi yang
lebih besar**, sehingga dapat diintegrasikan dengan modul lain dalam
sistem manajemen pegawai.

------------------------------------------------------------------------

## Konsep Penilaian 360°

Penilaian 360 derajat bertujuan memberikan gambaran kinerja yang lebih
objektif dengan mengumpulkan penilaian dari berbagai arah dalam struktur
organisasi.

Setiap pegawai dapat melakukan penilaian kepada:

-   **Atasan langsung**
-   **Bawahan langsung**
-   **Rekan kerja sejawat** (pegawai yang memiliki atasan yang sama)

Pendekatan ini memungkinkan evaluasi kinerja yang lebih komprehensif
dibandingkan penilaian satu arah.

------------------------------------------------------------------------

## Alur Modul

### 1. Pembuatan Periode Penilaian

Administrator membuat periode penilaian yang akan digunakan sebagai
dasar seluruh proses evaluasi.

Contoh: - Periode Semester 1 2025 - Periode Tahun 2025

Setiap periode akan menyimpan snapshot data pegawai yang digunakan dalam
proses penilaian.

------------------------------------------------------------------------

### 2. Snapshot / Penarikan Data Pegawai

Saat periode dibuat, sistem akan melakukan **perekaman data pegawai
(snapshot)** pada saat itu.

Hal ini diperlukan karena kondisi pegawai dapat berubah antar periode,
misalnya:

-   Pegawai pensiun
-   Pegawai baru masuk
-   Perubahan struktur organisasi
-   Perubahan atasan atau bawahan
-   Perubahan nama atau informasi pegawai

Dengan mekanisme snapshot ini, data penilaian tetap konsisten sesuai
kondisi organisasi pada periode tersebut.

------------------------------------------------------------------------

### 3. Proses Penilaian Pegawai

Pada periode aktif, setiap pegawai dapat melakukan penilaian terhadap
pegawai lain sesuai relasi organisasi.

Penilaian dapat dilakukan dengan dua metode:

-   **Penilaian kolektif** menggunakan checkbox untuk mempercepat proses
-   **Penilaian individual** untuk memberikan nilai secara spesifik

Pendekatan ini memungkinkan efisiensi ketika melakukan penilaian
terhadap banyak pegawai.

------------------------------------------------------------------------

### 4. Pengolahan dan Pelaporan

Setelah proses penilaian selesai, sistem dapat menghasilkan laporan
hasil evaluasi.

Laporan dapat dihasilkan berdasarkan:

-   **Per satuan kerja (Satker)**
-   **Seluruh pegawai dalam organisasi**

Format laporan yang tersedia:

-   PDF
-   Excel

Laporan ini dapat digunakan sebagai bahan evaluasi organisasi maupun
pengambilan keputusan manajemen.

------------------------------------------------------------------------

### 5. Dashboard

Modul menyediakan dashboard untuk dua jenis pengguna:

#### Dashboard Admin

Digunakan untuk:

-   Mengelola periode penilaian
-   Melihat progress penilaian
-   Mengakses laporan hasil evaluasi
-   Monitoring aktivitas penilaian

#### Dashboard User

Digunakan oleh pegawai untuk:

-   Melakukan penilaian kepada atasan, bawahan, dan rekan sejawat
-   Melihat status penilaian yang telah dilakukan
-   Mengakses ringkasan hasil jika diperlukan

------------------------------------------------------------------------

## Tujuan Pengembangan Modul

Tujuan utama dari modul ini adalah:

-   Mempermudah proses penilaian kinerja pegawai
-   Mendukung evaluasi kinerja yang lebih objektif
-   Menyediakan data evaluasi yang terstruktur dan terdokumentasi
-   Menjadi komponen yang dapat diintegrasikan dengan sistem manajemen
    pegawai yang lebih besar

------------------------------------------------------------------------

## Status Project

Project ini dikembangkan sebagai **modul terpisah** yang nantinya akan
diintegrasikan dengan aplikasi utama.

Pengembangan masih dapat berkembang sesuai kebutuhan organisasi dan
integrasi sistem.
