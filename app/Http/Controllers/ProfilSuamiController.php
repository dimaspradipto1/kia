<?php

namespace App\Http\Controllers;

use App\Models\ProfilSuami;
use App\Models\ProfilIbu;
use App\Http\Requests\ProfilSuamiRequest;
use App\DataTables\ProfilSuamiDataTable;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilSuamiController extends Controller
{
    public function index(ProfilSuamiDataTable $dataTable)
    {
        return $dataTable->render('pages.profil_suami.index');
    }

    public function create()
    {
        $ibu = ProfilIbu::all();
        return view('pages.profil_suami.create', compact('ibu'));
    }

    public function store(ProfilSuamiRequest $request)
    {
        ProfilSuami::create($request->validated());
        Alert::success('Berhasil', 'Profil Suami berhasil ditambahkan.');
        return redirect()->route('profil-suami.index');
    }

    public function show(ProfilSuami $profilSuami)
    {
        return view('pages.profil_suami.show', compact('profilSuami'));
    }

    public function edit(ProfilSuami $profilSuami)
    {
        $ibu = ProfilIbu::all();
        return view('pages.profil_suami.edit', compact('profilSuami', 'ibu'));
    }

    public function update(ProfilSuamiRequest $request, ProfilSuami $profilSuami)
    {
        $profilSuami->update($request->validated());
        Alert::success('Berhasil', 'Profil Suami berhasil diperbarui.');
        return redirect()->route('profil-suami.index');
    }

    public function destroy(ProfilSuami $profilSuami)
    {
        $profilSuami->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Profil Suami berhasil dihapus.'
        ]);
    }
}
