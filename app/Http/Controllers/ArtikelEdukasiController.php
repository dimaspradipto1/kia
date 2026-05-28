<?php

namespace App\Http\Controllers;

use App\DataTables\ArtikelEdukasiDataTable;
use App\Models\ArtikelEdukasi;
use App\Models\KategoriArtikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ArtikelEdukasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ArtikelEdukasiDataTable $dataTable)
    {
        return $dataTable->render('pages.artikel_edukasi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = KategoriArtikel::orderBy('nama')->get();
        return view('pages.artikel_edukasi.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'               => 'required|string|max:255',
            'isi'                 => 'required|string',
            'kategori_artikel_id' => 'required|exists:kategori_artikels,id',
            'penulis'             => 'required|string|max:150',
            'status'              => 'required|in:draft,published',
            'diterbitkan_pada'    => 'nullable|date',
            'gambar'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        // Auto-set tanggal terbit jika published dan tidak diisi
        if ($data['status'] === 'published' && empty($data['diterbitkan_pada'])) {
            $data['diterbitkan_pada'] = now()->toDateString();
        }

        $data['slug'] = ArtikelEdukasi::generateUniqueSlugPublic($data['judul']);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('artikel_edukasi', 'public');
        }

        ArtikelEdukasi::create($data);

        Alert::success('Berhasil', 'Artikel berhasil ' . ($data['status'] === 'published' ? 'diterbitkan' : 'disimpan sebagai draft') . '.');
        return redirect()->route('artikel-edukasi.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ArtikelEdukasi $artikelEdukasi)
    {
        return view('pages.artikel_edukasi.show', compact('artikelEdukasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArtikelEdukasi $artikelEdukasi)
    {
        $kategoris = KategoriArtikel::orderBy('nama')->get();
        return view('pages.artikel_edukasi.edit', compact('artikelEdukasi', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArtikelEdukasi $artikelEdukasi)
    {
        $data = $request->validate([
            'judul'               => 'required|string|max:255',
            'isi'                 => 'required|string',
            'kategori_artikel_id' => 'required|exists:kategori_artikels,id',
            'penulis'             => 'required|string|max:150',
            'status'              => 'required|in:draft,published',
            'diterbitkan_pada'    => 'nullable|date',
            'gambar'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($data['status'] === 'published' && empty($data['diterbitkan_pada'])) {
            $data['diterbitkan_pada'] = $artikelEdukasi->diterbitkan_pada ?? now()->toDateString();
        }

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika bukan dari folder homepage
            if ($artikelEdukasi->gambar && str_contains($artikelEdukasi->gambar, '/')) {
                Storage::disk('public')->delete($artikelEdukasi->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('artikel_edukasi', 'public');
        }

        // Update slug hanya jika judul berubah
        if ($data['judul'] !== $artikelEdukasi->judul) {
            $data['slug'] = ArtikelEdukasi::generateUniqueSlugPublic($data['judul'], $artikelEdukasi->id);
        }

        $artikelEdukasi->update($data);

        Alert::success('Berhasil', 'Artikel berhasil diperbarui.');
        return redirect()->route('artikel-edukasi.edit', $artikelEdukasi->id);
    }

    /**
     * Upload image from TinyMCE editor.
     */
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('artikel_edukasi/konten', 'public');
            return response()->json([
                'location' => Storage::disk('public')->url($path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArtikelEdukasi $artikelEdukasi)
    {
        if ($artikelEdukasi->gambar && str_contains($artikelEdukasi->gambar, '/')) {
            Storage::disk('public')->delete($artikelEdukasi->gambar);
        }

        $artikelEdukasi->delete();

        Alert::success('Berhasil', 'Artikel berhasil dihapus.');
        return redirect()->route('artikel-edukasi.index');
    }
}
