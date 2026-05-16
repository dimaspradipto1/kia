<?php

namespace App\Http\Controllers;

use App\Models\BukuKia;
use App\Models\ProfilIbu;
use App\Models\FasilitasKesehatan;
use App\Http\Requests\BukuKiaRequest;
use App\DataTables\BukuKiaDataTable;
use RealRashid\SweetAlert\Facades\Alert;

class BukuKiaController extends Controller
{
    public function index(BukuKiaDataTable $dataTable)
    {
        return $dataTable->render('pages.buku_kia.index');
    }

    public function create()
    {
        $ibu    = ProfilIbu::all();
        $faskes = FasilitasKesehatan::all();
        return view('pages.buku_kia.create', compact('ibu', 'faskes'));
    }

    public function store(BukuKiaRequest $request)
    {
        $data = $request->validated();
        $data['qr_code'] = 'KIA-' . strtoupper(uniqid());
        BukuKia::create($data);
        Alert::success('Berhasil', 'Buku KIA berhasil ditambahkan.');
        return redirect()->route('buku-kia.index');
    }

    public function show(BukuKia $bukuKia)
    {
        return view('pages.buku_kia.show', compact('bukuKia'));
    }

    public function edit(BukuKia $bukuKia)
    {
        $ibu    = ProfilIbu::all();
        $faskes = FasilitasKesehatan::all();
        return view('pages.buku_kia.edit', compact('bukuKia', 'ibu', 'faskes'));
    }

    public function update(BukuKiaRequest $request, BukuKia $bukuKia)
    {
        $bukuKia->update($request->validated());
        Alert::success('Berhasil', 'Buku KIA berhasil diperbarui.');
        return redirect()->route('buku-kia.index');
    }

    public function destroy(BukuKia $bukuKia)
    {
        $bukuKia->delete();
        return response()->json(['status' => 'success', 'message' => 'Buku KIA berhasil dihapus.']);
    }
}
