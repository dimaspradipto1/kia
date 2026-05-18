<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persalinan extends Model
{
    use HasFactory;

    protected $table = 'persalinans';

    protected $fillable = [];

    public function bayiBaruLahirs()
    {
        return $this->hasMany(BayiBaruLahir::class, 'persalinan_id');
    }
}
