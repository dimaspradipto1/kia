<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WilayahDinkesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_dinkes' => 'Dinas Kesehatan Kepulauan Riau',
                'tipe_dinkes' => 'provinsi',
                'kode_dinkes' => 'DKRI',
            ],
            [
                'nama_dinkes' => 'Dinas Kesehatan Kota Batam',
                'tipe_dinkes' => 'kota',
                'kode_dinkes' => 'DKBAT',
            ],
            [
                'nama_dinkes' => 'Puskesmas Batam Kota',
                'tipe_dinkes' => 'puskesmas',
                'kode_dinkes' => 'PKBK',
            ],
            [
                'nama_dinkes' => 'Puskesmas Sei Panas',
                'tipe_dinkes' => 'puskesmas',
                'kode_dinkes' => 'PKSP',
            ],
            [
                'nama_dinkes' => 'Puskesmas Batu Ampar',
                'tipe_dinkes' => 'puskesmas',
                'kode_dinkes' => 'PKBA',
            ],
        ];

        foreach ($data as $item) {
            \App\Models\WilayaDinkes::create($item);
        }
    }
}
