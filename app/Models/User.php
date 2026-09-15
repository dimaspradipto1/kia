<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles_id',
        'wilaya_dinkes_id',
        'fasilitas_kesehatan_id',
        'is_active',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'roles_id');
    }

    public function wilayaDinkes()
    {
        return $this->belongsTo(WilayaDinkes::class, 'wilaya_dinkes_id');
    }

    public function fasilitasKesehatan()
    {
        return $this->belongsTo(FasilitasKesehatan::class, 'fasilitas_kesehatan_id');
    }

    public function profilIbu()
    {
        return $this->hasOne(ProfilIbu::class);
    }

    protected static function booted()
    {
        static::saved(function ($user) {
            $profil = ProfilIbu::where('user_id', $user->id)->first();
            if ($profil) {
                $update = [];
                if ($user->wasChanged('name') || $profil->nama_lengkap !== $user->name) {
                    $update['nama_lengkap'] = $user->name;
                }
                if (($user->wasChanged('fasilitas_kesehatan_id') || $profil->fasilitas_kesehatan_id !== $user->fasilitas_kesehatan_id) && $user->fasilitas_kesehatan_id) {
                    $update['fasilitas_kesehatan_id'] = $user->fasilitas_kesehatan_id;
                }
                if (!empty($update)) {
                    $profil->updateQuietly($update);
                }
            }
        });
    }
}
