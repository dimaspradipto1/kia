<?php

namespace App\Http\Controllers;

use App\Models\Pembiayaan;
use App\Models\ProfilIbu;
use App\Http\Requests\PembiayaanRequest;
use App\DataTables\PembiayaanDataTable;
use RealRashid\SweetAlert\Facades\Alert;

class PembiayaanController extends Controller
{
    public function index(PembiayaanDataTable $dataTable)
    {
        return $dataTable->render('pages.pembiayaan.index');
    }

    public function create()
    {
        $ibu = ProfilIbu::orderBy('nama_lengkap')->get();
        return view('pages.pembiayaan.create', compact('ibu'));
    }

    public function store(PembiayaanRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        Pembiayaan::create($data);

        Alert::success('Berhasil', 'Data pembiayaan berhasil ditambahkan.');
        return redirect()->route('pembiayaan.index');
    }

    public function show(Pembiayaan $pembiayaan)
    {
        return view('pages.pembiayaan.show', compact('pembiayaan'));
    }

    public function edit(Pembiayaan $pembiayaan)
    {
        $ibu = ProfilIbu::orderBy('nama_lengkap')->get();
        return view('pages.pembiayaan.edit', compact('pembiayaan', 'ibu'));
    }

    public function update(PembiayaanRequest $request, Pembiayaan $pembiayaan)
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $pembiayaan->update($data);

        Alert::success('Berhasil', 'Data pembiayaan berhasil diperbarui.');
        return redirect()->route('pembiayaan.index');
    }

    public function destroy(Pembiayaan $pembiayaan)
    {
        $pembiayaan->delete();
        Alert::success('Berhasil', 'Data pembiayaan berhasil dihapus.');
        return redirect()->route('pembiayaan.index');
    }
}
