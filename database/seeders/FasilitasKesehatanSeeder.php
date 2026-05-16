<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FasilitasKesehatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('fasilitas_kesehatans')->insert([
            [
                'nama_faskes'      => 'Klinik Intan Permata',
                'jenis'            => 'Klinik',
                'alamat'           => 'Jl. Permata Raya, Perumahan Intan Permata, Batu Aji',
                'kecamatan'        => 'Batu Aji',
                'kab_kota'         => 'Kota Batam',
                'provinsi'         => 'Kepulauan Riau',
                'embed_map'        => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d997.3084948248257!2d103.9668507!3d1.0554896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d98daf5747c8f3%3A0x369edd1d874a8e91!2sKlinik%20Intan%20Permata!5e0!3m2!1sid!2sid!4v1715000000000" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'telepon'          => '077812345678',
                'jam_buka'         => '08:00',
                'jam_tutup'        => '21:00',
                'jam_operasional'  => 'Senin - Minggu, 08.00 - 21.00 WIB',
                'is_active'        => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
        ]);
    }
}
