<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Karyawan extends Model
{
    protected $table = 'karyawan';

    protected $fillable = [
        'nip',
        'nama',
        'jabatan_id',
        'honorarium_tipe',
        'honorarium_pokok',
        'tarif_per_hadir',
        'jenis_kelamin',
        'no_hp',
        'alamat',
        'tanggal_masuk',
        'status',
    ];

    protected $casts = [
        'tanggal_masuk'    => 'date',
        'honorarium_pokok' => 'float',
        'tarif_per_hadir'  => 'float',
    ];

    // Relasi ke User (1 karyawan punya 1 akun)
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    // Relasi ke Presensi
    public function presensi(): HasMany
    {
        return $this->hasMany(Presensi::class);
    }

    // Relasi ke Izin
    public function izin(): HasMany
    {
        return $this->hasMany(Izin::class);
    }

    // Relasi ke Honorarium
    public function honorarium(): HasMany
    {
        return $this->hasMany(Honorarium::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
