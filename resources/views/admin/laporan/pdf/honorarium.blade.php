<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Honorarium</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: sans-serif; font-size: 11px; color: #222; }
        .header { text-align: center; margin-bottom: 16px; border-bottom: 2px solid #198754; padding-bottom: 10px; }
        .header h2 { color: #198754; font-size: 16px; margin-bottom: 4px; }
        .header p  { color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #198754; color: #fff; padding: 6px 8px; text-align: left; }
        td { padding: 5px 8px; border-bottom: 1px solid #e0e0e0; }
        tr:nth-child(even) td { background: #f5f7fa; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        tfoot td { background: #f0fdf4; font-weight: bold; border-top: 2px solid #198754; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; color: #888; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Honorarium Karyawan</h2>
        <p>Periode: {{ $namaBulan }} {{ $tahun }} &nbsp;|&nbsp; Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th class="text-center">Hadir</th>
                <th class="text-center">Izin</th>
                <th class="text-center">Sakit</th>
                <th class="text-center">Alpha</th>
                <th class="text-right">Gaji Pokok</th>
                <th class="text-right">Tunjangan</th>
                <th class="text-right">Potongan</th>
                <th class="text-right">Gaji Bersih</th>
            </tr>
        </thead>
        <tbody>
            @forelse($honorarium as $i => $h)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $h->karyawan->nip }}</td>
                <td>{{ $h->karyawan->nama }}</td>
                <td>{{ $h->karyawan->jabatan?->nama }}</td>
                <td class="text-center">{{ $h->total_hadir }}</td>
                <td class="text-center">{{ $h->total_izin }}</td>
                <td class="text-center">{{ $h->total_sakit }}</td>
                <td class="text-center">{{ $h->total_alpha }}</td>
                <td class="text-right">Rp {{ number_format($h->gaji_pokok, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($h->tunjangan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($h->total_potongan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($h->gaji_bersih, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="12" style="text-align:center;padding:20px">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
        @if($honorarium->isNotEmpty())
        <tfoot>
            <tr>
                <td colspan="11" class="text-right">Total Pengeluaran:</td>
                <td class="text-right">Rp {{ number_format($honorarium->sum('gaji_bersih'), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>
    <div class="footer">Total karyawan: {{ $honorarium->count() }}</div>
</body>
</html>
