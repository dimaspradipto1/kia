<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultasiOnline extends Model
{
    use HasFactory;

    protected $table = 'konsultasi_onlines';

    protected $fillable = [
        'user_id',
        'fasilitas_kesehatan_id',
        'topik',
        'pesan',
        'respons',
        'direspons_oleh',
        'status',
        'direspons_pada',
    ];

    protected $casts = [
        'direspons_pada' => 'datetime',
    ];

    /**
     * Get the user (patient) who submitted the consultation.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the target health facility.
     */
    public function fasilitasKesehatan()
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'fasilitas_kesehatan_id');
    }

    /**
     * Get all chat messages for this conversation session.
     */
    public function messages()
    {
        return $this->hasMany(KonsultasiOnlineMessage::class, 'konsultasi_online_id')->orderBy('created_at', 'asc');
    }
}
