<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanJam extends Model
{
    protected $table = 'pengaturan_jam';

    protected $fillable = [
        'jam_masuk_mulai', 'jam_masuk_selesai',
        'jam_pulang_mulai', 'jam_pulang_selesai',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    // Ambil pengaturan aktif
    public static function aktif(): ?self
    {
        return self::where('aktif', true)->first();
    }
}