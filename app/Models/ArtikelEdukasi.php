<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtikelEdukasi extends Model
{
    use HasFactory;

    protected $table = 'artikel_edukasis';

    protected $fillable = [
        'kategori_artikel_id',
        'user_id',
        'judul',
        'slug',
        'isi',
        'gambar',
        'penulis',
        'status',
        'diterbitkan_pada',
    ];

    protected $casts = [
        'diterbitkan_pada' => 'date',
    ];

    /**
     * Auto-generate slug dari judul saat creating.
     */
    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->judul);
            }
            if (empty($model->user_id)) {
                $model->user_id = auth()->id() ?? 1;
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('judul') && $model->isDirty('slug') === false) {
                $model->slug = static::generateUniqueSlug($model->judul, $model->id);
            }
        });
    }

    public static function generateUniqueSlug(string $judul, ?int $excludeId = null): string
    {
        return static::generateUniqueSlugPublic($judul, $excludeId);
    }

    public static function generateUniqueSlugPublic(string $judul, ?int $excludeId = null): string
    {
        $slug = Str::slug($judul);
        $original = $slug;
        $count = 1;

        while (
            static::where('slug', $slug)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }

    /**
     * Accessor URL gambar.
     */
    public function getGambarUrlAttribute(): ?string
    {
        if (!$this->gambar) {
            return null;
        }
        // Jika gambar lama dari mock (nama file saja), kembalikan asset homepage
        if (!str_contains($this->gambar, '/')) {
            return asset('homepage/img/' . $this->gambar);
        }
        return Storage::disk('public')->url($this->gambar);
    }

    /**
     * Scope: hanya artikel yang published.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('diterbitkan_pada')
                     ->where('diterbitkan_pada', '<=', now()->toDateString());
    }

    /**
     * Relasi ke KategoriArtikel.
     */
    public function kategoriArtikel()
    {
        return $this->belongsTo(KategoriArtikel::class, 'kategori_artikel_id');
    }

    /**
     * Relasi ke User (penulis/admin).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
