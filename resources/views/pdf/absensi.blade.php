<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 20px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #e0e0e0;
        }

        td.name-col {
            text-align: left;
            font-weight: bold;
            background-color: #f5f5f5;
        }

        .status-hadir {
            color: #2e7d32;
            font-weight: bold;
        }

        .status-izin {
            color: #ef6c00;
            font-weight: bold;
        }

        .status-sakit {
            color: #0277bd;
            font-weight: bold;
        }

        .status-alfa {
            color: #c62828;
            font-weight: bold;
        }

        .status-terlambat {
            color: #6a1b9a;
            font-weight: bold;
        }

        .status-empty {
            color: #999;
        }

        .legend {
            font-size: 10px;
            margin-top: 10px;
        }

        .legend span {
            margin-right: 15px;
        }

        .check-symbol {
            font-size: 14px;
            vertical-align: middle;
            display: inline-block;
        }

        .icon-symbol {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <div class="title">Laporan Absensi</div>

    <table>
        <thead>
            <tr>
                <th rowspan="2">Nama Pegawai</th>
                <th colspan="{{ count($tanggalList) }}">Tanggal</th>
            </tr>
            <tr>
                @foreach ($tanggalList as $tanggal)
                <th>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d M') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($groupedAbsensi as $nama => $absensiPerTanggal)
            <tr>
                <td class="name-col">{{ $nama }}</td>
                @foreach ($tanggalList as $tanggal)
                @php
                $status = strtolower($absensiPerTanggal[$tanggal] ?? '-');
                @endphp
                <td class="
                        @if ($status === 'hadir') status-hadir
                        @elseif ($status === 'izin') status-izin
                        @elseif ($status === 'sakit') status-sakit
                        @elseif ($status === 'alfa') status-alfa
                        @elseif ($status === 'terlambat') status-terlambat
                        @else status-empty
                        @endif
                    ">
                    @if ($status === 'hadir')
                    <span class="check-symbol">✔</span>
                    @elseif ($status === 'izin')
                    <span class="icon-symbol">I</span>
                    @elseif ($status === 'sakit')
                    <span class="icon-symbol">S</span>
                    @elseif ($status === 'alfa')
                    <span class="icon-symbol">A</span>
                    @elseif ($status === 'terlambat')
                    <span class="icon-symbol">T</span>
                    @else
                    <span class="icon-symbol">-</span>
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="legend">
        <strong>Keterangan:</strong>
        <span class="status-hadir">✔ Hadir</span>
        <span class="status-terlambat">T Terlambat</span>
        <span class="status-izin">I Izin</span>
        <span class="status-sakit">S Sakit</span>
        <span class="status-alfa">A Alfa</span>
        <span class="status-empty">- Tidak Ada Data</span>
    </div>

</body>

</html>
