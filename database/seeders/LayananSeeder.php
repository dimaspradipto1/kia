<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $layanans = [
            [
                'judul'      => 'Pemeriksaan Kehamilan',
                'ikon'       => 'fa-female',
                'tema'       => 'pink',
                'deskripsi'  => 'Konsultasi rutin dan USG dengan standar medis internasional.',
                'urutan'     => 1,
                'is_active'  => true,
            ],
            [
                'judul'      => 'Imunisasi Anak',
                'ikon'       => 'fa-child',
                'tema'       => 'blue',
                'deskripsi'  => 'Program imunisasi lengkap sesuai jadwal pemerintah.',
                'urutan'     => 2,
                'is_active'  => true,
            ],
            [
                'judul'      => 'Konsultasi Medis',
                'ikon'       => 'fa-stethoscope',
                'tema'       => 'green',
                'deskripsi'  => 'Dokter spesialis anak dan obgyn berpengalaman.',
                'urutan'     => 3,
                'is_active'  => true,
            ],
            [
                'judul'      => 'Tumbuh Kembang',
                'ikon'       => 'fa-line-chart',
                'tema'       => 'purple',
                'deskripsi'  => 'Pantau perkembangan anak melalui aplikasi digital.',
                'urutan'     => 4,
                'is_active'  => true,
            ],
            [
                'judul'      => 'Konsultasi Gizi',
                'ikon'       => 'fa-cutlery',
                'tema'       => 'orange',
                'deskripsi'  => 'Program gizi seimbang untuk ibu dan anak.',
                'urutan'     => 5,
                'is_active'  => true,
            ],
            [
                'judul'      => 'Kesehatan Mental',
                'ikon'       => 'fa-heart',
                'tema'       => 'yellow',
                'deskripsi'  => 'Konseling untuk mengatasi stress dan kecemasan.',
                'urutan'     => 6,
                'is_active'  => true,
            ],
        ];

        foreach ($layanans as $data) {
            Layanan::firstOrCreate(
                ['judul' => $data['judul']],
                $data
            );
        }
    }
}
