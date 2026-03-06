@extends('layouts.app')
@push('scripts')
    <script src="{{ asset('js/dashboard-profile.js') }}"></script>
@endpush
@push('styles')
    <script src="{{ asset('css/dashboard-profile.css') }}"></script>
@endpush
@section('content')
    <div class="container">

        <h2 class="fw-bold mb-5">Dashboard Profile</h2>

        {{-- ================= ADMIN ================= --}}
        @if ($role === 'admin')
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="card bg-dark text-white shadow">
                        <div class="card-body">
                            <h6>Total Pegawai</h6>
                            <h3>{{ $totalPegawai }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-success text-white shadow">
                        <div class="card-body">
                            <h6>Sudah Dinilai</h6>
                            <h3>{{ $sudahDinilai }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-danger text-white shadow">
                        <div class="card-body">
                            <h6>Belum Dinilai</h6>
                            <h3>{{ $belumDinilai }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($pegawai as $p)
                    <div class="col-md-6 col-lg-3 mb-5">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="fw-bold">{{ $p->nama_pegawai }}</h5>
                                <small class="text-muted">{{ $p->nip }}</small>
                                <hr>
                                <div class="row text-center mb-3">

                                    <div class="col-4">
                                        <small>Ber</small>
                                        <div class="fw-bold text-primary">
                                            {{ number_format($p->col_01, 2) }}
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <small>A</small>
                                        <div class="fw-bold text-primary">
                                            {{ number_format($p->col_02, 2) }}
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <small>K</small>
                                        <div class="fw-bold text-primary">
                                            {{ number_format($p->col_03, 2) }}
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <small>H</small>
                                        <div class="fw-bold text-primary">
                                            {{ number_format($p->col_04, 2) }}
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <small>L</small>
                                        <div class="fw-bold text-primary">
                                            {{ number_format($p->col_05, 2) }}
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <small>A</small>
                                        <div class="fw-bold text-primary">
                                            {{ number_format($p->col_06, 2) }}
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <small>K</small>
                                        <div class="fw-bold text-primary">
                                            {{ number_format($p->col_07, 2) }}
                                        </div>
                                    </div>

                                </div>
                                <p>Total :
                                    <span class="fw-bold text-success">
                                        {{ number_format($p->total, 2) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ================= USER ================= --}}
        @if ($role === 'user')
            {{-- NILAI SAYA --}}
            @if ($nilaiSaya)
                <div class="card border-success shadow-sm mb-5">
                    <div class="card-body text-center">
                        <h5 class="fw-bold text-success mb-4">Hasil Penilaian Anda</h5>

                        <div class="row text-center">

                            <div class="col">
                                <h6>Ber</h6>
                                <h5 class="fw-bold text-primary">
                                    {{ number_format($nilaiSaya->col_01, 2) }}
                                </h5>
                            </div>

                            <div class="col">
                                <h6>A</h6>
                                <h5 class="fw-bold text-primary">
                                    {{ number_format($nilaiSaya->col_02, 2) }}
                                </h5>
                            </div>

                            <div class="col">
                                <h6>K</h6>
                                <h5 class="fw-bold text-primary">
                                    {{ number_format($nilaiSaya->col_03, 2) }}
                                </h5>
                            </div>

                            <div class="col">
                                <h6>H</h6>
                                <h5 class="fw-bold text-primary">
                                    {{ number_format($nilaiSaya->col_04, 2) }}
                                </h5>
                            </div>

                            <div class="col">
                                <h6>L</h6>
                                <h5 class="fw-bold text-primary">
                                    {{ number_format($nilaiSaya->col_05, 2) }}
                                </h5>
                            </div>

                            <div class="col">
                                <h6>A</h6>
                                <h5 class="fw-bold text-primary">
                                    {{ number_format($nilaiSaya->col_06, 2) }}
                                </h5>
                            </div>

                            <div class="col">
                                <h6>K</h6>
                                <h5 class="fw-bold text-primary">
                                    {{ number_format($nilaiSaya->col_07, 2) }}
                                </h5>
                            </div>

                        </div>

                        <hr>

                        <h4 class="fw-bold text-success">
                            {{ number_format($nilaiSaya->total, 2) }}
                        </h4>
                        <p class="text-muted">Total Nilai</p>

                    </div>
                </div>
            @endif

            {{-- PROGRESS MENILAI --}}
            <div class="card shadow-sm mb-5">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Progress Penilaian Anda</h5>

                    <p>
                        Anda sudah menilai
                        <span class="fw-bold text-success">{{ $sudahDinilai }}</span>
                        dari
                        <span class="fw-bold">{{ $totalHarusDinilai }}</span> orang
                    </p>

                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-success" style="width: {{ $persen }}%">
                            {{ $persen }}%
                        </div>
                    </div>
                </div>
            </div>

            {{-- JUMLAH YANG MENILAI DIA --}}
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="fw-bold">Jumlah Pegawai yang Menilai Anda</h5>
                    <h2 class="fw-bold text-primary mt-3">
                        {{ $jumlahMenilaiSaya }} / {{ $totalYangHarusMenilaiDia }}
                    </h2>
                </div>
            </div>
        @endif
        @if ($totalPage > 1 && $role === 'admin')
            <nav>
                <ul class="pagination justify-content-center">

                    <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ $currentPage - 1 }}">
                            Previous
                        </a>
                    </li>

                    @for ($i = 1; $i <= $totalPage; $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link" href="?page={{ $i }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor

                    <li class="page-item {{ $currentPage >= $totalPage ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ $currentPage + 1 }}">
                            Next
                        </a>
                    </li>

                </ul>
            </nav>
        @endif
    </div>
@endsection
