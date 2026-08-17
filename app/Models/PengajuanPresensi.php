<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanPresensi extends Model
{
    protected $table = 'pengajuan_presensi';

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'jam_masuk',
        'alasan',
        'lampiran',
        'status',
        'disetujui_oleh',
        'disetujui_at',
    ];

    protected $casts = [
        'tanggal'      => 'date',
        'disetujui_at' => 'datetime',
    ];

    // Relasi ke Karyawan
    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }

    // Relasi ke User yang menyetujui
    public function penyetuju(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
}
