<?php

namespace App\Http\Controllers;

use App\Models\Persalinan;
use App\Models\BukuKia;
use App\Models\FasilitasKesehatan;
use App\Models\User;
use App\DataTables\PersalinanDataTable;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PersalinanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PersalinanDataTable $dataTable)
    {
        return $dataTable->render('pages.persalinan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $bukuKias = BukuKia::with('profilIbu')->get();
        $faskes = FasilitasKesehatan::all();
        // Fetch only Users that have a nakes role (role_id = 3)
        $nakes = User::where('roles_id', 3)->get();
        $selectedBukuKiaId = $request->query('buku_kia_id');

        return view('pages.persalinan.create', compact('bukuKias', 'faskes', 'nakes', 'selectedBukuKiaId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'buku_kia_id' => 'required|exists:buku_kias,id',
            'fasilitas_kesehatan_id' => 'required|exists:fasilitas_kesehatans,id',
            'tanggal_lahir' => 'required|date',
            'jam_lahir' => 'required|string|max:255',
            'jenis_persalinan' => 'required|string|max:255',
            'penolong' => 'required|string|max:255',
            'berat_bayi_kg' => 'required|numeric|min:0',
            'panjang_bayi_cm' => 'required|numeric|min:0',
            'apgar_score_1' => 'required|integer|min:0|max:10',
            'apgar_score_5' => 'required|integer|min:0|max:10',
            'kondisi_ibu' => 'required|string|max:255',
            'kondisi_bayi' => 'required|string|max:255',
            'komplikasi' => 'nullable|string',
            'nakes_id' => 'required|exists:users,id',
        ]);

        Persalinan::create($data);
        Alert::success('Berhasil', 'Data Persalinan berhasil ditambahkan.');
        return redirect()->route('persalinan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Persalinan $persalinan)
    {
        return redirect()->route('persalinan.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Persalinan $persalinan)
    {
        $bukuKias = BukuKia::with('profilIbu')->get();
        $faskes = FasilitasKesehatan::all();
        $nakes = User::where('roles_id', 3)->get();

        return view('pages.persalinan.edit', compact('persalinan', 'bukuKias', 'faskes', 'nakes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Persalinan $persalinan)
    {
        $data = $request->validate([
            'buku_kia_id' => 'required|exists:buku_kias,id',
            'fasilitas_kesehatan_id' => 'required|exists:fasilitas_kesehatans,id',
            'tanggal_lahir' => 'required|date',
            'jam_lahir' => 'required|string|max:255',
            'jenis_persalinan' => 'required|string|max:255',
            'penolong' => 'required|string|max:255',
            'berat_bayi_kg' => 'required|numeric|min:0',
            'panjang_bayi_cm' => 'required|numeric|min:0',
            'apgar_score_1' => 'required|integer|min:0|max:10',
            'apgar_score_5' => 'required|integer|min:0|max:10',
            'kondisi_ibu' => 'required|string|max:255',
            'kondisi_bayi' => 'required|string|max:255',
            'komplikasi' => 'nullable|string',
            'nakes_id' => 'required|exists:users,id',
        ]);

        $persalinan->update($data);
        Alert::success('Berhasil', 'Data Persalinan berhasil diperbarui.');
        return redirect()->route('persalinan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persalinan $persalinan)
    {
        $persalinan->delete();
        return response()->json(['status' => 'success', 'message' => 'Data Persalinan berhasil dihapus.']);
    }
}
