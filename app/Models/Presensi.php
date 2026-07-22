<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presensi extends Model
{
    protected $table = 'presensi';

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'lat_masuk',
        'lng_masuk',
        'lat_pulang',
        'lng_pulang',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal'    => 'date',
        'lat_masuk'  => 'float',
        'lng_masuk'  => 'float',
        'lat_pulang' => 'float',
        'lng_pulang' => 'float',
    ];

    // Relasi ke Karyawan
    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }

    // Helper: hitung jarak GPS dari lokasi kantor (meter)
    public static function hitungJarak(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $r = 6371000; // Radius bumi dalam meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        return $r * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}
