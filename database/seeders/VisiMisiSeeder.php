<?php

namespace Database\Seeders;

use App\Models\VisiMisi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisiMisiSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        VisiMisi::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        VisiMisi::create([
            'visi' => 'Menjadi platform digital kesehatan ibu dan anak pilihan utama di Indonesia dengan pengalaman pemantauan yang aman, personal, dan terintegrasi.',

            'misi' => [
                'Meningkatkan akses informasi kesehatan ibu dan anak di seluruh Indonesia.',
                'Menghadirkan teknologi pemantauan kesehatan digital yang mudah dan ramah pengguna.',
                'Membangun ekosistem layanan telemedisin yang menghubungkan ibu dengan tenaga kesehatan secara cepat dan terpercaya.',
                'Menjadi platform yang dapat diandalkan dan dipercaya oleh setiap keluarga Indonesia.',
            ],

            'nilai' => 'Transparansi informasi, empati yang tulus dalam pelayanan, inovasi tanpa henti, serta komitmen penuh terhadap kesejahteraan tumbuh kembang anak.',

            'nilai_items' => [
                [
                    'judul'     => 'Keamanan Data',
                    'deskripsi' => 'Rekam catatan medis KMS dan riwayat imunisasi anak tersimpan aman di cloud terenkripsi.',
                    'ikon'      => 'fa-shield',
                    'tema'      => 'pink',
                ],
                [
                    'judul'     => 'Respons Cepat',
                    'deskripsi' => 'Layanan telemedisin menghubungkan ibu hamil dengan bidan atau dokter jaga dalam hitungan menit.',
                    'ikon'      => 'fa-heartbeat',
                    'tema'      => 'green',
                ],
                [
                    'judul'     => 'Inklusif',
                    'deskripsi' => 'Dapat diakses oleh siapa saja, dari perkotaan hingga pelosok daerah dengan jaringan faskes primer terintegrasi.',
                    'ikon'      => 'fa-users',
                    'tema'      => 'blue',
                ],
                [
                    'judul'     => 'Edukatif',
                    'deskripsi' => 'Menyediakan informasi artikel kesehatan terverifikasi medis untuk menghilangkan mitos dan kecemasan.',
                    'ikon'      => 'fa-graduation-cap',
                    'tema'      => 'yellow',
                ],
            ],

            'is_active' => true,
        ]);
    }
}
