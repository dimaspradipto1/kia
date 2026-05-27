<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisiMisi extends Model
{
    protected $table = 'visi_misi';

    protected $fillable = [
        'visi',
        'misi',
        'nilai',
        'nilai_items',
        'is_active',
    ];

    protected $casts = [
        'misi'        => 'array',
        'nilai_items' => 'array',
        'is_active'   => 'boolean',
    ];

    /**
     * Peta warna berdasarkan tema untuk nilai_items.
     */
    public static array $temaColors = [
        'pink'   => ['bg' => '#FDF2F8', 'border' => '#FBCFE8', 'ikon' => '#EC1E88'],
        'green'  => ['bg' => '#F0FDF4', 'border' => '#BBF7D0', 'ikon' => '#22C55E'],
        'blue'   => ['bg' => '#EFF6FF', 'border' => '#BFDBFE', 'ikon' => '#3B82F6'],
        'yellow' => ['bg' => '#FFFBEB', 'border' => '#FDE68A', 'ikon' => '#F59E0B'],
        'purple' => ['bg' => '#F5F3FF', 'border' => '#DDD6FE', 'ikon' => '#8B5CF6'],
        'orange' => ['bg' => '#FFF7ED', 'border' => '#FED7AA', 'ikon' => '#F97316'],
    ];
}
