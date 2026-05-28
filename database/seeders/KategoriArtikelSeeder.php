<?php

namespace Database\Seeders;

use App\Models\KategoriArtikel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriArtikelSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Kehamilan',      'deskripsi' => 'Informasi dan tips seputar masa kehamilan.'],
            ['nama' => 'Imunisasi',      'deskripsi' => 'Panduan imunisasi dasar dan lanjutan untuk bayi dan anak.'],
            ['nama' => 'Parenting',      'deskripsi' => 'Tips pengasuhan dan ikatan batin orang tua dan anak.'],
            ['nama' => 'Gizi & Nutrisi', 'deskripsi' => 'Panduan nutrisi seimbang untuk ibu hamil, bayi, dan balita.'],
            ['nama' => 'Tumbuh Kembang', 'deskripsi' => 'Pemantauan pertumbuhan dan perkembangan anak.'],
        ];

        foreach ($kategoris as $kat) {
            KategoriArtikel::firstOrCreate(
                ['slug' => Str::slug($kat['nama'])],
                ['nama' => $kat['nama'], 'deskripsi' => $kat['deskripsi']]
            );
        }
    }
}
