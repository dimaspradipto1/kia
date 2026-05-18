<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KunjunganAnc extends Model
{
    protected $table = 'kunjungan_ancs';

    protected $fillable = [
        'buku_kia_id',
        'fasilitas_kesehatan_id',
        'trimester',
        'kunjungan_ke',
        'tanggal_kunjungan',
        'berat_badan',
        'tekanan_darah_sistolik',
        'tekanan_darah_diastolik',
        'tinggi_fundus_cm',
        'lila_cm',
        'denyut_jantung_janin',
        'letak_janin',
        'status_tt',
        'usg_dilakukan',
        'hasil_usg',
        'skrining_jiwa',
        'catatan',
        'nakes_id',
    ];

    public function bukuKia(): BelongsTo
    {
        return $this->belongsTo(BukuKia::class, 'buku_kia_id');
    }

    public function fasilitasKesehatan(): BelongsTo
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'fasilitas_kesehatan_id');
    }

    public function nakes(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }

    public function hasilLabIbus(): HasMany
    {
        return $this->hasMany(HasilLabIbu::class, 'kunjungan_anc_id');
    }
}
