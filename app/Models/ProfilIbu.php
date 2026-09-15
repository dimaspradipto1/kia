<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilIbu extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fasilitasKesehatan()
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'fasilitas_kesehatan_id');
    }

    public function bukuKias()
    {
        return $this->hasMany(BukuKia::class, 'profil_ibu_id');
    }

    public function pembiayaans()
    {
        return $this->hasMany(Pembiayaan::class, 'profil_ibu_id');
    }

    protected static function booted()
    {
        static::saved(function ($profil) {
            if ($profil->user_id) {
                $user = User::find($profil->user_id);
                $ibuRoleId = Role::whereRaw('LOWER(nama_role) = ?', ['ibu hamil'])->value('id') ?? 4;
                if ($user && $user->roles_id == $ibuRoleId) {
                    $update = [];
                    if ($profil->wasChanged('nama_lengkap') || $user->name !== $profil->nama_lengkap) {
                        $update['name'] = $profil->nama_lengkap;
                    }
                    if (($profil->wasChanged('fasilitas_kesehatan_id') || $user->fasilitas_kesehatan_id !== $profil->fasilitas_kesehatan_id) && $profil->fasilitas_kesehatan_id) {
                        $update['fasilitas_kesehatan_id'] = $profil->fasilitas_kesehatan_id;
                    }
                    if (!empty($update)) {
                        $user->updateQuietly($update);
                    }
                }
            }
        });
    }
}
