<!DOCTYPE html>
<html lang="en">

<head>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Modul Penilaian 360' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .sidebar {
            width: 20%;
            min-height: 100vh;
        }

        .content-area {
            width: 80%;
        }

        @media (max-width: 992px) {

            .sidebar,
            .content-area {
                width: 100%;
                min-height: auto;
            }
        }
    </style>
</head>

<body class="bg-light">

    <div class="d-flex">

        {{-- Desktop Sidebar --}}
        @include('components.sidebar')

        {{-- Mobile Sidebar Toggle --}}
        <button class="btn btn-primary d-lg-none position-fixed m-3" data-bs-toggle="offcanvas"
            data-bs-target="#mobileSidebar">
            Menu
        </button>

        {{-- Content --}}
        <div class="content-area p-4">
            @yield('content')
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>

</html>
