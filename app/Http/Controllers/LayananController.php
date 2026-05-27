<?php

namespace App\Http\Controllers;

use App\DataTables\LayananDataTable;
use App\Models\Layanan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LayananController extends Controller
{
    public function index(LayananDataTable $dataTable)
    {
        return $dataTable->render('pages.layanan.index');
    }

    public function create()
    {
        $temaColors = Layanan::$temaColors;
        return view('pages.layanan.create', compact('temaColors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'             => 'required|string|max:150',
            'ikon'              => 'required|string|max:50',
            'tema'              => 'required|string|in:pink,green,blue,yellow,purple,orange',
            'deskripsi'         => 'nullable|string|max:300',
            'deskripsi_panjang' => 'nullable|string',
            'urutan'            => 'required|integer|min:0',
            'is_active'         => 'required|boolean',
        ]);

        Layanan::create($request->only([
            'judul', 'ikon', 'tema', 'deskripsi', 'deskripsi_panjang', 'urutan', 'is_active',
        ]));

        Alert::success('Berhasil', 'Layanan berhasil ditambahkan.');
        return redirect()->route('layanans.index');
    }

    public function show(Layanan $layanan)
    {
        $temaColors = Layanan::$temaColors;
        return view('pages.layanan.show', compact('layanan', 'temaColors'));
    }

    public function edit(Layanan $layanan)
    {
        $temaColors = Layanan::$temaColors;
        return view('pages.layanan.edit', compact('layanan', 'temaColors'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'judul'             => 'required|string|max:150',
            'ikon'              => 'required|string|max:50',
            'tema'              => 'required|string|in:pink,green,blue,yellow,purple,orange',
            'deskripsi'         => 'nullable|string|max:300',
            'deskripsi_panjang' => 'nullable|string',
            'urutan'            => 'required|integer|min:0',
            'is_active'         => 'required|boolean',
        ]);

        $layanan->update($request->only([
            'judul', 'ikon', 'tema', 'deskripsi', 'deskripsi_panjang', 'urutan', 'is_active',
        ]));

        Alert::success('Berhasil', 'Layanan berhasil diperbarui.');
        return redirect()->route('layanans.index');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();
        Alert::success('Berhasil', 'Data layanan berhasil dihapus.');
        return redirect()->route('layanans.index');
    }
}
