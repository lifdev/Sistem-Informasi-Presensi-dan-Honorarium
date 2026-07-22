<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanLokasi extends Model
{
    protected $table = 'pengaturan_lokasi';

    protected $fillable = [
        'nama_lokasi',
        'latitude',
        'longitude',
        'radius_meter',
        'aktif',
    ];

    protected $casts = [
        'latitude'  => 'float',
        'longitude' => 'float',
        'aktif'     => 'boolean',
    ];
}
