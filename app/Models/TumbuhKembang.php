<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TumbuhKembang extends Model
{
    use HasFactory;

    protected $table = 'tumbuh_kembangs';

    protected $fillable = [
        'profil_anak_id',
        'fasilitas_kesehatan_id',
        'nakes_id',
        'tanggal_ukur',
        'usia_bulan',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'lila_cm',
        'status_gizi_bb_u',
        'status_gizi_tb_u',
        'status_gizi_bb_tb',
        'status_stunting',
        'catatan',
    ];

    protected $casts = [
        'tanggal_ukur'   => 'date',
        'berat_badan'    => 'decimal:2',
        'tinggi_badan'   => 'decimal:2',
        'lingkar_kepala' => 'decimal:2',
        'lila_cm'        => 'decimal:2',
    ];

    public function profilAnak()
    {
        return $this->belongsTo(ProfilAnak::class, 'profil_anak_id');
    }

    public function fasilitasKesehatan()
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'fasilitas_kesehatan_id');
    }

    public function nakes()
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }
}
