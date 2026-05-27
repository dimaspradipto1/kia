<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananIntro extends Model
{
    protected $table = 'layanan_intros';

    protected $fillable = [
        'badge_text',
        'judul',
        'deskripsi',
        'fitur',
        'is_active',
    ];

    protected $casts = [
        'fitur'     => 'array',
        'is_active' => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany(LayananIntroImage::class)->orderBy('urutan');
    }

    public function defaultImage()
    {
        return $this->hasOne(LayananIntroImage::class)->where('is_default', true);
    }

    public function secondaryImages()
    {
        return $this->hasMany(LayananIntroImage::class)->where('is_default', false)->orderBy('urutan');
    }
}
