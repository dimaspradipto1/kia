<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilSuami extends Model
{
    use HasFactory;

    protected $table = 'profil_suamis';

    protected $fillable = [
        'profil_ibu_id',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'golongan_darah',
        'pendidikan',
        'pekerjaan',
        'nomor_wa',
    ];

    public function profilIbu()
    {
        return $this->belongsTo(ProfilIbu::class, 'profil_ibu_id');
    }
}
