<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: sans-serif; font-size: 12px; color: #222; padding: 20px; }
        .slip { border: 2px solid #1e3a5f; border-radius: 8px; overflow: hidden; }
        .slip-header { background: #1e3a5f; color: #fff; padding: 14px 20px; display: flex; justify-content: space-between; align-items: center; }
        .slip-header h3 { font-size: 15px; margin-bottom: 2px; }
        .slip-header p  { font-size: 11px; opacity: .8; }
        .slip-body { padding: 16px 20px; }
        .info-row { display: flex; gap: 20px; margin-bottom: 14px; }
        .info-col { flex: 1; }
        .info-col table { width: 100%; }
        .info-col td { padding: 3px 0; }
        .info-col td:first-child { color: #555; width: 110px; }
        .divider { border: none; border-top: 1px dashed #ccc; margin: 12px 0; }
        .gaji-table { width: 100%; border-collapse: collapse; }
        .gaji-table td { padding: 5px 8px; }
        .gaji-table tr:nth-child(even) td { background: #f5f7fa; }
        .gaji-table .total-row td { background: #1e3a5f; color: #fff; font-weight: bold; font-size: 13px; padding: 8px; }
        .text-right { text-align: right; }
        .ttd { margin-top: 24px; display: flex; justify-content: space-between; }
        .ttd-box { text-align: center; width: 180px; }
        .ttd-box .line { margin-top: 50px; border-top: 1px solid #333; padding-top: 4px; }
    </style>
</head>
<body>
<div class="slip">
    <div class="slip-header">
        <div>
            <h3>SLIP HONORARIUM KARYAWAN</h3>
            <p>Periode: {{ $honorarium->namaBulan() }} {{ $honorarium->tahun }}</p>
        </div>
        <div style="text-align:right">
            <p>Dicetak: {{ now()->format('d/m/Y') }}</p>
            <p style="font-size:10px;opacity:.7">Status: {{ ucfirst($honorarium->status) }}</p>
        </div>
    </div>

    <div class="slip-body">
        {{-- Info Karyawan --}}
        <div class="info-row">
            <div class="info-col">
                <table>
                    <tr><td>Nama</td><td>: <strong>{{ $honorarium->karyawan->nama }}</strong></td></tr>
                    <tr><td>NIP</td><td>: {{ $honorarium->karyawan->nip }}</td></tr>
                </table>
            </div>
            <div class="info-col">
                <table>
                    <tr>
                        <td>Bidang</td>
                        <td>: {{ $honorarium->karyawan->jabatan?->bidang?->nama }}</td>
                    </tr>

                    <tr>
                        <td>Jabatan</td>
                        <td>: {{ $honorarium->karyawan->jabatan?->nama }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr class="divider">

        {{-- Rekap Kehadiran --}}
        <table style="width:100%;text-align:center;margin-bottom:12px">
            <tr>
                <td style="background:#d1fae5;padding:8px;border-radius:6px">
                    <div style="font-size:18px;font-weight:bold;color:#065f46">{{ $honorarium->total_hadir }}</div>
                    <div style="font-size:10px;color:#555">Hadir</div>
                </td>
                <td width="10"></td>
                <td style="background:#dbeafe;padding:8px;border-radius:6px">
                    <div style="font-size:18px;font-weight:bold;color:#1e40af">{{ $honorarium->total_izin }}</div>
                    <div style="font-size:10px;color:#555">Izin</div>
                </td>
                <td width="10"></td>
                <td style="background:#fef3c7;padding:8px;border-radius:6px">
                    <div style="font-size:18px;font-weight:bold;color:#92400e">{{ $honorarium->total_sakit }}</div>
                    <div style="font-size:10px;color:#555">Sakit</div>
                </td>
                <td width="10"></td>
                <td style="background:#fee2e2;padding:8px;border-radius:6px">
                    <div style="font-size:18px;font-weight:bold;color:#991b1b">{{ $honorarium->total_alpha }}</div>
                    <div style="font-size:10px;color:#555">Alpha</div>
                </td>
            </tr>
        </table>

        <hr class="divider">

        {{-- Rincian Gaji --}}
        <table class="gaji-table">
            <tr>
                <td>Gaji Pokok</td>
                <td class="text-right">Rp {{ number_format($honorarium->gaji_pokok, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tunjangan Kehadiran ({{ $honorarium->total_hadir }} hari)</td>
                <td class="text-right" style="color:#198754">+ Rp {{ number_format($honorarium->tunjangan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>
                    Potongan
                    (Alpha: {{ $honorarium->total_alpha }},
                    Izin: {{ $honorarium->total_izin }},
                    Sakit: {{ $honorarium->total_sakit }} hari)
                </td>
                <td class="text-right" style="color:#dc3545">- Rp {{ number_format($honorarium->total_potongan, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td>GAJI BERSIH</td>
                <td class="text-right">Rp {{ number_format($honorarium->gaji_bersih, 0, ',', '.') }}</td>
            </tr>
        </table>

        {{-- TTD --}}
        <div class="ttd">
            <div class="ttd-box">
                <div>Diterima oleh,</div>
                <div class="line">{{ $honorarium->karyawan->nama }}</div>
            </div>
            <div class="ttd-box">
                <div>Dibuat oleh,</div>
                <div class="line">Admin / HRD</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
