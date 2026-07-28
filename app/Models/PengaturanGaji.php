<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanGaji extends Model
{
    protected $table = 'pengaturan_gaji';

    protected $fillable = [
        'jabatan_id',
        'gaji_pokok',
        'tunjangan_hadir',
        'potongan_alpha',
        'potongan_izin',
        'potongan_sakit',
    ];

    protected $casts = [
        'gaji_pokok'      => 'float',
        'tunjangan_hadir' => 'float',
        'potongan_alpha'  => 'float',
        'potongan_izin'   => 'float',
        'potongan_sakit'  => 'float',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
