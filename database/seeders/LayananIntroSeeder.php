<?php

namespace Database\Seeders;

use App\Models\LayananIntro;
use Illuminate\Database\Seeder;

class LayananIntroSeeder extends Seeder
{
    public function run(): void
    {
        LayananIntro::firstOrCreate(
            ['judul' => 'KIA Care adalah **platform kesehatan** ibu dan anak'],
            [
                'badge_text' => 'Tentang Layanan',
                'judul'      => 'KIA Care adalah **platform kesehatan** ibu dan anak',
                'deskripsi'  => 'Kami menyediakan layanan kesehatan terpadu yang menghubungkan ibu, anak, dan fasilitas kesehatan profesional.',
                'fitur'      => [
                    [
                        'judul'     => 'Jejaring Kesehatan Luas',
                        'deskripsi' => 'Bekerjasama dengan puskesmas dan rumah sakit terpercaya di seluruh Indonesia',
                    ],
                    [
                        'judul'     => 'Tenaga Medis Profesional',
                        'deskripsi' => 'Dokter spesialis dan bidan berpengalaman siap melayani 24/7',
                    ],
                    [
                        'judul'     => 'Teknologi Digital Terdepan',
                        'deskripsi' => 'Integrasi teknologi untuk kemudahan akses dan monitoring kesehatan',
                    ],
                ],
                'is_active'  => true,
            ]
        );
    }
}
