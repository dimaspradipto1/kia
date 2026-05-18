<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilAnak extends Model
{
    use HasFactory;

    protected $table = 'profil_anaks';

    protected $fillable = [
        'buku_kia_id',
        'nama_lengkap',
        'jenis_kelamin',
        'anak_ke',
        'tempat_lahir',
        'tanggal_lahir',
        'golongan_darah',
        'nomor_akta_kelahiran',
        'berat_lahir_kg',
        'panjang_lahir_cm',
    ];

    public function bukuKia()
    {
        return $this->belongsTo(BukuKia::class, 'buku_kia_id');
    }

    public function bayiBaruLahir()
    {
        return $this->hasOne(BayiBaruLahir::class, 'profil_anak_id');
    }
}
