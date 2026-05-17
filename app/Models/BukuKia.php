<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuKia extends Model
{
    use HasFactory;

    protected $table = 'buku_kias';

    protected $fillable = [
        'profil_ibu_id',
        'fasilitas_kesehatan_id',
        'no_reg_kohort_ibu',
        'no_reg_kohort_bayi',
        'no_reg_kohort_balita',
        'kehamilan_ke',
        'jumlah_anak_hidup',
        'riwayat_keguguran',
        'riwayat_penyakit',
        'no_catatan_medik_rs',
        'qr_code',
        'status',
        'diterbitkan_pada',
        'diterbitkan_oleh',
    ];

    public function profilIbu()
    {
        return $this->belongsTo(ProfilIbu::class, 'profil_ibu_id');
    }

    public function profilAnak()
    {
        return $this->hasMany(ProfilAnak::class, 'buku_kia_id');
    }

    public function profilSuami()
    {
        return $this->hasOneThrough(
            ProfilSuami::class,
            ProfilIbu::class,
            'id',            // Foreign key on profil_ibus (PK)
            'profil_ibu_id', // Foreign key on profil_suamis
            'profil_ibu_id', // Local key on buku_kias
            'id'             // Local key on profil_ibus
        );
    }

    public function fasilitasKesehatan()
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'fasilitas_kesehatan_id');
    }

    public function pembiayaans()
    {
        return $this->hasMany(Pembiayaan::class, 'profil_ibu_id', 'profil_ibu_id');
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class, 'buku_kia_id');
    }
}
