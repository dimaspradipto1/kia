<?php

namespace App\Http\Controllers;

use App\Models\ProfilAnak;
use App\Models\BukuKia;
use App\Http\Requests\ProfilAnakRequest;
use App\DataTables\ProfilAnakDataTable;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilAnakController extends Controller
{
    public function index(ProfilAnakDataTable $dataTable)
    {
        return $dataTable->render('pages.profil_anak.index');
    }

    public function create()
    {
        $bukuKia = BukuKia::with('profilIbu')->get();
        return view('pages.profil_anak.create', compact('bukuKia'));
    }

    public function store(ProfilAnakRequest $request)
    {
        ProfilAnak::create($request->validated());
        Alert::success('Berhasil', 'Profil Anak berhasil ditambahkan.');
        return redirect()->route('profil-anak.index');
    }

    public function show(ProfilAnak $profilAnak)
    {
        $profilAnak->load([
            'bukuKia.profilIbu',
            'bayiBaruLahir.nakes',
            'imunisasiAnaks.fasilitasKesehatan',
            'imunisasiAnaks.nakes',
            'tumbuhKembangs.fasilitasKesehatan',
            'tumbuhKembangs.nakes',
            'perkembanganSidtks.nakes',
            'mpasis.nakes',
        ]);
        return view('pages.profil_anak.show', compact('profilAnak'));
    }

    public function edit(ProfilAnak $profilAnak)
    {
        $bukuKia = BukuKia::with('profilIbu')->get();
        return view('pages.profil_anak.edit', compact('profilAnak', 'bukuKia'));
    }

    public function update(ProfilAnakRequest $request, ProfilAnak $profilAnak)
    {
        $profilAnak->update($request->validated());
        Alert::success('Berhasil', 'Profil Anak berhasil diperbarui.');
        return redirect()->route('profil-anak.index');
    }

    public function destroy(ProfilAnak $profilAnak)
    {
        $profilAnak->delete();
        return response()->json(['status' => 'success', 'message' => 'Profil Anak berhasil dihapus.']);
    }
}
