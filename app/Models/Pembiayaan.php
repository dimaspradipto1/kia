<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembiayaan extends Model
{
    use HasFactory;

    protected $table = 'pembiayaans';

    protected $fillable = [
        'profil_ibu_id',
        'jenis_pembiayaan',
        'nama_asuransi',
        'nomor_polis',
        'tanggal_berlaku',
        'is_active',
    ];

    protected $casts = [
        'tanggal_berlaku' => 'date',
        'is_active'       => 'boolean',
    ];

    public function profilIbu()
    {
        return $this->belongsTo(ProfilIbu::class, 'profil_ibu_id');
    }
}
