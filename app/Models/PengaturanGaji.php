<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanGaji extends Model
{
    protected $table = 'pengaturan_gaji';

    protected $fillable = [
        'jabatan_id',
        'gaji_pokok',
        'potongan_alpha',
    ];

    protected $casts = [
        'gaji_pokok'     => 'float',
        'potongan_alpha' => 'float',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
