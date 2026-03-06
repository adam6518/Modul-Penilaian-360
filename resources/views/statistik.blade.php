@extends('layouts.app')

@section('content')
    <div class="container">

        <h2 class="fw-bold mb-4">Statistik Penilaian</h2>

        <div class="row">

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Progress Penilaian</h5>
                        <canvas id="progressChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Distribusi Nilai</h5>
                        <canvas id="distribusiChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Indikator BerAKHLAK</h5>
                        <canvas id="indikatorChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Top Pegawai</h5>
                        <canvas id="topChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script src="{{ asset('js/statistik.js') }}"></script>
@endsection
