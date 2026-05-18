<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BayiBaruLahir extends Model
{
    use HasFactory;

    protected $table = 'bayi_baru_lahirs';

    protected $fillable = [
        'profil_anak_id',
        'persalinan_id',
        'nakes_id',
        'hb0_diberikan',
        'hb0_waktu',
        'vit_k1_diberikan',
        'salep_mata_diberikan',
        'shk_dilakukan',
        'shk_waktu',
        'shk_hasil',
        'pjb_dilakukan',
        'pjb_hasil',
        'kondisi_umum',
    ];

    protected $casts = [
        'hb0_diberikan'      => 'boolean',
        'vit_k1_diberikan'   => 'boolean',
        'salep_mata_diberikan' => 'boolean',
        'shk_dilakukan'      => 'boolean',
        'pjb_dilakukan'      => 'boolean',
    ];

    public function profilAnak()
    {
        return $this->belongsTo(ProfilAnak::class, 'profil_anak_id');
    }

    public function persalinan()
    {
        return $this->belongsTo(Persalinan::class, 'persalinan_id');
    }

    public function nakes()
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }
}
