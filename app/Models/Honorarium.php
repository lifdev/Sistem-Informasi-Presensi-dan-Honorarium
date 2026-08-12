<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Honorarium extends Model
{
    protected $table = 'honorarium';

    protected $fillable = [
        'karyawan_id',
        'bulan',
        'tahun',
        'total_hadir',
        'total_izin',
        'total_sakit',
        'total_alpha',
        'honorarium_pokok',
        'bonus',
        'total_potongan',
        'honorarium_bersih',
        'status',
    ];

    protected $casts = [
        'honorarium_pokok'     => 'float',
        'bonus'          => 'float',
        'total_potongan' => 'float',
        'honorarium_bersih'    => 'float',
    ];

    // Relasi ke Karyawan
    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }

    // Helper: nama bulan dalam Bahasa Indonesia
    public function namaBulan(): string
    {
        $bulan = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $bulan[$this->bulan] ?? '-';
    }
}
