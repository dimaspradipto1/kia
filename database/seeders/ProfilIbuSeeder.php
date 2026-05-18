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
        $nakes   = User::where('email', 'nakes@gmail.com')->first();

        // Ambil faskes yang sudah di-seed
        $faskes = DB::table('fasilitas_kesehatans')->first();

        if (!$faskes) return;

        $ibu1 = [
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
        ];

        $ibu2 = [
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
        ];

        $ibuId1 = DB::table('profil_ibus')->insertGetId($ibu1);
        $ibuId2 = DB::table('profil_ibus')->insertGetId($ibu2);

        // Seed Buku KIA
        $bk1 = DB::table('buku_kias')->insertGetId([
            'profil_ibu_id' => $ibuId1,
            'fasilitas_kesehatan_id' => $faskes->id,
            'no_reg_kohort_ibu' => 'KOHORT-IBU-001',
            'no_reg_kohort_bayi' => 'KOHORT-BAYI-001',
            'no_reg_kohort_balita' => 'KOHORT-BALITA-001',
            'kehamilan_ke' => '1',
            'jumlah_anak_hidup' => '0',
            'riwayat_keguguran' => '0',
            'riwayat_penyakit' => 'Tidak Ada',
            'no_catatan_medik_rs' => 'RM-9921',
            'qr_code' => 'QR-BK-001',
            'status' => 'Aktif',
            'diterbitkan_pada' => '2026-01-10',
            'diterbitkan_oleh' => 'Bidan Siti',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $bk2 = DB::table('buku_kias')->insertGetId([
            'profil_ibu_id' => $ibuId2,
            'fasilitas_kesehatan_id' => $faskes->id,
            'no_reg_kohort_ibu' => 'KOHORT-IBU-002',
            'no_reg_kohort_bayi' => 'KOHORT-BAYI-002',
            'no_reg_kohort_balita' => 'KOHORT-BALITA-002',
            'kehamilan_ke' => '2',
            'jumlah_anak_hidup' => '1',
            'riwayat_keguguran' => '0',
            'riwayat_penyakit' => 'Tidak Ada',
            'no_catatan_medik_rs' => 'RM-1023',
            'qr_code' => 'QR-BK-002',
            'status' => 'Aktif',
            'diterbitkan_pada' => '2026-02-15',
            'diterbitkan_oleh' => 'Dr. Budi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed Kunjungan ANC
        $anc1 = DB::table('kunjungan_ancs')->insertGetId([
            'buku_kia_id' => $bk1,
            'fasilitas_kesehatan_id' => $faskes->id,
            'trimester' => 1,
            'kunjungan_ke' => 1,
            'tanggal_kunjungan' => '2026-01-15',
            'berat_badan' => 52.0,
            'tekanan_darah_sistolik' => 110,
            'tekanan_darah_diastolik' => 70,
            'tinggi_fundus_cm' => null,
            'lila_cm' => 24.0,
            'denyut_jantung_janin' => 'Negatif / Belum terdengar',
            'letak_janin' => 'Belum Teraba',
            'status_tt' => 'T1',
            'usg_dilakukan' => 'Ya',
            'hasil_usg' => 'Normal, Janin Tunggal Hidup',
            'skrining_jiwa' => 'Sehat / Normal',
            'catatan' => 'Kondisi awal kehamilan ibu baik, diberikan vitamin asam folat dan zat besi.',
            'nakes_id' => $nakes?->id ?? 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $anc2 = DB::table('kunjungan_ancs')->insertGetId([
            'buku_kia_id' => $bk1,
            'fasilitas_kesehatan_id' => $faskes->id,
            'trimester' => 2,
            'kunjungan_ke' => 2,
            'tanggal_kunjungan' => '2026-03-20',
            'berat_badan' => 56.5,
            'tekanan_darah_sistolik' => 120,
            'tekanan_darah_diastolik' => 80,
            'tinggi_fundus_cm' => 18.0,
            'lila_cm' => 24.5,
            'denyut_jantung_janin' => '142 bpm',
            'letak_janin' => 'Kepala Bawah (Presentasi Kepala)',
            'status_tt' => 'T2',
            'usg_dilakukan' => 'Ya',
            'hasil_usg' => 'Normal, Posisi Kepala Baik',
            'skrining_jiwa' => 'Sehat / Normal',
            'catatan' => 'Perkembangan janin sangat baik. Ibu dianjurkan konsumsi makanan tinggi protein dan zat besi rutin.',
            'nakes_id' => $nakes?->id ?? 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed Hasil Lab Ibu
        DB::table('hasil_lab_ibus')->insert([
            [
                'kunjungan_anc_id' => $anc1,
                'jenis_pemeriksaan' => 'Hemoglobin (Hb)',
                'hasil' => '11.5',
                'satuan' => 'g/dl',
                'nilai_normal' => '11.0 - 16.0',
                'tanggal_periksa' => '2026-01-15',
                'nakes_id' => $nakes?->id ?? 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kunjungan_anc_id' => $anc1,
                'jenis_pemeriksaan' => 'Protein Urine',
                'hasil' => 'Negatif',
                'satuan' => '-',
                'nilai_normal' => 'Negatif',
                'tanggal_periksa' => '2026-01-15',
                'nakes_id' => $nakes?->id ?? 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kunjungan_anc_id' => $anc2,
                'jenis_pemeriksaan' => 'Hemoglobin (Hb)',
                'hasil' => '10.8',
                'satuan' => 'g/dl',
                'nilai_normal' => '11.0 - 16.0',
                'tanggal_periksa' => '2026-03-20',
                'nakes_id' => $nakes?->id ?? 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kunjungan_anc_id' => $anc2,
                'jenis_pemeriksaan' => 'Protein Urine',
                'hasil' => '+',
                'satuan' => '-',
                'nilai_normal' => 'Negatif',
                'tanggal_periksa' => '2026-03-20',
                'nakes_id' => $nakes?->id ?? 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed Pemantauan Nifas
        DB::table('pemantauan_nifas')->insert([
            'buku_kia_id' => $bk2,
            'nakes_id' => $nakes?->id ?? 3,
            'tanggal' => '2026-03-10',
            'hari_ke' => 'KF 1 (6 Jam - 3 Hari)',
            'demam' => 'Tidak',
            'pendarahan' => 'Tidak',
            'nyeri_ulu_hati' => 'Tidak',
            'pandangan_kabur' => 'Tidak',
            'keluar_cairan_berbau' => 'Tidak',
            'payudara_bengkak' => 'Tidak',
            'gangguan_jiwa' => 'Tidak',
            'gangguan_bak' => 'Tidak',
            'catatan' => 'Kondisi ibu nifas stabil. Kontraksi uterus baik, lokia rubra normal. Diberikan edukasi menyusui dini.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed KB Pasca Salin
        DB::table('kb_pasca_salins')->insert([
            'buku_kia_id' => $bk2,
            'nakes_id' => $nakes?->id ?? 3,
            'fasilitas_kesehatan_id' => $faskes->id,
            'metode_kb' => 'Suntik 3 Bulan',
            'tanggal_mulai' => '2026-03-25',
            'catatan' => 'Ibu memilih KB Suntik 3 Bulan pasca persalinan untuk penjarangan kehamilan.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
