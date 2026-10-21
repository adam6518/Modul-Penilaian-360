@php
    $currentRole = session('role', 'user');
    $activeUserNama = session('active_user_nama', 'Pilih pegawai');

    $pegawaiList = DB::table('periode_pegawai')
        ->where('status', 1)
        ->select('id_pegawai', 'nama_pegawai', 'nip')
        ->distinct()
        ->orderBy('nama_pegawai')
        ->get();

    $currentPath = request()->path();

    $navigation = [
        [
            'label' => 'Ringkasan',
            'items' => [
                [
                    'label' => 'Dashboard Profile',
                    'icon' => 'bi-grid-1x2',
                    'route' => 'dashboard-profile.index',
                    'path' => 'dashboard-profile',
                    'roles' => ['admin', 'user'],
                ],
            ],
        ],
        [
            'label' => 'Manajemen',
            'roles' => ['admin'],
            'items' => [
                [
                    'label' => 'Periode',
                    'icon' => 'bi-calendar3',
                    'route' => 'periode.index',
                    'path' => 'periode',
                    'roles' => ['admin'],
                ],
                [
                    'label' => 'Referensi & Bobot',
                    'icon' => 'bi-sliders',
                    'route' => 'referensi.index',
                    'path' => 'referensi',
                    'roles' => ['admin'],
                ],
                [
                    'label' => 'Periode Pegawai',
                    'icon' => 'bi-people',
                    'route' => 'periode-pegawai.index',
                    'path' => 'periode-pegawai',
                    'roles' => ['admin'],
                ],
            ],
        ],
        [
            'label' => 'Penilaian',
            'items' => [
                [
                    'label' => 'Penilaian Atasan',
                    'icon' => 'bi-person-up',
                    'route' => 'penilaian-atasan.index',
                    'path' => 'penilaian-atasan',
                    'roles' => ['admin', 'user'],
                ],
                [
                    'label' => 'Penilaian Bawahan',
                    'icon' => 'bi-person-down',
                    'route' => 'penilaian-bawahan.index',
                    'path' => 'penilaian-bawahan',
                    'roles' => ['admin', 'user'],
                ],
                [
                    'label' => 'Penilaian Sejawat',
                    'icon' => 'bi-people-fill',
                    'route' => 'penilaian-sejawat.index',
                    'path' => 'penilaian-sejawat',
                    'roles' => ['admin', 'user'],
                ],
            ],
        ],
        [
            'label' => 'Analitik',
            'roles' => ['admin'],
            'items' => [
                [
                    'label' => 'Rekap Penilaian',
                    'icon' => 'bi-file-earmark-bar-graph',
                    'route' => 'rekap-penilaian.index',
                    'path' => 'rekap-penilaian',
                    'roles' => ['admin'],
                ],
                [
                    'label' => 'Statistik',
                    'icon' => 'bi-graph-up-arrow',
                    'route' => 'statistik.index',
                    'path' => 'statistik',
                    'roles' => ['admin'],
                ],
            ],
        ],
    ];
@endphp

@push('scripts')
    <script>
        window.SET_ACTIVE_USER_URL = @json(route('set-active-user'));
        window.CSRF_TOKEN = @json(csrf_token());
    </script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
@endpush

<aside class="app-sidebar d-none d-lg-flex">
    <div class="sidebar-brand">
        <div class="brand-mark">
            <i class="bi bi-bullseye"></i>
        </div>
        <div class="brand-copy">
            <strong>360<span>°</span></strong>
            <small>Performance Hub</small>
        </div>
    </div>

    <div class="sidebar-workspace">
        <div class="workspace-avatar">
            <i class="bi bi-building"></i>
        </div>
        <div class="workspace-copy">
            <span>WORKSPACE</span>
            <strong>Penilaian Kinerja</strong>
        </div>
        <i class="bi bi-chevron-down workspace-chevron"></i>
    </div>

    <div class="sidebar-profile">
        <div class="profile-avatar">
            {{ strtoupper(substr($currentRole === 'admin' ? 'A' : $activeUserNama, 0, 1)) }}
        </div>

        <div class="profile-info">
            <strong>
                {{ $currentRole === 'admin' ? 'Administrator' : $activeUserNama }}
            </strong>
            <span>
                {{ $currentRole === 'admin' ? 'Admin Workspace' : 'Pegawai' }}
            </span>
        </div>

        <div class="dropdown">
            <button class="profile-switch" type="button" data-bs-toggle="dropdown" aria-label="Ganti role atau pegawai"
                aria-expanded="false">
                <i class="bi bi-arrow-left-right"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end profile-dropdown">
                <li>
                    <h6 class="dropdown-header">Ganti konteks pengguna</h6>
                </li>
                <li>
                    <button type="button" class="dropdown-item role-option" data-role="admin">
                        <i class="bi bi-shield-lock me-2"></i> Administrator
                    </button>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                @foreach ($pegawaiList as $p)
                    <li>
                        <button type="button" class="dropdown-item role-option" data-role="user"
                            data-id="{{ $p->id_pegawai }}">
                            <i class="bi bi-person me-2"></i>
                            <span>{{ $p->nama_pegawai }}</span>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <nav class="sidebar-navigation">
        @foreach ($navigation as $group)
            @if (!isset($group['roles']) || in_array($currentRole, $group['roles']))
                <div class="nav-group">
                    <div class="nav-group-label">{{ $group['label'] }}</div>

                    @foreach ($group['items'] as $item)
                        @if (in_array($currentRole, $item['roles']))
                            @php
                                $isActive =
                                    $currentPath === $item['path'] ||
                                    str_starts_with($currentPath, $item['path'] . '/');
                            @endphp

                            <a href="{{ route($item['route']) }}" class="app-nav-link {{ $isActive ? 'active' : '' }}"
                                @if ($isActive) aria-current="page" @endif>
                                <i class="bi {{ $item['icon'] }}"></i>
                                <span>{{ $item['label'] }}</span>
                                @if ($isActive)
                                    <span class="nav-active-indicator"></span>
                                @endif
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
        @endforeach
    </nav>

    <div class="sidebar-bottom">
        <div class="sidebar-help">
            <div class="help-icon"><i class="bi bi-lightbulb"></i></div>
            <div>
                <strong>Butuh panduan?</strong>
                <span>Gunakan menu sesuai role Anda.</span>
            </div>
        </div>

        <div class="sidebar-version">
            <span class="version-dot"></span>
            Sistem Penilaian 360°
            <span class="ms-auto">v1.0</span>
        </div>
    </div>
</aside>

<div class="offcanvas offcanvas-start app-mobile-sidebar" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header">
        <div class="sidebar-brand p-0">
            <div class="brand-mark"><i class="bi bi-bullseye"></i></div>
            <div class="brand-copy">
                <strong>360<span>°</span></strong>
                <small>Performance Hub</small>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column">
        <div class="sidebar-profile mobile-profile">
            <div class="profile-avatar">
                {{ strtoupper(substr($currentRole === 'admin' ? 'A' : $activeUserNama, 0, 1)) }}
            </div>
            <div class="profile-info">
                <strong>{{ $currentRole === 'admin' ? 'Administrator' : $activeUserNama }}</strong>
                <span>{{ $currentRole === 'admin' ? 'Admin Workspace' : 'Pegawai' }}</span>
            </div>
        </div>

        <nav class="sidebar-navigation">
            @foreach ($navigation as $group)
                @if (!isset($group['roles']) || in_array($currentRole, $group['roles']))
                    <div class="nav-group">
                        <div class="nav-group-label">{{ $group['label'] }}</div>

                        @foreach ($group['items'] as $item)
                            @if (in_array($currentRole, $item['roles']))
                                @php
                                    $isActive =
                                        $currentPath === $item['path'] ||
                                        str_starts_with($currentPath, $item['path'] . '/');
                                @endphp

                                <a href="{{ route($item['route']) }}"
                                    class="app-nav-link {{ $isActive ? 'active' : '' }}"
                                    @if ($isActive) aria-current="page" @endif>
                                    <i class="bi {{ $item['icon'] }}"></i>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            @endforeach
        </nav>

        <div class="mt-4">
            <label class="form-label small fw-semibold">Ganti role</label>
            <select id="mobileRoleSelect" class="form-select form-select-sm mb-2">
                <option value="admin">Administrator</option>
                @foreach ($pegawaiList as $p)
                    <option value="{{ $p->id_pegawai }}">
                        {{ $p->nama_pegawai }} - {{ $p->nip }}
                    </option>
                @endforeach
            </select>
            <button class="btn btn-primary w-100" id="mobileRoleApply" type="button">
                Terapkan pengguna
            </button>
        </div>
    </div>
</div>
