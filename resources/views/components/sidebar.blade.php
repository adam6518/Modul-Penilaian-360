@php
    $currentRole = session('role', 'user');
@endphp
<style>
    /* Sidebar base */
    .sidebar {
        background-color: #0b3a5b;
        color: #ffffff;
    }

    /* Menu item */
    .sidebar-menu {
        display: block;
        padding: 12px;
        border-radius: 8px;
        color: #ffffff;
        text-decoration: none;
        font-weight: 500;
        background-color: transparent;
        border: none;
        width: 100%;
        text-align: start;
    }

    /* Hover */
    .sidebar-menu:hover {
        background-color: #006577;
        color: #ffffff;
    }

    /* Active / clicked */
    .sidebar-menu.active {
        background-color: #006577;
        color: #ffffff;
    }

    /* Disable Bootstrap focus & border */
    .sidebar-menu:focus,
    .sidebar-menu:active {
        outline: none;
        box-shadow: none;
    }

    .sidebar-logout {
        background-color: #b71c1c;
        border: none;
        border-radius: 8px;
        padding: 10px;
        color: #fff;
        font-weight: 500;
    }

    .sidebar-logout:hover {
        background-color: #8e0000;
    }
</style>
@push('scripts')
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
        window.SET_ACTIVE_USER_URL = "{{ route('set-active-user') }}";
        window.CSRF_TOKEN = "{{ csrf_token() }}";
    </script>
@endpush
@php
    $pegawaiList = DB::table('periode_pegawai')
        ->where('status', 1)
        ->select('id_pegawai', 'nama_pegawai', 'nip')
        ->orderBy('nama_pegawai')
        ->get();

    $activeUserNama = session('active_user_nama');
@endphp
{{-- Desktop Sidebar --}}
<div class="sidebar border-end p-4 d-none d-lg-flex flex-column" style="min-height: 100vh;">

    <div>
        <div class="p-4 border-bottom">
            <h3 class="fw-bold mb-4">Modul Penilaian 360</h3>
            <h6 class="fw-bold mb-4">Selamat datang
                @if ($currentRole === 'admin')
                    <span>Admin</span> !
                @elseif ($currentRole === 'user' && $activeUserNama)
                    <span>{{ $activeUserNama }}</span> !
                @endif
            </h6>
        </div>
        <div class="mt-2">
            <button class="btn sidebar-menu dropdown-toggle" data-bs-toggle="dropdown">
                @if ($currentRole === 'admin')
                    Admin
                @else
                    {{ session('active_user_nama') }}
                @endif
            </button>

            <ul class="dropdown-menu">
                <li>
                    <a href="#" class="dropdown-item role-option" data-role = "admin">
                        Admin
                    </a>
                </li>
                @foreach ($pegawaiList as $p)
                    <li>
                        <a href="#" class="dropdown-item role-option" data-id="{{ $p->id_pegawai }}"
                            data-role = "user">
                            {{ $p->nama_pegawai }} - {{ $p->nip }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="sidebar-menu-wrapper d-grid gap-4 w-100 mt-2">
            @if ($currentRole === 'admin')
                <a href="{{ route('periode.index') }}" class="sidebar-menu btn btn-success btn-l" data-role="admin">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-calendar-check-fill mx-3" viewBox="0 0 16 16">
                        <path
                            d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                    </svg>Periode
                </a>
                <a href="{{ route('referensi.index') }}" class="sidebar-menu btn btn-success btn-l" data-role="admin">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-book-fill mx-3" viewBox="0 0 16 16">
                        <path
                            d="M8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
                    </svg>Referensi
                </a>
                <a href="{{ route('periode-pegawai.index') }}" class="sidebar-menu btn btn-success btn-l"
                    data-role="admin">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-person-check-fill mx-3" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                    </svg>Periode Pegawai</a>
                <a href="{{ route('rekap-penilaian.index') }}" class="sidebar-menu btn btn-success btn-l"
                    data-role="admin">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-calculator-fill mx-3" viewBox="0 0 16 16">
                        <path
                            d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm2 .5v2a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0-.5.5m0 4v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5M4.5 9a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 12.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5M7.5 6a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM7 9.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m.5 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM10 6.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m.5 2.5a.5.5 0 0 0-.5.5v4a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-.5-.5z" />
                    </svg>Rekap Penilaian</a>
                <a href="{{ route('statistik.index') }}" class="sidebar-menu btn btn-success btn-l"
                    data-role="admin">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-calculator-fill mx-3" viewBox="0 0 16 16">
                        <path
                            d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm2 .5v2a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0-.5.5m0 4v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5M4.5 9a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 12.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5M7.5 6a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM7 9.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m.5 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM10 6.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m.5 2.5a.5.5 0 0 0-.5.5v4a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-.5-.5z" />
                    </svg>Statistik</a>
            @endif
            <div class="dropdown" data-role="admin,user">
                <a class="sidebar-menu btn btn-success btn-l" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-pencil-fill mx-3" viewBox="0 0 16 16">
                        <path
                            d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                    </svg>Penilaian
                </a>
                <ul class="dropdown-menu">
                    <a href="{{ route('penilaian-bawahan.index') }}" class="dropdown-item btn-success btn-l"
                        role="button">
                        Penilaian Bawahan
                    </a>
                    <a href="{{ route('penilaian-atasan.index') }}" class="dropdown-item btn-success btn-l"
                        role="button">
                        Penilaian Atasan
                    </a>
                    <a href="{{ route('penilaian-sejawat.index') }}" class="dropdown-item btn-success btn-l"
                        role="button">
                        Penilaian Sejawat
                    </a>
                </ul>
            </div>
            <a href="{{ route('dashboard-profile.index') }}" class="sidebar-menu btn btn-success btn-l"
                data-role="admin,user">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-person-lines-fill mx-3" viewBox="0 0 16 16">
                    <path
                        d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
                </svg>Dashboard Profile
            </a>
        </div>
    </div>

    {{-- Logout fixed bottom-left --}}
    <div class="mt-auto pt-4">
        <button class="sidebar-logout btn btn-danger w-100" type="button">Keluar</button>
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
            <a href="{{ route('periode.index') }}" class="btn btn-success">
                Periode
            </a>

            <button class="btn btn-success" type="button">Referensi</button>
            <button class="btn btn-success" type="button">Penilaian</button>
            <button class="btn btn-success" type="button">Periode Pegawai</button>
            <button class="btn btn-success" type="button">Rekap Penilaian</button>
        </div>
        <div class="mt-auto pt-4">
            <button class="btn btn-danger w-100" type="button">Keluar</button>
        </div>
    </div>
</div>
