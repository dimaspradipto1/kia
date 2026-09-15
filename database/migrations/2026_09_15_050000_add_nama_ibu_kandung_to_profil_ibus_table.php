<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\ProfilIbu;
use App\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('profil_ibus')) {
            Schema::table('profil_ibus', function (Blueprint $table) {
                if (!Schema::hasColumn('profil_ibus', 'nama_ibu_kandung')) {
                    $table->string('nama_ibu_kandung')->nullable()->after('nama_lengkap');
                }
                if (Schema::hasColumn('profil_ibus', 'tempat_lahir')) {
                    $table->string('tempat_lahir')->nullable()->default('-')->change();
                }
                if (Schema::hasColumn('profil_ibus', 'tanggal_lahir')) {
                    $table->date('tanggal_lahir')->nullable()->change();
                }
            });
        }

        if (Schema::hasTable('buku_kias')) {
            Schema::table('buku_kias', function (Blueprint $table) {
                if (Schema::hasColumn('buku_kias', 'no_reg_kohort_bayi')) {
                    $table->string('no_reg_kohort_bayi')->nullable()->default('-')->change();
                }
                if (Schema::hasColumn('buku_kias', 'no_reg_kohort_balita')) {
                    $table->string('no_reg_kohort_balita')->nullable()->default('-')->change();
                }
                if (Schema::hasColumn('buku_kias', 'riwayat_penyakit')) {
                    $table->string('riwayat_penyakit')->nullable()->change();
                }
                if (Schema::hasColumn('buku_kias', 'no_catatan_medik_rs')) {
                    $table->string('no_catatan_medik_rs')->nullable()->change();
                }
            });
        }

        // Auto-provision ProfilIbu untuk setiap user Ibu Hamil yang belum memiliki Profil Ibu
        // agar otomatis muncul di menu dan dashboard Kader Posyandu
        $ibuRoleId = Role::whereRaw('LOWER(nama_role) = ?', ['ibu hamil'])->value('id') ?? 4;
        $usersWithoutProfile = User::where('roles_id', $ibuRoleId)->doesntHave('profilIbu')->get();

        foreach ($usersWithoutProfile as $u) {
            $nik = '32' . str_pad($u->id, 14, '0', STR_PAD_LEFT);
            // Cek apakah NIK sudah dipakai
            if (ProfilIbu::where('nik', $nik)->exists()) {
                $nik = '32' . str_pad($u->id . mt_rand(100, 999), 14, '0', STR_PAD_LEFT);
            }

            ProfilIbu::create([
                'user_id' => $u->id,
                'fasilitas_kesehatan_id' => $u->fasilitas_kesehatan_id ?? 1,
                'nik' => $nik,
                'nama_lengkap' => $u->name,
                'nama_ibu_kandung' => null,
                'tempat_lahir' => '-',
                'tanggal_lahir' => '1995-01-01',
                'alamat' => '-',
                'nomor_wa' => null,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('profil_ibus') && Schema::hasColumn('profil_ibus', 'nama_ibu_kandung')) {
            Schema::table('profil_ibus', function (Blueprint $table) {
                $table->dropColumn('nama_ibu_kandung');
            });
        }
    }
};
