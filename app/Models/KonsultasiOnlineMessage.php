<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultasiOnlineMessage extends Model
{
    use HasFactory;

    protected $table = 'konsultasi_online_messages';

    protected $fillable = [
        'konsultasi_online_id',
        'sender_id',
        'message',
    ];

    /**
     * Get the consultation thread session that this message belongs to.
     */
    public function session()
    {
        return $this->belongsTo(KonsultasiOnline::class, 'konsultasi_online_id');
    }

    /**
     * Get the sender of the message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
