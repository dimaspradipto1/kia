<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntrianNotifikasi extends Model
{
    protected $table = 'antrian_notifikasis';

    protected $fillable = [
        'jadwal_id',
        'pengguna_id',
        'buku_kia_id',
        'profil_anak_id',
        'saluran',
        'tujuan',
        'subjek',
        'isi',
        'status',
        'percobaan',
        'dijadwalkan_pada',
        'dikirim_pada',
        'pesan_error',
    ];

    public $timestamps = false;

    public function jadwal()
    {
        return $this->belongsTo(JadwalNotifikasi::class, 'jadwal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function bukuKia()
    {
        return $this->belongsTo(BukuKia::class, 'buku_kia_id');
    }

    public function profilAnak()
    {
        return $this->belongsTo(ProfilAnak::class, 'profil_anak_id');
    }

    public function logs()
    {
        return $this->hasMany(LogNotifikasi::class, 'antrian_id');
    }
}
