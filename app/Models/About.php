<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'sub_judul',
        'deskripsi_pendek',
        'deskripsi_panjang',
        'fitur',
        'tahun_mengabdi',
        'is_active',
    ];

    protected $casts = [
        'fitur'      => 'array',
        'is_active'  => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany(AboutImage::class)->orderBy('urutan');
    }

    public function defaultImage()
    {
        return $this->hasOne(AboutImage::class)->where('is_default', true);
    }

    public function secondaryImages()
    {
        return $this->hasMany(AboutImage::class)->where('is_default', false)->orderBy('urutan');
    }
}
