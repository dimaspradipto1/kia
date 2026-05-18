<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerkembanganSidtk extends Model
{
    use HasFactory;

    protected $table = 'perkembangan_sidtks';

    protected $fillable = [
        'profil_anak_id',
        'nakes_id',
        'tanggal_skrining',
        'usia_bulan',
        'domain',
        'hasil',
        'tindak_lanjut',
    ];

    protected $casts = [
        'tanggal_skrining' => 'date',
    ];

    // Domain perkembangan SIDTK
    public const DOMAINS = [
        'Gerak Kasar',
        'Gerak Halus',
        'Bicara & Bahasa',
        'Sosialisasi & Kemandirian',
        'Kognitif',
    ];

    // Hasil skrining SIDTK
    public const HASIL = [
        'Sesuai',
        'Meragukan',
        'Penyimpangan',
    ];

    // Tindak lanjut
    public const TINDAK_LANJUT = [
        'Lanjutkan Stimulasi',
        'Evaluasi Ulang 1 Bulan',
        'Konseling Orang Tua',
        'Rujuk ke Puskesmas',
        'Rujuk ke Dokter Spesialis',
        'Intervensi Dini',
    ];

    public function profilAnak()
    {
        return $this->belongsTo(ProfilAnak::class, 'profil_anak_id');
    }

    public function nakes()
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }
}
