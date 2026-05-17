<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemantauanNifas extends Model
{
    protected $table = 'pemantauan_nifas';

    protected $guarded = [];

    public function bukuKia()
    {
        return $this->belongsTo(BukuKia::class, 'buku_kia_id');
    }

    public function nakes()
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }
}
