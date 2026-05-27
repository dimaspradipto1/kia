<?php

namespace App\Http\Controllers;

use App\DataTables\VisiMisiDataTable;
use App\Models\VisiMisi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class VisiMisiController extends Controller
{
    public function index(VisiMisiDataTable $dataTable)
    {
        return $dataTable->render('pages.visimisi.index');
    }

    public function create()
    {
        $temaColors = VisiMisi::$temaColors;
        return view('pages.visimisi.create', compact('temaColors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'visi'                    => 'required|string',
            'misi_raw'                => 'required|string',
            'nilai'                   => 'nullable|string',
            'nilai_items'             => 'nullable|array',
            'nilai_items.*.judul'     => 'required_with:nilai_items|string|max:100',
            'nilai_items.*.deskripsi' => 'required_with:nilai_items|string',
            'nilai_items.*.ikon'      => 'nullable|string|max:50',
            'nilai_items.*.tema'      => 'nullable|string|in:pink,green,blue,yellow,purple,orange',
            'is_active'               => 'required|boolean',
        ]);

        // Parse misi: satu baris = satu poin
        $misi = array_values(array_filter(
            array_map('trim', explode("\n", $request->misi_raw)),
            fn($line) => $line !== ''
        ));

        // Nilai items
        $nilaiItems = [];
        if ($request->has('nilai_items')) {
            foreach ($request->nilai_items as $item) {
                if (!empty(trim($item['judul']))) {
                    $nilaiItems[] = [
                        'judul'     => trim($item['judul']),
                        'deskripsi' => trim($item['deskripsi'] ?? ''),
                        'ikon'      => trim($item['ikon'] ?? 'fa-star'),
                        'tema'      => $item['tema'] ?? 'blue',
                    ];
                }
            }
        }

        VisiMisi::create([
            'visi'        => $request->visi,
            'misi'        => $misi,
            'nilai'       => $request->nilai,
            'nilai_items' => $nilaiItems ?: null,
            'is_active'   => $request->is_active,
        ]);

        Alert::success('Berhasil', 'Visi & Misi berhasil ditambahkan.');
        return redirect()->route('visi-misi.index');
    }

    public function show(VisiMisi $visiMisi)
    {
        $temaColors = VisiMisi::$temaColors;
        return view('pages.visimisi.show', compact('visiMisi', 'temaColors'));
    }

    public function edit(VisiMisi $visiMisi)
    {
        $temaColors = VisiMisi::$temaColors;
        // Ubah array misi kembali ke teks (satu baris per poin)
        $misiRaw = implode("\n", $visiMisi->misi ?? []);
        return view('pages.visimisi.edit', compact('visiMisi', 'misiRaw', 'temaColors'));
    }

    public function update(Request $request, VisiMisi $visiMisi)
    {
        $request->validate([
            'visi'                    => 'required|string',
            'misi_raw'                => 'required|string',
            'nilai'                   => 'nullable|string',
            'nilai_items'             => 'nullable|array',
            'nilai_items.*.judul'     => 'required_with:nilai_items|string|max:100',
            'nilai_items.*.deskripsi' => 'required_with:nilai_items|string',
            'nilai_items.*.ikon'      => 'nullable|string|max:50',
            'nilai_items.*.tema'      => 'nullable|string|in:pink,green,blue,yellow,purple,orange',
            'is_active'               => 'required|boolean',
        ]);

        $misi = array_values(array_filter(
            array_map('trim', explode("\n", $request->misi_raw)),
            fn($line) => $line !== ''
        ));

        $nilaiItems = [];
        if ($request->has('nilai_items')) {
            foreach ($request->nilai_items as $item) {
                if (!empty(trim($item['judul']))) {
                    $nilaiItems[] = [
                        'judul'     => trim($item['judul']),
                        'deskripsi' => trim($item['deskripsi'] ?? ''),
                        'ikon'      => trim($item['ikon'] ?? 'fa-star'),
                        'tema'      => $item['tema'] ?? 'blue',
                    ];
                }
            }
        }

        $visiMisi->update([
            'visi'        => $request->visi,
            'misi'        => $misi,
            'nilai'       => $request->nilai,
            'nilai_items' => $nilaiItems ?: null,
            'is_active'   => $request->is_active,
        ]);

        Alert::success('Berhasil', 'Visi & Misi berhasil diperbarui.');
        return redirect()->route('visi-misi.index');
    }

    public function destroy(VisiMisi $visiMisi)
    {
        $visiMisi->delete();
        Alert::success('Berhasil', 'Data Visi & Misi berhasil dihapus.');
        return redirect()->route('visi-misi.index');
    }
}
