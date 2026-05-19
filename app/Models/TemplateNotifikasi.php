<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateNotifikasi extends Model
{
    protected $table = 'template_notifikasis';

    protected $fillable = [
        'nama',
        'jenis',
        'saluran',
        'subjek',
        'isi_template',
        'variabel_tersedia',
        'aktif',
        'dibuat_oleh',
    ];

    public $timestamps = false;

    public function creator()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function jadwals()
    {
        return $this->hasMany(JadwalNotifikasi::class, 'template_id');
    }
}
