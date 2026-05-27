<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\About;
use App\Models\Faq;
use App\Models\Contact;
use App\Models\Team;
use App\Models\VisiMisi;
use App\Models\Layanan;
use App\Models\LayananIntro;

class HomepageController extends Controller
{
    public function index()
    {
        $faqs = Faq::query()->where('is_active', true)->get();
        $visiMisi = VisiMisi::where('is_active', true)->first();
        return view('layouts.homepage.index', compact('faqs', 'visiMisi'));
    }

    public function about()
    {
        $about = About::where('is_active', true)
            ->with(['defaultImage', 'images'])
            ->first();
        $teams = Team::where('is_active', true)
            ->orderBy('urutan')
            ->get();
        return view('layouts.homepage.about', compact('about', 'teams'));
    }

    public function contact()
    {
        // Ambil data kontak aktif pertama dari database
        $contact = Contact::where('is_active', true)->first();
        return view('layouts.homepage.contact', compact('contact'));
    }

    private function getMockArticles()
    {
        return collect([
            [
                'id' => 1,
                'judul' => '5 Tips Menjaga Nutrisi Selama Trimester Pertama',
                'slug' => '5-tips-menjaga-nutrisi-selama-trimester-pertama',
                'kategori' => 'Kehamilan',
                'kategori_slug' => 'kehamilan',
                'snippet' => 'Pelajari asupan makanan penting yang dibutuhkan janin Anda di awal masa kehamilan.',
                'gambar' => 'mother_portrait_1779872791574.png',
                'penulis' => 'Dr. Sari Wati',
                'diterbitkan_pada' => '26 Apr 2026',
                'content' => '
                    <p>Trimester pertama kehamilan adalah fase yang sangat krusial bagi tumbuh kembang organ vital janin Anda. Pada masa awal ini, menjaga asupan nutrisi yang tepat bukan hanya menunjang stamina fisik sang Ibu, tetapi juga menjadi fondasi tumbuh kembang anak secara keseluruhan.</p>
                    <h5 class="fw-bold mt-4 mb-2">Nutrisi Utama yang Dibutuhkan:</h5>
                    <ul class="mb-3">
                        <li class="mb-2"><strong>Asam Folat:</strong> Sangat penting untuk pembentukan sistem saraf bayi dan mencegah cacat tabung saraf. Direkomendasikan minimal 400 mcg setiap hari yang bisa didapat dari sayuran hijau, buah jeruk, atau suplemen medis.</li>
                        <li class="mb-2"><strong>Zat Besi:</strong> Diperlukan untuk memproduksi hemoglobin ekstra untuk mensuplai oksigen ke janin dan mencegah anemia pada Ibu.</li>
                        <li class="mb-2"><strong>Kalsium & Vitamin D:</strong> Untuk perkembangan awal tulang dan gigi buah hati Anda.</li>
                    </ul>
                    <p>Upayakan makan dalam porsi kecil namun sering untuk meredakan mual-mual (morning sickness) yang umum terjadi pada masa trimester pertama ini.</p>
                '
            ],
            [
                'id' => 2,
                'judul' => 'Pentingnya Imunisasi Dasar Lengkap Bagi Bayi',
                'slug' => 'pentingnya-imunisasi-dasar-lengkap-bagi-bayi',
                'kategori' => 'Imunisasi',
                'kategori_slug' => 'imunisasi',
                'snippet' => 'Kenali jenis-jenis imunisasi yang wajib diberikan untuk melindungi buah hati dari penyakit berbahaya.',
                'gambar' => 'nurse_doctor1_1779872814462.png',
                'penulis' => 'Dr. Sari Wati',
                'diterbitkan_pada' => '20 Apr 2026',
                'content' => '
                    <p>Imunisasi adalah langkah preventif paling efektif untuk melindungi bayi dari berbagai penyakit menular berbahaya yang dapat menyebabkan kecacatan atau bahkan kematian. Pemerintah Indonesia mewajibkan imunisasi dasar lengkap bagi seluruh bayi sebelum usia 1 tahun.</p>
                    <h5 class="fw-bold mt-4 mb-2">Jadwal Imunisasi Wajib:</h5>
                    <ul class="mb-3">
                        <li class="mb-2"><strong>Hepatitis B:</strong> Diberikan segera setelah bayi lahir (kurang dari 24 jam) untuk mencegah infeksi hati kronis.</li>
                        <li class="mb-2"><strong>BCG & Polio 1:</strong> Diberikan pada usia 1 bulan untuk mencegah penyakit TBC dan lumpuh layu.</li>
                        <li class="mb-2"><strong>DPT-HB-Hib & Polio:</strong> Diberikan berturut-turut pada usia 2, 3, dan 4 bulan untuk melindung anak dari penyakit Difteri, Pertusis, Tetanus, Hepatitis B, serta Meningitis.</li>
                        <li class="mb-2"><strong>Campak/MR:</strong> Diberikan pada usia 9 bulan untuk mencegah campak dan rubella.</li>
                    </ul>
                    <p>Jangan ragu membawa bayi Anda ke posyandu atau faskes terdekat untuk mendapatkan imunisasi sesuai jadwal.</p>
                '
            ],
            [
                'id' => 3,
                'judul' => 'Membangun Ikatan Batin Sejak Anak dalam Kandungan',
                'slug' => 'membangun-ikatan-batin-sejak-anak-dalam-kandungan',
                'kategori' => 'Parenting',
                'kategori_slug' => 'parenting',
                'snippet' => 'Cara-cara sederhana namun efektif untuk mulai berkomunikasi dengan calon buah hati Anda.',
                'gambar' => 'mother_baby_hero.png',
                'penulis' => 'Rina Mulyani',
                'diterbitkan_pada' => '14 Apr 2026',
                'content' => '
                    <p>Ikatan batin (bonding) antara orang tua dan anak tidak dimulai saat bayi lahir ke dunia, melainkan sejak ia masih berupa janin di dalam kandungan. Janin mulai bisa mendengar suara dari luar kandungan sejak usia kehamilan memasuki 20 minggu.</p>
                    <h5 class="fw-bold mt-4 mb-2">Cara Sederhana Memulai Bonding:</h5>
                    <ul class="mb-3">
                        <li class="mb-2"><strong>Mengajak Mengobrol:</strong> Suara Ibu dan Ayah adalah frekuensi yang paling menenangkan bagi janin. Bicarakan aktivitas sehari-hari atau bacakan cerita dongeng.</li>
                        <li class="mb-2"><strong>Mengelus Perut:</strong> Sentuhan lembut di perut Ibu merangsang respons janin. Sering kali janin akan membalas dengan tendangan kecil di area yang dielus.</li>
                        <li class="mb-2"><strong>Mendengarkan Musik Lembut:</strong> Musik klasik atau instrumen yang tenang dipercaya membantu menenangkan denyut jantung janin dan merangsang perkembangan otaknya.</li>
                    </ul>
                    <p>Fase bonding prenatal ini membantu mempermudah adaptasi bayi saat ia lahir nanti karena sudah familiar dengan suara orang tuanya.</p>
                '
            ],
            [
                'id' => 4,
                'judul' => 'Panduan MPASI Pertama untuk Bayi Usia 6 Bulan',
                'slug' => 'panduan-mpasi-pertama-untuk-bayi-usia-6-bulan',
                'kategori' => 'Gizi & Nutrisi',
                'kategori_slug' => 'gizi',
                'snippet' => 'Tips memulai makanan pendamping ASI pertama yang sehat, aman, dan disukai sang buah hati.',
                'gambar' => 'doctor_obgyn_1779872831013.png',
                'penulis' => 'Dr. Sari Wati',
                'diterbitkan_pada' => '08 Apr 2026',
                'content' => '
                    <p>Setelah melewati periode ASI eksklusif selama 6 bulan, bayi membutuhkan nutrisi tambahan dari Makanan Pendamping ASI (MPASI) karena kebutuhan energinya meningkat dan tidak lagi tercukupi hanya dari ASI.</p>
                    <h5 class="fw-bold mt-4 mb-2">Prinsip Pemberian MPASI Pertama:</h5>
                    <ul class="mb-3">
                        <li class="mb-2"><strong>Tekstur Bubur Saring:</strong> Mulailah dengan tekstur makanan lumat/bubur saring yang halus agar bayi tidak tersedak.</li>
                        <li class="mb-2"><strong>Gizi Seimbang:</strong> MPASI harus mengandung karbohidrat (beras, kentang), protein hewani (ayam, telur, ikan), lemak tambahan (minyak kelapa, mentega), dan sedikit sayuran untuk perkenalan serat.</li>
                        <li class="mb-2"><strong>Porsi Bertahap:</strong> Mulai dengan porsi kecil, misalnya 2-3 sendok makan, sebanyak 2 kali sehari, lalu tingkatkan porsi dan frekuensinya secara bertahap seiring bertambahnya usia.</li>
                    </ul>
                    <p>Hindari menambahkan garam dan gula berlebihan pada MPASI bayi di bawah usia 1 tahun guna menjaga kesehatan ginjalnya.</p>
                '
            ],
            [
                'id' => 5,
                'judul' => 'Menghadapi Baby Blues: Panduan untuk Ibu Baru',
                'slug' => 'menghadapi-baby-blues-panduan-untuk-ibu-baru',
                'kategori' => 'Parenting',
                'kategori_slug' => 'parenting',
                'snippet' => 'Mengenali gejala baby blues dan bagaimana cara menghadapinya dengan dukungan keluarga tercinta.',
                'gambar' => 'mother_portrait_1779872791574.png',
                'penulis' => 'Rina Mulyani',
                'diterbitkan_pada' => '02 Apr 2026',
                'content' => '
                    <p>Perasaan sedih, cemas, sensitif, dan mudah menangis yang dialami ibu baru setelah melahirkan sering dikenal dengan istilah *Baby Blues Syndrome*. Kondisi ini dipicu oleh perubahan hormon pasca melahirkan serta kelelahan fisik ekstrim karena pola tidur yang terganggu.</p>
                    <h5 class="fw-bold mt-4 mb-2">Tips Mengatasi Baby Blues:</h5>
                    <ul class="mb-3">
                        <li class="mb-2"><strong>Komunikasi dengan Suami:</strong> Jangan ragu membagi tugas merawat bayi, seperti menyendawakan bayi setelah disusui atau mengganti popok di malam hari.</li>
                        <li class="mb-2"><strong>Istirahat yang Cukup:</strong> Usahakan tidur saat bayi Anda sedang tidur. Jangan memaksakan diri menyelesaikan pekerjaan rumah tangga sendirian.</li>
                        <li class="mb-2"><strong>Cari Support System:</strong> Ceritakan perasaan Anda pada keluarga dekat atau sahabat yang dipercaya untuk melepas kepenatan mental Anda.</li>
                    </ul>
                    <p>Jika kondisi sedih berlanjut lebih dari 2 minggu, segera berkonsultasi dengan bidan, dokter, atau psikolog terdekat.</p>
                '
            ],
            [
                'id' => 6,
                'judul' => 'Cara Tepat Membaca Grafik Tumbuh Kembang KMS',
                'slug' => 'cara-tepat-membaca-grafik-tumbuh-kembang-kms',
                'kategori' => 'Tumbuh Kembang',
                'kategori_slug' => 'tumbuh-kembang',
                'snippet' => 'Panduan praktis bagi ibu untuk memantau berat badan dan tinggi badan anak secara berkala menggunakan Kartu Menuju Sehat.',
                'gambar' => 'pediatrician_accent.png',
                'penulis' => 'Budi Santoso',
                'diterbitkan_pada' => '28 Mar 2026',
                'content' => '
                    <p>Kartu Menuju Sehat (KMS) adalah alat ukur yang sangat krusial dalam memantau tren pertumbuhan balita Anda dari bulan ke bulan. KMS membantu mendeteksi secara dini gangguan pertumbuhan anak seperti gizi kurang atau risiko stunting.</p>
                    <h5 class="fw-bold mt-4 mb-2">Memahami Kurva Pertumbuhan:</h5>
                    <ul class="mb-3">
                        <li class="mb-2"><strong>Pita Hijau (Tengah):</strong> Menunjukkan status pertumbuhan anak normal and ideal sesuai usianya.</li>
                        <li class="mb-2"><strong>Pita Kuning (Bawah):</strong> Menunjukkan peringatan bahwa berat badan anak kurang dan memerlukan perhatian nutrisi ekstra.</li>
                        <li class="mb-2"><strong>Pita Kuning (Atas):</strong> Menunjukkan risiko berat badan berlebih (overweight/obesitas).</li>
                        <li class="mb-2"><strong>Tren Kurva Naik:</strong> Jika garis pertumbuhan anak sejajar atau naik mengikuti kurva pertumbuhan, anak tumbuh dengan baik. Jika mendatar atau turun, segera konsultasikan ke posyandu/puskesmas.</li>
                    </ul>
                    <p>Lakukan penimbangan balita Anda setiap bulan di posyandu terdekat dan pastikan bidan mencatatkan hasilnya di KMS.</p>
                '
            ]
        ]);
    }

    public function artikel(Request $request)
    {
        $allArticles = $this->getMockArticles();

        $search = $request->get('search');
        $category = $request->get('category');

        // Filter articles
        $filtered = $allArticles;

        if ($search) {
            $filtered = $filtered->filter(function ($item) use ($search) {
                return stripos($item['judul'], $search) !== false || stripos($item['snippet'], $search) !== false;
            });
        }

        if ($category) {
            $filtered = $filtered->filter(function ($item) use ($category) {
                return $item['kategori_slug'] === $category;
            });
        }

        // Sort by newest first (by index, since mock data is already ordered newest-first)
        $filtered = $filtered->values();

        // Paginate manually (4 per page – change to 10 for production)
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pageItems = $filtered->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $articles = new LengthAwarePaginator(
            $pageItems,
            $filtered->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Get category counts
        $categories = [
            ['nama' => 'Semua Kategori', 'slug' => '', 'count' => $allArticles->count()],
            ['nama' => 'Kehamilan', 'slug' => 'kehamilan', 'count' => $allArticles->where('kategori_slug', 'kehamilan')->count()],
            ['nama' => 'Imunisasi', 'slug' => 'imunisasi', 'count' => $allArticles->where('kategori_slug', 'imunisasi')->count()],
            ['nama' => 'Parenting', 'slug' => 'parenting', 'count' => $allArticles->where('kategori_slug', 'parenting')->count()],
            ['nama' => 'Gizi & Nutrisi', 'slug' => 'gizi', 'count' => $allArticles->where('kategori_slug', 'gizi')->count()],
            ['nama' => 'Tumbuh Kembang', 'slug' => 'tumbuh-kembang', 'count' => $allArticles->where('kategori_slug', 'tumbuh-kembang')->count()],
        ];

        // Recent posts (always the first 3 from allArticles, newest first)
        $recentArticles = $allArticles->take(3);

        return view('layouts.homepage.artikel', compact('articles', 'categories', 'recentArticles', 'search', 'category'));
    }

    public function showArtikel($slug)
    {
        $allArticles = $this->getMockArticles();
        
        $article = $allArticles->firstWhere('slug', $slug);
        
        if (!$article) {
            abort(404);
        }
        
        // Get category counts
        $categories = [
            ['nama' => 'Semua Kategori', 'slug' => '', 'count' => $allArticles->count()],
            ['nama' => 'Kehamilan', 'slug' => 'kehamilan', 'count' => $allArticles->where('kategori_slug', 'kehamilan')->count()],
            ['nama' => 'Imunisasi', 'slug' => 'imunisasi', 'count' => $allArticles->where('kategori_slug', 'imunisasi')->count()],
            ['nama' => 'Parenting', 'slug' => 'parenting', 'count' => $allArticles->where('kategori_slug', 'parenting')->count()],
            ['nama' => 'Gizi & Nutrisi', 'slug' => 'gizi', 'count' => $allArticles->where('kategori_slug', 'gizi')->count()],
            ['nama' => 'Tumbuh Kembang', 'slug' => 'tumbuh-kembang', 'count' => $allArticles->where('kategori_slug', 'tumbuh-kembang')->count()],
        ];

        // Recent posts
        $recentArticles = $allArticles->take(3);

        return view('layouts.homepage.artikel_detail', compact('article', 'categories', 'recentArticles'));
    }

    public function layanan()
    {
        $layanans    = Layanan::aktif()->get();
        $temaColors  = Layanan::$temaColors;
        $intro       = LayananIntro::with('defaultImage')->where('is_active', true)->first();
        return view('layouts.homepage.layanan', compact('layanans', 'temaColors', 'intro'));
    }

    public function visimisi()
    {
        $visiMisi = VisiMisi::where('is_active', true)->first();
        return view('layouts.homepage.visimisi', compact('visiMisi'));
    }
}
