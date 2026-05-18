<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mpasi extends Model
{
    use HasFactory;

    protected $table = 'mpasis';

    protected $fillable = [
        'profil_anak_id',
        'nakes_id',
        'tanggal_mulai_mpasi',
        'jenis_mpasi',
        'frekuensi',
        'tekstur',
        'catatan_gizi',
        'dibuat_pada',
    ];

    protected $casts = [
        'tanggal_mulai_mpasi' => 'date',
        'dibuat_pada'         => 'date',
    ];

    // Jenis MPASI berdasarkan tahapan usia
    public const JENIS_MPASI = [
        'Bubur Susu',
        'Bubur Saring',
        'Pure Sayuran',
        'Pure Buah',
        'Bubur Nasi Tim',
        'Nasi Tim',
        'Finger Food',
        'Makanan Keluarga',
        'Makanan Selingan',
    ];

    // Frekuensi makan per hari
    public const FREKUENSI = [
        '1x sehari',
        '2x sehari',
        '3x sehari',
        '4x sehari',
        '2-3x sehari + 1-2x selingan',
        '3x sehari + 1-2x selingan',
    ];

    // Tekstur MPASI
    public const TEKSTUR = [
        'Cair / Encer',
        'Semipadat / Lembek',
        'Cincang Kasar',
        'Dipotong Kecil',
        'Seperti Makanan Keluarga',
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
