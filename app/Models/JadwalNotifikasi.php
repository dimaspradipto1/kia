<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalNotifikasi extends Model
{
    protected $table = 'jadwal_notifikasis';

    protected $fillable = [
        'template_id',
        'jenis_trigger',
        'referensi_tabel',
        'offset_hari',
        'waktu_kirim',
        'aktif',
        'dibuat_oleh',
    ];

    public $timestamps = false;

    public function template()
    {
        return $this->belongsTo(TemplateNotifikasi::class, 'template_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function antrians()
    {
        return $this->hasMany(AntrianNotifikasi::class, 'jadwal_id');
    }
}
