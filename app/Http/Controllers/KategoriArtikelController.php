<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriArtikelDataTable;
use App\Models\KategoriArtikel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KategoriArtikelDataTable $dataTable)
    {
        return $dataTable->render('pages.kategori_artikel.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.kategori_artikel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'      => 'required|string|max:255|unique:kategori_artikels,nama',
            'deskripsi' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['nama']);

        KategoriArtikel::create($data);

        Alert::success('Berhasil', 'Kategori artikel berhasil ditambahkan.');
        return redirect()->route('kategori-artikel.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriArtikel $kategoriArtikel)
    {
        $kategoriArtikel->loadCount('artikels');
        return view('pages.kategori_artikel.show', compact('kategoriArtikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriArtikel $kategoriArtikel)
    {
        return view('pages.kategori_artikel.edit', compact('kategoriArtikel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriArtikel $kategoriArtikel)
    {
        $data = $request->validate([
            'nama'      => 'required|string|max:255|unique:kategori_artikels,nama,' . $kategoriArtikel->id,
            'deskripsi' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['nama']);

        $kategoriArtikel->update($data);

        Alert::success('Berhasil', 'Kategori artikel berhasil diperbarui.');
        return redirect()->route('kategori-artikel.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriArtikel $kategoriArtikel)
    {
        $kategoriArtikel->delete();

        Alert::success('Berhasil', 'Kategori artikel berhasil dihapus.');
        return redirect()->route('kategori-artikel.index');
    }
}
