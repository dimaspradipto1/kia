<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilIbu extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fasilitasKesehatan()
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'fasilitas_kesehatan_id');
    }

    public function bukuKias()
    {
        return $this->hasMany(BukuKia::class, 'profil_ibu_id');
    }

    public function pembiayaans()
    {
        return $this->hasMany(Pembiayaan::class, 'profil_ibu_id');
    }
}
