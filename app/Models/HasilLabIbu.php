<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilLabIbu extends Model
{
    protected $table = 'hasil_lab_ibus';

    protected $fillable = [
        'kunjungan_anc_id',
        'jenis_pemeriksaan',
        'hasil',
        'satuan',
        'nilai_normal',
        'tanggal_periksa',
        'nakes_id',
    ];

    public function kunjunganAnc(): BelongsTo
    {
        return $this->belongsTo(KunjunganAnc::class, 'kunjungan_anc_id');
    }

    public function nakes(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }
}
