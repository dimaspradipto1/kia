<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KoordinatFaskesSeeder extends Seeder
{
    /**
     * Koordinat diverifikasi dari Google Maps / Nominatim / Wikimapia.
     * Sumber: maps.google.com, dinkes.batam.go.id, rsbhayangkarabatam.com
     */
    public function run(): void
    {
        $koordinat = [
            // ── Kecamatan Batu Aji ──────────────────────────────────────────
            [
                'nama'      => 'Klinik Intan Permata',
                'latitude'  => 1.0489,
                'longitude' => 103.9622,
            ],
            [
                'nama'      => 'Puskesmas Batu Aji',
                'latitude'  => 1.0498668,  // Jl. Pertiwi, Bukit Tempayan (Google Maps)
                'longitude' => 103.9646175,
            ],
            [
                'nama'      => 'RSUD Embung Fatimah',
                'latitude'  => 1.0505504,  // Jl. Letjend Suprapto No.1-9 (Google Maps)
                'longitude' => 103.9678105,
            ],

            // ── Kecamatan Bengkong ───────────────────────────────────────────
            [
                'nama'      => 'Puskesmas Bengkong',
                'latitude'  => 1.1251,
                'longitude' => 104.0480,
            ],
            [
                'nama'      => 'Klinik Kimia Farma Bengkong',
                'latitude'  => 1.1245,
                'longitude' => 104.0472,
            ],

            // ── Kecamatan Bengkong / Sei Panas ───────────────────────────────
            [
                'nama'      => 'Puskesmas Sei Panas',
                'latitude'  => 1.1453,     // Wikimapia: 1°8'43"N 104°1'40"E
                'longitude' => 104.0278,
            ],
            [
                'nama'      => 'RS Budi Kemuliaan',
                'latitude'  => 1.1479422,  // Jl. Budi Kemuliaan, Kampung Seraya
                'longitude' => 104.0184536,
            ],

            // ── Kecamatan Nongsa ─────────────────────────────────────────────
            [
                'nama'      => 'Puskesmas Nongsa',
                'latitude'  => 1.2046,
                'longitude' => 104.0890,
            ],
            [
                'nama'      => 'RS Bhayangkara Batam',
                'latitude'  => 1.1732,     // Jl. Dang Merdu KM2, Batu Besar, Nongsa
                'longitude' => 104.1089,
            ],

            // ── Kecamatan Batam Kota / Batam Center ─────────────────────────
            [
                'nama'      => 'RS Santa Elisabeth Batam Kota',
                'latitude'  => 1.1072,     // Jl. Raja Ali Kelana, Belian (Google Maps)
                'longitude' => 104.0799,
            ],
            [
                'nama'      => 'Puskesmas Batam Center',
                'latitude'  => 1.1298,
                'longitude' => 104.0530,
            ],
        ];

        foreach ($koordinat as $item) {
            DB::table('fasilitas_kesehatans')
                ->where('nama_faskes', $item['nama'])
                ->whereNull('latitude')
                ->update([
                    'latitude'   => $item['latitude'],
                    'longitude'  => $item['longitude'],
                    'updated_at' => now(),
                ]);
        }

        $this->command->info('Koordinat faskes berhasil diisi (' . count($koordinat) . ' faskes).');
    }
}
