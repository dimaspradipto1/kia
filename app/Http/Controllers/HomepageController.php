<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\About;
use App\Models\ArtikelEdukasi;
use App\Models\Faq;
use App\Models\Contact;
use App\Models\KategoriArtikel;
use App\Models\Team;
use App\Models\VisiMisi;
use App\Models\Layanan;
use App\Models\LayananIntro;
use App\Models\FasilitasKesehatan;

class HomepageController extends Controller
{
    public function index()
    {
        $faqs = Faq::query()->where('is_active', true)->get();
        $visiMisi = VisiMisi::where('is_active', true)->first();
        $latestArticles = ArtikelEdukasi::published()
            ->with('kategoriArtikel')
            ->latest('diterbitkan_pada')
            ->take(3)
            ->get();
        $faskes = FasilitasKesehatan::where('is_active', true)->get();
        return view('layouts.homepage.index', compact('faqs', 'visiMisi', 'latestArticles', 'faskes'));
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
        $contact = Contact::where('is_active', true)->first();
        return view('layouts.homepage.contact', compact('contact'));
    }

    public function artikel(Request $request)
    {
        $search   = $request->get('search');
        $category = $request->get('category'); // slug kategori

        // Query dasar: hanya artikel published
        $query = ArtikelEdukasi::published()
            ->with('kategoriArtikel')
            ->latest('diterbitkan_pada');

        // Filter search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
            });
        }

        // Filter kategori by slug
        if ($category) {
            $query->whereHas('kategoriArtikel', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        $articles = $query->paginate(10)->withQueryString();

        // Daftar kategori untuk sidebar (hanya yg punya artikel published)
        $allKategoris = KategoriArtikel::withCount([
            'artikels' => fn($q) => $q->published(),
        ])->orderBy('nama')->get();

        $totalPublished = ArtikelEdukasi::published()->count();

        $categories = collect([
            ['nama' => 'Semua Kategori', 'slug' => '', 'count' => $totalPublished],
        ])->concat(
            $allKategoris->map(fn($k) => [
                'nama'  => $k->nama,
                'slug'  => $k->slug,
                'count' => $k->artikels_count,
            ])
        );

        // Artikel terbaru (sidebar)
        $recentArticles = ArtikelEdukasi::published()
            ->with('kategoriArtikel')
            ->latest('diterbitkan_pada')
            ->take(3)
            ->get();

        return view('layouts.homepage.artikel', compact(
            'articles', 'categories', 'recentArticles', 'search', 'category'
        ));
    }

    public function showArtikel($slug)
    {
        $article = ArtikelEdukasi::published()
            ->with('kategoriArtikel')
            ->where('slug', $slug)
            ->firstOrFail();

        // Daftar kategori untuk sidebar
        $allKategoris = KategoriArtikel::withCount([
            'artikels' => fn($q) => $q->published(),
        ])->orderBy('nama')->get();

        $totalPublished = ArtikelEdukasi::published()->count();

        $categories = collect([
            ['nama' => 'Semua Kategori', 'slug' => '', 'count' => $totalPublished],
        ])->concat(
            $allKategoris->map(fn($k) => [
                'nama'  => $k->nama,
                'slug'  => $k->slug,
                'count' => $k->artikels_count,
            ])
        );

        $recentArticles = ArtikelEdukasi::published()
            ->with('kategoriArtikel')
            ->latest('diterbitkan_pada')
            ->take(3)
            ->get();

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
