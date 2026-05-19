<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorKematian extends Model
{
    protected $guarded = [];

    public function faskes()
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'faskes_id');
    }

    public function wilayah()
    {
        return $this->belongsTo(WilayaDinkes::class, 'wilayah_id');
    }
}
