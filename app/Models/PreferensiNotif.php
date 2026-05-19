<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreferensiNotif extends Model
{
    protected $table = 'preferensi_notifs';

    protected $fillable = [
        'pengguna_id',
        'saluran',
        'aktif',
        'jam_mulai',
        'jam_selesai',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }
}
