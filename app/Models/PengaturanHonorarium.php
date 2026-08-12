<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanHonorarium extends Model
{
    protected $table = 'pengaturan_honorarium';

    protected $fillable = [
        'jabatan_id',
        'tipe',
        'honorarium_pokok',
        'potongan_alpha',
        'tarif_per_hadir',
    ];

    protected $casts = [
        'honorarium_pokok' => 'float',
        'potongan_alpha'   => 'float',
        'tarif_per_hadir'  => 'float',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function isPerHadir(): bool
    {
        return $this->tipe === 'per_hadir';
    }

    public function isBulanan(): bool
    {
        return $this->tipe === 'bulanan';
    }
}
