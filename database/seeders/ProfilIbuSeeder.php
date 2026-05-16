<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProfilIbuSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user ibu hamil berdasarkan email
        $azizah = User::where('email', 'azizah@gmail.com')->first();
        $dian    = User::where('email', 'dian@gmail.com')->first();

        // Ambil faskes yang sudah di-seed
        $faskes = DB::table('fasilitas_kesehatans')->first();

        if (!$faskes) return;

        $data = [
            [
                'user_id'                  => $azizah?->id,
                'fasilitas_kesehatan_id'   => $faskes->id,
                'nik'                      => '2171014504980001',
                'nama_lengkap'             => 'Azizah Rahmawati',
                'tempat_lahir'             => 'Batam',
                'tanggal_lahir'            => '1998-04-15',
                'jenis_fasilitas_kesehatan'=> 'Klinik',
                'golongan_darah'           => 'A',
                'pendidikan'               => 'S1',
                'pekerjaan'                => 'Ibu Rumah Tangga',
                'agama'                    => 'Islam',
                'alamat'                   => 'Jl. Permata Raya No. 12, Batu Aji, Batam',
                'nomor_wa'                 => '081234567890',
                'nomor_jkn'                => '0001234567890',
                'nama_puskesmas'           => 'Puskesmas Batu Aji',
                'created_at'               => now(),
                'updated_at'               => now(),
            ],
            [
                'user_id'                  => $dian?->id,
                'fasilitas_kesehatan_id'   => $faskes->id,
                'nik'                      => '2171011205950002',
                'nama_lengkap'             => 'Dian Safitri',
                'tempat_lahir'             => 'Tanjungpinang',
                'tanggal_lahir'            => '1995-05-12',
                'jenis_fasilitas_kesehatan'=> 'Klinik',
                'golongan_darah'           => 'O',
                'pendidikan'               => 'SMA',
                'pekerjaan'                => 'Ibu Rumah Tangga',
                'agama'                    => 'Islam',
                'alamat'                   => 'Jl. Batuaji Baru No. 7, Batu Aji, Batam',
                'nomor_wa'                 => '082198765432',
                'nomor_jkn'                => '0009876543210',
                'nama_puskesmas'           => 'Puskesmas Batu Aji',
                'created_at'               => now(),
                'updated_at'               => now(),
            ],
        ];

        DB::table('profil_ibus')->insert($data);
    }
}
