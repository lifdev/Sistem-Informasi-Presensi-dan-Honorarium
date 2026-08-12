<?php

namespace App\Exports;

use App\Models\Honorarium;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HonorariumExport implements
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
        return Honorarium::with("karyawan")
            ->where("bulan", $this->bulan)
            ->where("tahun", $this->tahun)
            ->get();
    }

    public function headings(): array
    {
        return [
            "No",
            "NIP",
            "Nama Karyawan",
            "Bidang",
            "Jabatan",
            "Tipe Honorarium",
            "Hadir",
            "Izin",
            "Sakit",
            "Alpha",
            "Honorarium Pokok",
            "Tarif per Hadir",
            "Bonus",
            "Potongan",
            "Honorarium Bersih",
            "Status",
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
            $row->karyawan->jabatan?->bidang?->nama,
            $row->karyawan->jabatan?->nama,
            $row->tipe_honorarium === 'per_hadir' ? 'Per Hari Hadir' : 'Bulanan',
            $row->total_hadir,
            $row->total_izin,
            $row->total_sakit,
            $row->total_alpha,
            $row->honorarium_pokok,
            $row->tarif_per_hadir,
            $row->bonus,
            $row->total_potongan,
            $row->honorarium_bersih,
            ucfirst($row->status),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                "font" => ["bold" => true, "color" => ["rgb" => "FFFFFF"]],
                "fill" => [
                    "fillType" => "solid",
                    "startColor" => ["rgb" => "198754"],
                ],
            ],
        ];
    }

    public function title(): string
    {
        return "Honorarium";
    }
}
