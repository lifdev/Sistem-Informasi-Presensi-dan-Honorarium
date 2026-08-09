<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Presensi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 16px;
            border-bottom: 2px solid #1e3a5f;
            padding-bottom: 10px;
        }

        .header h2 {
            color: #1e3a5f;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .header p {
            color: #555;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #1e3a5f;
            color: #fff;
            padding: 6px 8px;
            text-align: left;
        }

        td {
            padding: 5px 8px;
            border-bottom: 1px solid #e0e0e0;
        }

        tr:nth-child(even) td {
            background: #f5f7fa;
        }

        .badge {
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
        }

        .hadir {
            background: #d1fae5;
            color: #065f46;
        }

        .izin {
            background: #dbeafe;
            color: #1e40af;
        }

        .sakit {
            background: #fef3c7;
            color: #92400e;
        }

        .alpha {
            background: #fee2e2;
            color: #991b1b;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Rekap Presensi Karyawan</h2>
        <p>Periode: {{ $namaBulan }} {{ $tahun }} &nbsp;|&nbsp; Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama Karyawan</th>
                <th>Jabatan</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($presensi as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->karyawan->nip }}</td>
                <td>{{ $p->karyawan->nama }}</td>
                <td>{{ $p->karyawan->jabatan?->nama }}</td>
                <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                <td>{{ $p->jam_masuk ?? '-' }}</td>
                <td><span class="badge {{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:20px">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Total data: {{ $presensi->count() }} baris</div>
</body>

</html>