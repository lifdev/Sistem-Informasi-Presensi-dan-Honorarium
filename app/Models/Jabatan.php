<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';

    protected $fillable = [
        'bidang_id',
        'nama',
        'deskripsi',
    ];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function pengaturanHonorarium()
    {
        return $this->hasOne(PengaturanHonorarium::class);
    }

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class);
    }
}
