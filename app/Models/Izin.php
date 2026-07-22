<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Izin extends Model
{
    protected $table = 'izin';

    protected $fillable = [
        'karyawan_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis',
        'alasan',
        'lampiran',
        'status',
        'disetujui_oleh',
        'disetujui_at',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'disetujui_at'    => 'datetime',
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

    // Helper: hitung jumlah hari izin
    public function jumlahHari(): int
    {
        return $this->tanggal_mulai->diffInDays($this->tanggal_selesai) + 1;
    }
}
