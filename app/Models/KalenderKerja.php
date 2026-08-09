<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KalenderKerja extends Model
{
    protected $table = 'kalender_kerja';

    protected $fillable = [
        'tanggal',
        'is_hari_kerja',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_hari_kerja' => 'boolean',
    ];

    // Nama hari dalam Bahasa Indonesia
    public function getNamaHariAttribute(): string
    {
        return $this->tanggal->locale('id')->translatedFormat('l');
    }
}
