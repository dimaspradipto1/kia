<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanans';

    protected $fillable = [
        'judul',
        'ikon',
        'tema',
        'deskripsi',
        'deskripsi_panjang',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan'    => 'integer',
    ];

    /**
     * Peta warna berdasarkan tema.
     */
    public static array $temaColors = [
        'pink'   => ['bg' => '#FDF2F8', 'border' => '#FBCFE8', 'ikon' => '#EC1E88'],
        'green'  => ['bg' => '#F0FDF4', 'border' => '#BBF7D0', 'ikon' => '#22C55E'],
        'blue'   => ['bg' => '#EFF6FF', 'border' => '#BFDBFE', 'ikon' => '#3B82F6'],
        'yellow' => ['bg' => '#FFFBEB', 'border' => '#FDE68A', 'ikon' => '#F59E0B'],
        'purple' => ['bg' => '#F5F3FF', 'border' => '#DDD6FE', 'ikon' => '#8B5CF6'],
        'orange' => ['bg' => '#FFF7ED', 'border' => '#FED7AA', 'ikon' => '#F97316'],
    ];

    /**
     * Scope hanya data aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }
}
