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
        $user = auth()->user();
        $isIbuHamil = $user && $user->role && strtolower($user->role->nama_role) === 'ibu hamil';

        if ($isIbuHamil) {
            $ibu = ProfilIbu::where('user_id', $user->id)->get();
            if ($ibu->isEmpty()) {
                Alert::warning('Perhatian', 'Silakan lengkapi Profil Ibu Hamil Anda terlebih dahulu sebelum menambahkan data suami.');
                return redirect()->route('profil-ibu.create');
            }
            $existing = ProfilSuami::where('profil_ibu_id', $ibu->first()->id)->first();
            if ($existing) {
                Alert::info('Info', 'Anda sudah memiliki data Profil Suami. Silakan perbarui data jika diperlukan.');
                return redirect()->route('profil-suami.edit', $existing->id);
            }
        } else {
            $ibu = ProfilIbu::orderBy('nama_lengkap')->get();
        }

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
        $user = auth()->user();
        $isIbuHamil = $user && $user->role && strtolower($user->role->nama_role) === 'ibu hamil';

        if ($isIbuHamil) {
            if ($profilSuami->profilIbu && $profilSuami->profilIbu->user_id !== $user->id) {
                Alert::error('Akses Ditolak', 'Anda hanya dapat mengedit profil suami Anda sendiri.');
                return redirect()->route('profil-suami.index');
            }
            $ibu = ProfilIbu::where('user_id', $user->id)->get();
        } else {
            $ibu = ProfilIbu::orderBy('nama_lengkap')->get();
        }

        return view('pages.profil_suami.edit', compact('profilSuami', 'ibu'));
    }

    public function update(ProfilSuamiRequest $request, ProfilSuami $profilSuami)
    {
        $user = auth()->user();
        $isIbuHamil = $user && $user->role && strtolower($user->role->nama_role) === 'ibu hamil';

        if ($isIbuHamil) {
            if ($profilSuami->profilIbu && $profilSuami->profilIbu->user_id !== $user->id) {
                Alert::error('Akses Ditolak', 'Anda hanya dapat mengubah profil suami Anda sendiri.');
                return redirect()->route('profil-suami.index');
            }
        }

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
