<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\AboutImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AboutSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        AboutImage::truncate();
        About::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $about = About::create([
            'judul'             => 'KIA Care adalah <span>platform kesehatan</span> ibu dan anak yang terpercaya',
            'sub_judul'         => 'Siapa Kami',
            'deskripsi_pendek'  => 'Kami membantu keluarga di seluruh Indonesia mengakses informasi kesehatan, pemantauan kehamilan, dan dukungan medis digital secara mudah.',
            'deskripsi_panjang' => 'KIA Care hadir untuk menjembatani kebutuhan ibu hamil, bayi, dan balita dengan layanan kesehatan yang terintegrasi dan ramah pengguna.',
            'fitur'             => [
                'Panduan Kehamilan Terstruktur',
                'Informasi Imunisasi dan Tumbuh Kembang',
                'Sistem Pemantauan Buku KIA Digital',
                'Fitur Konsultasi Online Bagi Ibu',
            ],
            'tahun_mengabdi'    => 10,
            'is_active'         => true,
        ]);

        // Salin gambar statis yang ada ke storage agar konsisten
        $staticImages = [
            [
                'source'      => 'homepage/img/mother_portrait_1779872791574.png',
                'dest'        => 'abouts/default_about_1.png',
                'keterangan'  => 'Ibu dan Anak',
                'is_default'  => true,
                'urutan'      => 0,
            ],
            [
                'source'      => 'homepage/img/doctor_obgyn_1779872831013.png',
                'dest'        => 'abouts/default_about_2.png',
                'keterangan'  => 'Dokter Spesialis',
                'is_default'  => false,
                'urutan'      => 1,
            ],
        ];

        foreach ($staticImages as $item) {
            $sourcePath = public_path($item['source']);
            if (file_exists($sourcePath)) {
                Storage::disk('public')->put($item['dest'], file_get_contents($sourcePath));
                $path = $item['dest'];
            } else {
                // Fallback: simpan path statis langsung
                $path = $item['source'];
            }

            AboutImage::create([
                'about_id'   => $about->id,
                'path'       => $path,
                'keterangan' => $item['keterangan'],
                'is_default' => $item['is_default'],
                'urutan'     => $item['urutan'],
            ]);
        }
    }
}
