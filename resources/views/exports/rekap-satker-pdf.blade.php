<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>

    <h3>Rekap Pegawai - Satker {{ $satkerId }}</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                @foreach ($indikator as $item)
                    <th>{{ $item->referensi }}</th>
                @endforeach
                <th>Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-left">{{ $row->nama_pegawai }}</td>
                    <td>{{ $row->col_01 }}</td>
                    <td>{{ $row->col_02 }}</td>
                    <td>{{ $row->col_03 }}</td>
                    <td>{{ $row->col_04 }}</td>
                    <td>{{ $row->col_05 }}</td>
                    <td>{{ $row->col_06 }}</td>
                    <td>{{ $row->col_07 }}</td>
                    <td>{{ number_format($row->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
