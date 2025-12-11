{{-- Desktop Sidebar --}}
<div class="sidebar bg-white border-end p-4 d-none d-lg-flex flex-column" style="min-height: 100vh;">

    <div>
        <h1 class="fw-bold mb-4">Modul Penilaian 360</h1>
        <h6 class="fw-bold mb-4">Selamat datang User !</h6>

        <div class="d-grid gap-4 w-100">
            <button class="btn btn-success btn-l" type="button">Periode</button>
            <button class="btn btn-success btn-l" type="button">Referensi</button>
            <button class="btn btn-success btn-l" type="button">Penilaian</button>
            <button class="btn btn-success btn-l" type="button">Periode Pegawai</button>
            <button class="btn btn-success btn-l" type="button">Kalkulasi Penilaian</button>
        </div>
    </div>

    {{-- Logout fixed bottom-left --}}
    <div class="mt-auto pt-4">
        <button class="btn btn-danger w-100" type="button">Keluar</button>
    </div>

</div>

{{-- Mobile Offcanvas --}}
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Modul Penilaian 360</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column">

        <div class="d-grid gap-4 w-100">
            <button class="btn btn-success" type="button">Periode</button>
            <button class="btn btn-success" type="button">Referensi</button>
            <button class="btn btn-success" type="button">Penilaian</button>
            <button class="btn btn-success" type="button">Periode Pegawai</button>
            <button class="btn btn-success" type="button">Kalkulasi Penilaian</button>
        </div>

        <div class="mt-auto pt-4">
            <button class="btn btn-danger w-100" type="button">Keluar</button>
        </div>
    </div>
</div>
