<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertTandaBahaya extends Model
{
    protected $table = 'alert_tanda_bahayas';

    protected $fillable = [
        'buku_kia_id',
        'profil_anak_id',
        'jenis_bahaya',
        'deskripsi',
        'tingkat_urgensi',
        'sudah_ditangani',
        'ditangani_oleh',
        'dibuat_pada',
        'ditangani_pada',
    ];

    public $timestamps = false;

    public function bukuKia()
    {
        return $this->belongsTo(BukuKia::class, 'buku_kia_id');
    }

    public function profilAnak()
    {
        return $this->belongsTo(ProfilAnak::class, 'profil_anak_id');
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'ditangani_oleh');
    }
}
