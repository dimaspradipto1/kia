<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasKesehatan extends Model
{
    protected $guarded = [];

    public function profilIbus()
    {
        return $this->hasMany(ProfilIbu::class, 'fasilitas_kesehatan_id');
    }

    public function bukuKias()
    {
        return $this->hasMany(BukuKia::class, 'fasilitas_kesehatan_id');
    }

    public function kunjunganAncs()
    {
        return $this->hasMany(KunjunganAnc::class, 'fasilitas_kesehatan_id');
    }
}

