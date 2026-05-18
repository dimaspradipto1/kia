<?php

namespace App\Http\Controllers;

use App\Models\BayiBaruLahir;
use App\Models\ProfilAnak;
use App\Models\User;
use App\DataTables\BayiBaruLahirDataTable;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

class BayiBaruLahirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BayiBaruLahirDataTable $dataTable)
    {
        return $dataTable->render('pages.bayi_baru_lahir.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $profilAnaks = ProfilAnak::with('bukuKia.profilIbu')->get();
        $nakes       = User::where('roles_id', 3)->get();
        $selectedProfilAnakId = $request->query('profil_anak_id');

        return view('pages.bayi_baru_lahir.create', compact('profilAnaks', 'nakes', 'selectedProfilAnakId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'profil_anak_id'       => 'required|exists:profil_anaks,id',
            'nakes_id'             => 'required|exists:users,id',
            'hb0_diberikan'        => 'required|boolean',
            'hb0_waktu'            => 'nullable|date_format:H:i',
            'vit_k1_diberikan'     => 'required|boolean',
            'salep_mata_diberikan' => 'required|boolean',
            'shk_dilakukan'        => 'required|boolean',
            'shk_waktu'            => 'nullable|date_format:H:i',
            'shk_hasil'            => 'nullable|string|max:255',
            'pjb_dilakukan'        => 'required|boolean',
            'pjb_hasil'            => 'nullable|string|max:255',
            'kondisi_umum'         => 'required|in:Baik,Sedang,Buruk',
        ]);

        // persalinan_id is nullable since it may not exist yet
        $validated['persalinan_id'] = $request->input('persalinan_id') ?: null;

        BayiBaruLahir::create($validated);

        Alert::success('Berhasil', 'Data bayi baru lahir berhasil disimpan.');
        return redirect()->route('bayi-baru-lahir.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BayiBaruLahir $bayiBaruLahir)
    {
        $profilAnaks = ProfilAnak::with('bukuKia.profilIbu')->get();
        $nakes       = User::where('roles_id', 3)->get();

        return view('pages.bayi_baru_lahir.edit', compact('bayiBaruLahir', 'profilAnaks', 'nakes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BayiBaruLahir $bayiBaruLahir)
    {
        $validated = $request->validate([
            'profil_anak_id'       => 'required|exists:profil_anaks,id',
            'nakes_id'             => 'required|exists:users,id',
            'hb0_diberikan'        => 'required|boolean',
            'hb0_waktu'            => 'nullable|date_format:H:i',
            'vit_k1_diberikan'     => 'required|boolean',
            'salep_mata_diberikan' => 'required|boolean',
            'shk_dilakukan'        => 'required|boolean',
            'shk_waktu'            => 'nullable|date_format:H:i',
            'shk_hasil'            => 'nullable|string|max:255',
            'pjb_dilakukan'        => 'required|boolean',
            'pjb_hasil'            => 'nullable|string|max:255',
            'kondisi_umum'         => 'required|in:Baik,Sedang,Buruk',
        ]);

        $bayiBaruLahir->update($validated);

        Alert::success('Berhasil', 'Data bayi baru lahir berhasil diperbarui.');
        return redirect()->route('bayi-baru-lahir.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BayiBaruLahir $bayiBaruLahir)
    {
        $bayiBaruLahir->delete();
        return response()->json(['status' => 'success', 'message' => 'Data bayi baru lahir berhasil dihapus.']);
    }
}
