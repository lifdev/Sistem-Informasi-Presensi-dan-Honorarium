<?php

namespace App\Exports;

use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PresensiExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    public function __construct(private int $bulan, private int $tahun) {}

    public function collection()
    {
        return Presensi::with("karyawan")
            ->whereMonth("tanggal", $this->bulan)
            ->whereYear("tanggal", $this->tahun)
            ->orderBy("tanggal")
            ->get();
    }

    public function headings(): array
    {
        return [
            "No",
            "NIP",
            "Nama Karyawan",
            "Jabatan",
            "Tanggal",
            "Jam Masuk",
            "Jam Pulang",
            "Status",
            "Keterangan",
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $row->karyawan->nip,
            $row->karyawan->nama,
            $row->karyawan->jabatan?->nama,
            $row->tanggal->format("d/m/Y"),
            $row->jam_masuk ?? "-",
            $row->jam_pulang ?? "-",
            ucfirst($row->status),
            $row->keterangan ?? "-",
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                "font" => ["bold" => true],
                "fill" => [
                    "fillType" => "solid",
                    "startColor" => ["rgb" => "1e3a5f"],
                ],
                "font" => ["bold" => true, "color" => ["rgb" => "FFFFFF"]],
            ],
        ];
    }

    public function title(): string
    {
        return "Rekap Presensi";
    }
}
