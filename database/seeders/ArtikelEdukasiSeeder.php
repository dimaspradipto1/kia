<?php

namespace Database\Seeders;

use App\Models\ArtikelEdukasi;
use App\Models\KategoriArtikel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArtikelEdukasiSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori sudah ada
        $this->call(KategoriArtikelSeeder::class);

        $adminId = User::first()?->id ?? 1;

        $articles = [
            [
                'kategori_slug' => 'kehamilan',
                'judul'         => '5 Tips Menjaga Nutrisi Selama Trimester Pertama',
                'penulis'       => 'Dr. Sari Wati',
                'terbit'        => '2026-04-26',
                'gambar'        => 'mother_portrait_1779872791574.png',
                'isi'           => '<p>Trimester pertama kehamilan adalah fase yang sangat krusial bagi tumbuh kembang organ vital janin Anda. Pada masa awal ini, menjaga asupan nutrisi yang tepat bukan hanya menunjang stamina fisik sang Ibu, tetapi juga menjadi fondasi tumbuh kembang anak secara keseluruhan.</p>
<h5 class="fw-bold mt-4 mb-2">Nutrisi Utama yang Dibutuhkan:</h5>
<ul class="mb-3">
    <li class="mb-2"><strong>Asam Folat:</strong> Sangat penting untuk pembentukan sistem saraf bayi dan mencegah cacat tabung saraf. Direkomendasikan minimal 400 mcg setiap hari.</li>
    <li class="mb-2"><strong>Zat Besi:</strong> Diperlukan untuk memproduksi hemoglobin ekstra untuk mensuplai oksigen ke janin dan mencegah anemia pada Ibu.</li>
    <li class="mb-2"><strong>Kalsium &amp; Vitamin D:</strong> Untuk perkembangan awal tulang dan gigi buah hati Anda.</li>
</ul>
<p>Upayakan makan dalam porsi kecil namun sering untuk meredakan mual-mual (morning sickness) yang umum terjadi pada masa trimester pertama ini.</p>',
            ],
            [
                'kategori_slug' => 'imunisasi',
                'judul'         => 'Pentingnya Imunisasi Dasar Lengkap Bagi Bayi',
                'penulis'       => 'Dr. Sari Wati',
                'terbit'        => '2026-04-20',
                'gambar'        => 'nurse_doctor1_1779872814462.png',
                'isi'           => '<p>Imunisasi adalah langkah preventif paling efektif untuk melindungi bayi dari berbagai penyakit menular berbahaya. Pemerintah Indonesia mewajibkan imunisasi dasar lengkap bagi seluruh bayi sebelum usia 1 tahun.</p>
<h5 class="fw-bold mt-4 mb-2">Jadwal Imunisasi Wajib:</h5>
<ul class="mb-3">
    <li class="mb-2"><strong>Hepatitis B:</strong> Diberikan segera setelah bayi lahir (kurang dari 24 jam).</li>
    <li class="mb-2"><strong>BCG &amp; Polio 1:</strong> Diberikan pada usia 1 bulan untuk mencegah TBC dan lumpuh layu.</li>
    <li class="mb-2"><strong>DPT-HB-Hib &amp; Polio:</strong> Diberikan pada usia 2, 3, dan 4 bulan.</li>
    <li class="mb-2"><strong>Campak/MR:</strong> Diberikan pada usia 9 bulan.</li>
</ul>
<p>Jangan ragu membawa bayi Anda ke posyandu atau faskes terdekat untuk mendapatkan imunisasi sesuai jadwal.</p>',
            ],
            [
                'kategori_slug' => 'parenting',
                'judul'         => 'Membangun Ikatan Batin Sejak Anak dalam Kandungan',
                'penulis'       => 'Rina Mulyani',
                'terbit'        => '2026-04-14',
                'gambar'        => 'mother_baby_hero.png',
                'isi'           => '<p>Ikatan batin (bonding) antara orang tua dan anak tidak dimulai saat bayi lahir ke dunia, melainkan sejak ia masih berupa janin di dalam kandungan. Janin mulai bisa mendengar suara dari luar kandungan sejak usia kehamilan memasuki 20 minggu.</p>
<h5 class="fw-bold mt-4 mb-2">Cara Sederhana Memulai Bonding:</h5>
<ul class="mb-3">
    <li class="mb-2"><strong>Mengajak Mengobrol:</strong> Suara Ibu dan Ayah adalah frekuensi yang paling menenangkan bagi janin.</li>
    <li class="mb-2"><strong>Mengelus Perut:</strong> Sentuhan lembut di perut Ibu merangsang respons janin.</li>
    <li class="mb-2"><strong>Mendengarkan Musik Lembut:</strong> Musik klasik dipercaya membantu menenangkan denyut jantung janin.</li>
</ul>
<p>Fase bonding prenatal ini membantu mempermudah adaptasi bayi saat ia lahir nanti.</p>',
            ],
            [
                'kategori_slug' => 'gizi-nutrisi',
                'judul'         => 'Panduan MPASI Pertama untuk Bayi Usia 6 Bulan',
                'penulis'       => 'Dr. Sari Wati',
                'terbit'        => '2026-04-08',
                'gambar'        => 'doctor_obgyn_1779872831013.png',
                'isi'           => '<p>Setelah melewati periode ASI eksklusif selama 6 bulan, bayi membutuhkan nutrisi tambahan dari Makanan Pendamping ASI (MPASI) karena kebutuhan energinya meningkat.</p>
<h5 class="fw-bold mt-4 mb-2">Prinsip Pemberian MPASI Pertama:</h5>
<ul class="mb-3">
    <li class="mb-2"><strong>Tekstur Bubur Saring:</strong> Mulailah dengan tekstur lumat/bubur saring yang halus agar bayi tidak tersedak.</li>
    <li class="mb-2"><strong>Gizi Seimbang:</strong> MPASI harus mengandung karbohidrat, protein hewani, lemak tambahan, dan sedikit sayuran.</li>
    <li class="mb-2"><strong>Porsi Bertahap:</strong> Mulai dengan porsi kecil, 2-3 sendok makan, 2 kali sehari.</li>
</ul>
<p>Hindari menambahkan garam dan gula berlebihan pada MPASI bayi di bawah usia 1 tahun.</p>',
            ],
            [
                'kategori_slug' => 'parenting',
                'judul'         => 'Menghadapi Baby Blues: Panduan untuk Ibu Baru',
                'penulis'       => 'Rina Mulyani',
                'terbit'        => '2026-04-02',
                'gambar'        => 'mother_portrait_1779872791574.png',
                'isi'           => '<p>Perasaan sedih, cemas, sensitif, dan mudah menangis yang dialami ibu baru setelah melahirkan sering dikenal dengan istilah <em>Baby Blues Syndrome</em>. Kondisi ini dipicu oleh perubahan hormon pasca melahirkan serta kelelahan fisik ekstrim.</p>
<h5 class="fw-bold mt-4 mb-2">Tips Mengatasi Baby Blues:</h5>
<ul class="mb-3">
    <li class="mb-2"><strong>Komunikasi dengan Suami:</strong> Jangan ragu membagi tugas merawat bayi.</li>
    <li class="mb-2"><strong>Istirahat yang Cukup:</strong> Tidur saat bayi Anda sedang tidur.</li>
    <li class="mb-2"><strong>Cari Support System:</strong> Ceritakan perasaan Anda pada keluarga dekat atau sahabat.</li>
</ul>
<p>Jika kondisi sedih berlanjut lebih dari 2 minggu, segera berkonsultasi dengan bidan atau dokter.</p>',
            ],
            [
                'kategori_slug' => 'tumbuh-kembang',
                'judul'         => 'Cara Tepat Membaca Grafik Tumbuh Kembang KMS',
                'penulis'       => 'Budi Santoso',
                'terbit'        => '2026-03-28',
                'gambar'        => 'pediatrician_accent.png',
                'isi'           => '<p>Kartu Menuju Sehat (KMS) adalah alat ukur yang sangat krusial dalam memantau tren pertumbuhan balita Anda dari bulan ke bulan.</p>
<h5 class="fw-bold mt-4 mb-2">Memahami Kurva Pertumbuhan:</h5>
<ul class="mb-3">
    <li class="mb-2"><strong>Pita Hijau (Tengah):</strong> Status pertumbuhan normal dan ideal.</li>
    <li class="mb-2"><strong>Pita Kuning (Bawah):</strong> Peringatan bahwa berat badan anak kurang.</li>
    <li class="mb-2"><strong>Pita Kuning (Atas):</strong> Risiko berat badan berlebih (overweight).</li>
    <li class="mb-2"><strong>Tren Kurva Naik:</strong> Jika garis sejajar atau naik, anak tumbuh dengan baik.</li>
</ul>
<p>Lakukan penimbangan balita Anda setiap bulan di posyandu terdekat.</p>',
            ],
        ];

        foreach ($articles as $article) {
            $kat = KategoriArtikel::where('slug', $article['kategori_slug'])->first();
            if (!$kat) {
                // Coba cari dengan like
                $kat = KategoriArtikel::all()->first();
            }

            $slug = ArtikelEdukasi::generateUniqueSlugPublic($article['judul']);

            ArtikelEdukasi::firstOrCreate(
                ['slug' => $slug],
                [
                    'kategori_artikel_id' => $kat?->id,
                    'user_id'             => $adminId,
                    'judul'               => $article['judul'],
                    'slug'                => $slug,
                    'isi'                 => $article['isi'],
                    'gambar'              => $article['gambar'],   // nama file homepage (legacy)
                    'penulis'             => $article['penulis'],
                    'status'              => 'published',
                    'diterbitkan_pada'    => $article['terbit'],
                ]
            );
        }
    }
}
