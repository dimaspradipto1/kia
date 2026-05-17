<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WilayaDinkes extends Model
{
    protected $table = 'wilaya_dinkes';

    protected $fillable = [
        'kode_dinkes',
        'nama_dinkes',
        'tipe_dinkes',
    ];
}
