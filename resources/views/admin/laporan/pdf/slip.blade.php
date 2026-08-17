<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Slip Honorarium</title>
    <style>
        @page {
            margin: 10mm 15mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #222;
            padding: 10px;
        }

        .slip {
            border: 2px solid #1e3a5f;
            border-radius: 8px;
            overflow: hidden;
        }

        .slip-header {
            background: #1e3a5f;
            color: #fff;
            width: 100%;
            border-collapse: collapse;
        }

        .slip-header td {
            padding: 10px 20px;
            vertical-align: middle;
        }

        .slip-header h3 {
            font-size: 15px;
            margin-bottom: 2px;
        }

        .slip-header p {
            font-size: 11px;
            opacity: .8;
        }

        .slip-body {
            padding: 12px 20px;
        }

        .info-row {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .info-row td {
            vertical-align: top;
            width: 50%;
            padding-right: 20px;
        }

        .info-col table {
            width: 100%;
        }

        .info-col td {
            padding: 3px 0;
            width: auto;
        }

        .info-col td:first-child {
            color: #555;
            width: 110px;
        }

        .divider {
            border: none;
            border-top: 1px dashed #ccc;
            margin: 8px 0;
        }

        .honorarium-table {
            width: 100%;
            border-collapse: collapse;
        }

        .honorarium-table td {
            padding: 5px 8px;
        }

        .honorarium-table tr:nth-child(even) td {
            background: #f5f7fa;
        }

        .honorarium-table .total-row td {
            background: #1e3a5f;
            color: #fff;
            font-weight: bold;
            font-size: 13px;
            padding: 8px;
        }

        .text-right {
            text-align: right;
        }

        .ttd {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .ttd td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .ttd-box {
            text-align: center;
            width: 180px;
            margin: 0 auto;
        }

        .ttd-box .line {
            margin-top: 30px;
            border-top: 1px solid #333;
            padding-top: 4px;
        }

        .honorarium-table,
        .ttd {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <div class="slip">
        <table class="slip-header">
            <tr>
                <td>
                    <h3>SLIP HONORARIUM KARYAWAN</h3>
                    <p>Periode: {{ $honorarium->namaBulan() }} {{ $honorarium->tahun }}</p>
                </td>
                <td style="text-align:right">
                    <p>Dicetak: {{ now()->format('d/m/Y') }}</p>
                    <p style="font-size:10px;opacity:.7">Status: {{ ucfirst($honorarium->status) }}</p>
                </td>
            </tr>
        </table>

        <div class="slip-body">
            {{-- Info Karyawan --}}
            <table class="info-row">
                <tr>
                    <td>
                        <div class="info-col">
                            <table>
                                <tr>
                                    <td>Nama</td>
                                    <td>: <strong>{{ $honorarium->karyawan->nama }}</strong></td>
                                </tr>
                                <tr>
                                    <td>NIP</td>
                                    <td>: {{ $honorarium->karyawan->nip }}</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td>
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
                    </td>
                </tr>
            </table>

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

            {{-- Rincian Honorarium --}}
            <table class="honorarium-table">
                <tr>
                    <td>
                        @if ($honorarium->isPerHadir())
                        Honorarium ({{ $honorarium->total_hadir }} hari &times; Rp {{ number_format($honorarium->tarif_per_hadir, 0, ',', '.') }})
                        @else
                        Honorarium Pokok
                        @endif
                    </td>
                    <td class="text-right">Rp {{ number_format($honorarium->honorarium_pokok, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Bonus</td>
                    <td class="text-right" style="color:#198754">+ Rp
                        {{ number_format($honorarium->bonus, 0, ',', '.') }}
                    </td>
                </tr>
                @if (!$honorarium->isPerHadir())
                <tr>
                    <td>
                        Potongan (Alpha: {{ $honorarium->total_alpha }} hari)
                    </td>
                    <td class="text-right" style="color:#dc3545">- Rp
                        {{ number_format($honorarium->total_potongan, 0, ',', '.') }}
                    </td>
                </tr>
                @endif
                <tr class="total-row">
                    <td>HONORARIUM BERSIH</td>
                    <td class="text-right">Rp {{ number_format($honorarium->honorarium_bersih, 0, ',', '.') }}</td>
                </tr>
            </table>

            {{-- TTD --}}
            <table class="ttd">
                <tr>
                    <td>
                        <div class="ttd-box">
                            <div>Diterima oleh,</div>
                            <div class="line">{{ $honorarium->karyawan->nama }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="ttd-box">
                            <div>Dibuat oleh,</div>
                            <div class="line">Admin / HRD</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>