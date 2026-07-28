<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $table = 'bidang';

    protected $fillable = [
        'nama',
        'deskripsi'
    ];

    public function jabatan()
    {
        return $this->hasMany(Jabatan::class);
    }
}
