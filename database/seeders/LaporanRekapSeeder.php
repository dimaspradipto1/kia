<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\FasilitasKesehatan;
use App\Models\WilayaDinkes;
use App\Models\User;
use Carbon\Carbon;

class LaporanRekapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Get or Create Wilayah
        $wilayah = WilayaDinkes::first();
        if (!$wilayah) {
            $wilayah = WilayaDinkes::create([
                'kode_wilayah' => 'WIL-DINKES-BGR',
                'nama' => 'Dinas Kesehatan Kota Bogor',
                'tipe' => 'Kota'
            ]);
        }

        // 2. Get or Create Faskes
        $faskes = FasilitasKesehatan::first();
        if (!$faskes) {
            $faskes = FasilitasKesehatan::create([
                'nama_faskes' => 'Klinik Intan Permata',
                'jenis' => 'KLINIK',
                'alamat' => 'Jl. Permata Raya No. 12, Batu Aji',
                'kecamatan' => 'Batu Aji',
                'kab_kota' => 'Batam',
                'provinsi' => 'Kepulauan Riau',
                'telepon' => '0778-123456',
                'jam_operasional' => '24 Jam',
                'is_active' => true,
                'wilayah_id' => $wilayah->id
            ]);
        } else {
            // Ensure wilayah is set
            $faskes->update(['wilayah_id' => $wilayah->id]);
        }

        // 3. Get clinical roles / Nakes User
        $nakes = User::where('email', 'nakes@gmail.com')->first();
        $nakesId = $nakes ? $nakes->id : 3;

        // 4. Clean old seed data if necessary
        DB::table('persalinans')->whereYear('tanggal_lahir', 2026)->whereMonth('tanggal_lahir', 5)->delete();
        DB::table('tumbuh_kembangs')->whereYear('tanggal_ukur', 2026)->whereMonth('tanggal_ukur', 5)->delete();
        DB::table('imunisasi_anaks')->whereYear('tanggal_pemberian', 2026)->whereMonth('tanggal_pemberian', 5)->delete();
        DB::table('kunjungan_ancs')->whereYear('tanggal_kunjungan', 2026)->whereMonth('tanggal_kunjungan', 5)->delete();
        DB::table('pencatatan_ttds')->whereYear('tanggal', 2026)->whereMonth('tanggal', 5)->delete();

        // 5. Generate high-fidelity patient profiles, Buku KIA books, and Child profiles
        $bukuKiaIds = [];
        $profilAnakIds = [];

        // Check if we need to seed
        $existBooks = DB::table('buku_kias')->get();
        if (count($existBooks) < 20) {
            for ($i = 1; $i <= 20; $i++) {
                $userId = User::create([
                    'name' => "Ibu Hamil Real {$i}",
                    'email' => "ibu.real.{$i}@gmail.com",
                    'password' => bcrypt('password'),
                    'roles_id' => 4, // Ibu Hamil
                    'is_active' => true
                ])->id;

                $ibuId = DB::table('profil_ibus')->insertGetId([
                    'user_id' => $userId,
                    'fasilitas_kesehatan_id' => $faskes->id,
                    'nik' => '217101' . rand(1000000000, 9999999999),
                    'nama_lengkap' => "Ibu Hamil Real {$i}",
                    'tempat_lahir' => 'Batam',
                    'tanggal_lahir' => '1995-04-15',
                    'jenis_fasilitas_kesehatan' => 'KLINIK',
                    'golongan_darah' => 'O',
                    'pendidikan' => 'SMA',
                    'pekerjaan' => 'Ibu Rumah Tangga',
                    'agama' => 'Islam',
                    'alamat' => "Jl. Batu Aji Indah No. {$i}, Batam",
                    'nomor_wa' => '0812' . rand(10000000, 99999999),
                    'nomor_jkn' => '000' . rand(1000000000, 9999999999),
                    'nama_puskesmas' => 'Puskesmas Batu Aji',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $bukuId = DB::table('buku_kias')->insertGetId([
                    'profil_ibu_id' => $ibuId,
                    'fasilitas_kesehatan_id' => $faskes->id,
                    'no_reg_kohort_ibu' => "KOHORT-IBU-REAL-{$i}",
                    'no_reg_kohort_bayi' => "KOHORT-BAYI-REAL-{$i}",
                    'no_reg_kohort_balita' => "KOHORT-BALITA-REAL-{$i}",
                    'kehamilan_ke' => '1',
                    'jumlah_anak_hidup' => '0',
                    'riwayat_keguguran' => '0',
                    'riwayat_penyakit' => 'Tidak Ada',
                    'no_catatan_medik_rs' => 'RM-REAL-' . rand(1000, 9999),
                    'qr_code' => "QR-BK-REAL-{$i}",
                    'status' => 'Aktif',
                    'diterbitkan_pada' => '2026-01-10',
                    'diterbitkan_oleh' => 'Bidan Siti',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $anakId = DB::table('profil_anaks')->insertGetId([
                    'buku_kia_id' => $bukuId,
                    'nama_lengkap' => "Anak Real {$i}",
                    'jenis_kelamin' => ($i % 2 == 0) ? 'Laki-laki' : 'Perempuan',
                    'anak_ke' => '1',
                    'tempat_lahir' => 'Batam',
                    'tanggal_lahir' => '2025-05-15',
                    'golongan_darah' => 'O',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $bukuKiaIds[] = $bukuId;
                $profilAnakIds[] = $anakId;
            }
        } else {
            $bukuKiaIds = $existBooks->pluck('id')->toArray();
            $profilAnakIds = DB::table('profil_anaks')->pluck('id')->toArray();
            
            // If profil_anaks is empty, seed them for the existing books
            if (empty($profilAnakIds)) {
                foreach ($bukuKiaIds as $index => $bukuId) {
                    $profilAnakIds[] = DB::table('profil_anaks')->insertGetId([
                        'buku_kia_id' => $bukuId,
                        'nama_lengkap' => "Anak Real {$index}",
                        'jenis_kelamin' => ($index % 2 == 0) ? 'Laki-laki' : 'Perempuan',
                        'anak_ke' => '1',
                        'tempat_lahir' => 'Batam',
                        'tanggal_lahir' => '2025-05-15',
                        'golongan_darah' => 'O',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // 6. Seed 45 Real Kunjungan ANC for Mei 2026
        // K1: 22, K4: 15, K6: 8
        $ancCounts = [
            1 => 22, // K1
            4 => 15, // K4
            6 => 8   // K6
        ];

        foreach ($ancCounts as $kunjunganKe => $count) {
            for ($k = 0; $k < $count; $k++) {
                $bukuKiaId = $bukuKiaIds[array_rand($bukuKiaIds)];
                $day = rand(1, 28);
                DB::table('kunjungan_ancs')->insert([
                    'buku_kia_id' => $bukuKiaId,
                    'fasilitas_kesehatan_id' => $faskes->id,
                    'trimester' => ($kunjunganKe == 1) ? 1 : (($kunjunganKe == 4) ? 2 : 3),
                    'kunjungan_ke' => $kunjunganKe,
                    'tanggal_kunjungan' => "2026-05-{$day}",
                    'berat_badan' => 50.0 + rand(1, 15),
                    'tekanan_darah_sistolik' => rand(110, 130),
                    'tekanan_darah_diastolik' => rand(70, 85),
                    'tinggi_fundus_cm' => ($kunjunganKe > 1) ? rand(15, 30) : null,
                    'lila_cm' => 24.0 + rand(0, 3),
                    'denyut_jantung_janin' => ($kunjunganKe > 1) ? rand(135, 150) . ' bpm' : 'Negatif / Belum terdengar',
                    'letak_janin' => ($kunjunganKe > 1) ? 'Kepala Bawah' : 'Belum Teraba',
                    'status_tt' => 'T' . rand(1, 3),
                    'usg_dilakukan' => 'Ya',
                    'hasil_usg' => 'Normal, Janin Hidup',
                    'skrining_jiwa' => 'Sehat / Normal',
                    'catatan' => 'Pemeriksaan rutin berkala, kondisi ibu dan janin terpantau sehat.',
                    'nakes_id' => $nakesId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 7. Seed 30 Real Imunisasi Anak for Mei 2026
        // Antigen types: BCG, Polio 1, DPT-HB-Hib 1, Campak-Rubela
        $antigenList = ['BCG', 'Polio 1', 'DPT-HB-Hib 1', 'Campak-Rubela'];
        foreach ($antigenList as $antigen) {
            $count = rand(5, 12);
            for ($im = 0; $im < $count; $im++) {
                $profilAnakId = $profilAnakIds[array_rand($profilAnakIds)];
                $day = rand(1, 28);
                DB::table('imunisasi_anaks')->insert([
                    'profil_anak_id' => $profilAnakId,
                    'fasilitas_kesehatan_id' => $faskes->id,
                    'nakes_id' => $nakesId,
                    'jenis_imunisasi' => $antigen,
                    'dosis_ke' => 1,
                    'tanggal_pemberian' => "2026-05-{$day}",
                    'batch_vaksin' => 'B-' . rand(1000, 9999),
                    'efek_samping' => 'Demam Ringan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 8. Seed 120 Real Tumbuh Kembang (Balita Ditimbang) for Mei 2026
        // We will seed 120 weight records:
        // Gizi Baik: 102, Gizi Kurang: 12, Gizi Buruk: 3, Overweight: 3
        // Stunting: 5, Wasting: 3
        $giziDistribution = [
            'gizi baik' => 102,
            'gizi kurang' => 12,
            'gizi buruk' => 3,
            'overweight' => 3
        ];

        $stuntingLeft = 5;
        $wastingLeft = 3;

        foreach ($giziDistribution as $status => $count) {
            for ($tk = 0; $tk < $count; $tk++) {
                $profilAnakId = $profilAnakIds[array_rand($profilAnakIds)];
                $day = rand(1, 28);

                $isStunting = 'normal';
                if ($stuntingLeft > 0 && ($status == 'gizi kurang' || $status == 'gizi buruk')) {
                    $isStunting = 'stunting';
                    $stuntingLeft--;
                }

                $isWasting = 'normal';
                if ($wastingLeft > 0 && ($status == 'gizi kurang' || $status == 'gizi buruk')) {
                    $isWasting = 'wasting';
                    $wastingLeft--;
                }

                DB::table('tumbuh_kembangs')->insert([
                    'profil_anak_id' => $profilAnakId,
                    'fasilitas_kesehatan_id' => $faskes->id,
                    'nakes_id' => $nakesId,
                    'tanggal_ukur' => "2026-05-{$day}",
                    'usia_bulan' => 12,
                    'berat_badan' => 8.0 + rand(1, 10),
                    'tinggi_badan' => 70.0 + rand(1, 25),
                    'lingkar_kepala' => 45.0,
                    'lila_cm' => 14.5,
                    'status_gizi_bb_u' => $status,
                    'status_gizi_tb_u' => ($isStunting == 'stunting') ? 'sangat pendek' : 'normal',
                    'status_gizi_bb_tb' => $isWasting,
                    'status_stunting' => $isStunting,
                    'catatan' => 'Tumbuh kembang anak terpantau secara rutin bulanan.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 9. Seed 48 TTD logs for Mei 2026
        // target: 50, mendapat: 48, patuh: 42
        for ($t = 0; $t < 48; $t++) {
            $bukuKiaId = $bukuKiaIds[array_rand($bukuKiaIds)];
            $day = rand(1, 28);
            $diminum = ($t < 42) ? 'Ya' : 'Tidak';

            DB::table('pencatatan_ttds')->insert([
                'buku_kia_id' => $bukuKiaId,
                'tanggal' => "2026-05-{$day}",
                'diminum' => $diminum,
                'catatan' => 'Dianjurkan diminum malam hari sebelum tidur.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 10. Seed 2 Real Persalinan for Mei 2026 (1 infant death to trigger death counts!)
        // Persalinan 1: Normal, Bayi & Ibu Sehat
        $bkNormal = $bukuKiaIds[0];
        DB::table('persalinans')->insert([
            'buku_kia_id' => $bkNormal,
            'fasilitas_kesehatan_id' => $faskes->id,
            'tanggal_lahir' => '2026-05-10',
            'jam_lahir' => '08:30',
            'jenis_persalinan' => 'Normal Spontan',
            'penolong' => 'Bidan',
            'berat_bayi_kg' => 3.1,
            'panjang_bayi_cm' => 49.0,
            'apgar_score_1' => 8,
            'apgar_score_5' => 10,
            'kondisi_ibu' => 'Sehat',
            'kondisi_bayi' => 'Sehat',
            'komplikasi' => 'Tidak Ada',
            'nakes_id' => $nakesId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Persalinan 2: Komplikasi Asfiksia, Bayi Meninggal (untuk memicu indikator kematian bayi riil!)
        $bkKomplikasi = $bukuKiaIds[1];
        DB::table('persalinans')->insert([
            'buku_kia_id' => $bkKomplikasi,
            'fasilitas_kesehatan_id' => $faskes->id,
            'tanggal_lahir' => '2026-05-15',
            'jam_lahir' => '14:20',
            'jenis_persalinan' => 'Tindakan Vakum',
            'penolong' => 'Dokter SpOG',
            'berat_bayi_kg' => 2.8,
            'panjang_bayi_cm' => 47.0,
            'apgar_score_1' => 3,
            'apgar_score_5' => 5,
            'kondisi_ibu' => 'Sehat',
            'kondisi_bayi' => 'Meninggal',
            'komplikasi' => 'Asfiksia Neonatorum Berat',
            'nakes_id' => $nakesId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 11. Run the dynamic real-time recalculator to aggregate these new records immediately!
        $laporanController = new \App\Http\Controllers\LaporanController();
        $reflector = new \ReflectionMethod($laporanController, 'recalculateRealData');
        $reflector->setAccessible(true);
        $reflector->invoke($laporanController, 2026, 5);
    }
}
