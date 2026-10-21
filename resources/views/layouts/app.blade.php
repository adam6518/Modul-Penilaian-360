<!DOCTYPE html>
<html lang="id">

<head>
    @livewireStyles

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Modul Penilaian 360' }}</title>
    <meta name="theme-color" content="#f5f7fb">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="app-shell">
        @include('components.sidebar')

        <main class="app-main">
            <header class="topbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="mobile-menu-toggle" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#mobileSidebar" aria-label="Buka navigasi">
                        <i class="bi bi-list"></i>
                    </button>

                    <div>
                        <div class="topbar-eyebrow">MODUL PENILAIAN 360°</div>
                        <div class="topbar-title">
                            {{ $title ?? 'Ruang Kerja' }}
                        </div>
                    </div>
                </div>

                <div class="topbar-right">
                    <div class="topbar-date d-none d-md-flex">
                        <i class="bi bi-calendar3"></i>
                        <span id="currentDate">Memuat tanggal...</span>
                    </div>

                    <div class="topbar-avatar">
                        {{ strtoupper(substr(session('active_user_nama', session('role', 'A')), 0, 1)) }}
                    </div>

                    <div class="topbar-user d-none d-sm-block">
                        <span class="topbar-user-name">
                            @if (session('role', 'user') === 'admin')
                                Administrator
                            @else
                                {{ session('active_user_nama', 'Pengguna') }}
                            @endif
                        </span>
                        <span class="topbar-user-role">
                            {{ session('role', 'user') === 'admin' ? 'Admin' : 'Pegawai' }}
                        </span>
                    </div>
                </div>
            </header>

            <div class="page-content">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show app-alert" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show app-alert" role="alert">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                @yield('content')
            </div>

            <footer class="app-footer">
                <span>© {{ date('Y') }} Modul Penilaian 360°</span>
                <span>Performance & Development Workspace</span>
            </footer>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateElement = document.getElementById('currentDate');

            if (dateElement) {
                dateElement.textContent = new Intl.DateTimeFormat('id-ID', {
                    weekday: 'short',
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                }).format(new Date());
            }
        });
    </script>

    @stack('scripts')
    @livewireScripts
</body>

</html>
