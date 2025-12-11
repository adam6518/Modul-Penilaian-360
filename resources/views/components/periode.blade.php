<h1 class="fw-bold mb-4">Periode</h1>
<div class="input-group mb-3 border border-secondary rounded-2" style="max-width: 100%;">
    <span class="input-group-text" <svg class="rounded-4" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
        viewBox="0 -960 960 960" fill="#888">
        <svg class="rounded-4" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 -960 960 960"
            fill="#888">
            <path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109
                                                75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252
                                                252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75
                                                0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
        </svg>
    </span>
    <input type="text" class="form-control form-control-sm border-start-0" placeholder="Cari informasi di sini...">
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Pegawai</th>
                        <th>Departemen</th>
                        <th>Nilai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $dummy = [
                            ['nama' => 'Budi Santoso', 'dept' => 'Finance', 'nilai' => 87, 'status' => 'Selesai'],
                            ['nama' => 'Agnes Lestari', 'dept' => 'HRD', 'nilai' => 92, 'status' => 'Selesai'],
                            ['nama' => 'Rizky Pratama', 'dept' => 'IT', 'nilai' => 75, 'status' => 'Proses'],
                            [
                                'nama' => 'Dina Ramadhani',
                                'dept' => 'Marketing',
                                'nilai' => 80,
                                'status' => 'Selesai',
                            ],
                        ];
                    @endphp

                    @foreach ($dummy as $i => $row)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $row['nama'] }}</td>
                            <td>{{ $row['dept'] }}</td>
                            <td>{{ $row['nilai'] }}</td>
                            <td>
                                <span class="badge {{ $row['status'] === 'Selesai' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $row['status'] }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary">Detail</button>
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
