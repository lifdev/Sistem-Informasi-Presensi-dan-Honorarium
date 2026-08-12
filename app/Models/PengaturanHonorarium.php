<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanHonorarium extends Model
{
    protected $table = 'pengaturan_honorarium';

    protected $fillable = [
        'jabatan_id',
        'honorarium_pokok',
        'potongan_alpha',
    ];

    protected $casts = [
        'honorarium_pokok'     => 'float',
        'potongan_alpha' => 'float',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
