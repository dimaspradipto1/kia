<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Selaraskan nama_lengkap di profil_ibus dengan name di users jika berbeda
        $users = DB::table('users')
            ->join('profil_ibus', 'profil_ibus.user_id', '=', 'users.id')
            ->select('users.id as user_id', 'users.name as user_name', 'users.fasilitas_kesehatan_id as user_faskes', 'profil_ibus.id as profil_id', 'profil_ibus.nama_lengkap as profil_name')
            ->get();

        foreach ($users as $u) {
            $update = [];
            if ($u->user_name && $u->user_name !== $u->profil_name) {
                $update['nama_lengkap'] = $u->user_name;
            }
            if ($u->user_faskes) {
                $update['fasilitas_kesehatan_id'] = $u->user_faskes;
            }

            if (!empty($update)) {
                $update['updated_at'] = now();
                DB::table('profil_ibus')->where('id', $u->profil_id)->update($update);
            }
        }

        // 2. Buatkan ProfilIbu untuk semua akun User Ibu Hamil (roles_id = 4) yang belum memiliki profil
        $orphanedIbu = DB::table('users')
            ->where('roles_id', 4)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('profil_ibus')
                    ->whereColumn('profil_ibus.user_id', 'users.id');
            })
            ->get();

        foreach ($orphanedIbu as $user) {
            $nik = '32' . str_pad($user->id, 14, '0', STR_PAD_LEFT);
            DB::table('profil_ibus')->insert([
                'user_id' => $user->id,
                'fasilitas_kesehatan_id' => $user->fasilitas_kesehatan_id ?? 1,
                'nik' => $nik,
                'nama_lengkap' => $user->name,
                'tempat_lahir' => '-',
                'tanggal_lahir' => '1995-01-01',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback needed for data synchronization
    }
};
