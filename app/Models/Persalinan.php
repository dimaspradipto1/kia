<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persalinan extends Model
{
    use HasFactory;

    protected $table = 'persalinans';

    protected $guarded = [];

    public function bukuKia()
    {
        return $this->belongsTo(BukuKia::class, 'buku_kia_id');
    }

    public function fasilitasKesehatan()
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'fasilitas_kesehatan_id');
    }

    public function nakes()
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }

    public function bayiBaruLahirs()
    {
        return $this->hasMany(BayiBaruLahir::class, 'persalinan_id');
    }
}
