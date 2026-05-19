<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogNotifikasi extends Model
{
    protected $table = 'log_notifikasis';

    protected $fillable = [
        'antrian_id',
        'status',
        'respons_gateway',
        'dicatat_pada',
    ];

    public $timestamps = false;

    public function antrian()
    {
        return $this->belongsTo(AntrianNotifikasi::class, 'antrian_id');
    }
}
