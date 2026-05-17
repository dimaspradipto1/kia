<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KbPascaSalin extends Model
{
    use HasFactory;

    protected $table = 'kb_pasca_salins';

    protected $fillable = [
        'buku_kia_id',
        'nakes_id',
        'fasilitas_kesehatan_id',
        'metode_kb',
        'tanggal_mulai',
        'catatan',
    ];

    public function bukuKia()
    {
        return $this->belongsTo(BukuKia::class, 'buku_kia_id');
    }

    public function nakes()
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }

    public function fasilitasKesehatan()
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'fasilitas_kesehatan_id');
    }
}
