<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AboutImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_id',
        'path',
        'keterangan',
        'is_default',
        'urutan',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function about()
    {
        return $this->belongsTo(About::class);
    }

    /**
     * URL lengkap gambar, support path storage maupun path asset statis.
     */
    public function getUrlAttribute(): string
    {
        // Path yang disimpan via storage disk (misal: abouts/xxx.jpg)
        if (Storage::disk('public')->exists($this->path)) {
            return asset('storage/' . $this->path);
        }
        // Fallback ke path asset publik langsung (misal: homepage/img/xxx.png)
        return asset($this->path);
    }
}
