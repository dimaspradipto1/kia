<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan',
        'foto',
        'linkedin',
        'tiktok',
        'instagram',
        'facebook',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * URL foto: cek storage → fallback ke asset publik langsung.
     */
    public function getFotoUrlAttribute(): string
    {
        if (!$this->foto) {
            return asset('homepage/img/default_avatar.png');
        }
        if (Storage::disk('public')->exists($this->foto)) {
            return asset('storage/' . $this->foto);
        }
        // path statis (seeder default)
        return asset($this->foto);
    }
}
