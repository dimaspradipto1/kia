<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Team::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $members = [
            [
                'nama'      => 'Dr. Sari Wati',
                'jabatan'   => 'Chief Medical Officer',
                'source'    => 'homepage/img/nurse_doctor1_1779872814462.png',
                'dest'      => 'teams/default_team_1.png',
                'linkedin'  => null,
                'tiktok'    => null,
                'instagram' => null,
                'facebook'  => null,
                'urutan'    => 1,
            ],
            [
                'nama'      => 'Anton Prasetyo',
                'jabatan'   => 'Head of Product',
                'source'    => 'homepage/img/anton_prasetyo_1779875068396.png',
                'dest'      => 'teams/default_team_2.png',
                'linkedin'  => null,
                'tiktok'    => null,
                'instagram' => null,
                'facebook'  => null,
                'urutan'    => 2,
            ],
            [
                'nama'      => 'Rina Mulyani',
                'jabatan'   => 'Head of Customer Care',
                'source'    => 'homepage/img/rina_mulyani_1779875089014.png',
                'dest'      => 'teams/default_team_3.png',
                'linkedin'  => null,
                'tiktok'    => null,
                'instagram' => null,
                'facebook'  => null,
                'urutan'    => 3,
            ],
            [
                'nama'      => 'Budi Santoso',
                'jabatan'   => 'Head of Development',
                'source'    => 'homepage/img/budi_santoso_1779875109468.png',
                'dest'      => 'teams/default_team_4.png',
                'linkedin'  => null,
                'tiktok'    => null,
                'instagram' => null,
                'facebook'  => null,
                'urutan'    => 4,
            ],
        ];

        foreach ($members as $m) {
            $sourcePath = public_path($m['source']);
            $fotoPath   = null;

            if (file_exists($sourcePath)) {
                Storage::disk('public')->put($m['dest'], file_get_contents($sourcePath));
                $fotoPath = $m['dest'];
            } else {
                // Fallback: simpan path statis
                $fotoPath = $m['source'];
            }

            Team::create([
                'nama'      => $m['nama'],
                'jabatan'   => $m['jabatan'],
                'foto'      => $fotoPath,
                'linkedin'  => $m['linkedin'],
                'tiktok'    => $m['tiktok'],
                'instagram' => $m['instagram'],
                'facebook'  => $m['facebook'],
                'urutan'    => $m['urutan'],
                'is_active' => true,
            ]);
        }
    }
}
