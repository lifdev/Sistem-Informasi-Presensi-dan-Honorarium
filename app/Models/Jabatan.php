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

    public function pengaturanGaji()
    {
    return $this->hasOne(PengaturanGaji::class);
    }
}
