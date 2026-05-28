<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriArtikel extends Model
{
    use HasFactory;

    protected $table = 'kategori_artikels';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
    ];

    /**
     * Auto-generate slug dari nama.
     */
    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('nama')) {
                $model->slug = Str::slug($model->nama);
            }
        });
    }

    /**
     * Relasi ke Artikel Edukasi.
     */
    public function artikels()
    {
        return $this->hasMany(ArtikelEdukasi::class, 'kategori_artikel_id');
    }
}
