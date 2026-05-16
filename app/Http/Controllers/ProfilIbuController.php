<?php

namespace App\Http\Controllers;

use App\Models\ProfilIbu;
use App\Models\User;
use App\Models\FasilitasKesehatan;
use App\Http\Requests\ProfilIbuRequest;
use App\DataTables\ProfileIbuDataTable;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilIbuController extends Controller
{
    public function index(ProfileIbuDataTable $dataTable)
    {
        return $dataTable->render('pages.profil_ibu.index');
    }

    public function create()
    {
        $faskes = FasilitasKesehatan::where('is_active', true)->get();
        return view('pages.profil_ibu.create', [
            'faskes' => $faskes
        ]);
    }

    public function store(ProfilIbuRequest $request)
    {
        ProfilIbu::create($request->validated());

        Alert::success('Berhasil', 'Profil Ibu berhasil ditambahkan.');
        return redirect()->route('profil-ibu.index');
    }

    public function show(ProfilIbu $profilIbu)
    {
        return view('pages.profil_ibu.show', ['profilIbu' => $profilIbu]);
    }

    public function edit(ProfilIbu $profilIbu)
    {
        $faskes = FasilitasKesehatan::where('is_active', true)->get();
        return view('pages.profil_ibu.edit', [
            'profilIbu' => $profilIbu,
            'faskes' => $faskes
        ]);
    }

    public function update(ProfilIbuRequest $request, ProfilIbu $profilIbu)
    {
        $profilIbu->update($request->validated());

        Alert::success('Berhasil', 'Profil Ibu berhasil diperbarui.');
        return redirect()->route('profil-ibu.index');
    }

    public function destroy(ProfilIbu $profilIbu)
    {
        $profilIbu->delete();
        Alert::success('Berhasil', 'Profil Ibu berhasil dihapus.');
        return redirect()->route('profil-ibu.index');
    }
}
