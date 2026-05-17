<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\DataTables\KbPascaSalinDataTable;
use App\Models\KbPascaSalin;
use App\Models\BukuKia;
use App\Models\User;
use App\Models\FasilitasKesehatan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KbPascaSalinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KbPascaSalinDataTable $dataTable)
    {
        return $dataTable->render('pages.kb_pasca_salin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $bukuKias = BukuKia::with('profilIbu')->get();
        
        // Filter users with 'nakes' role
        $nakes = User::whereHas('role', function ($q) {
            $q->where('nama_role', 'nakes');
        })->get();

        $faskes = FasilitasKesehatan::all();
        $selectedBukuKiaId = $request->query('buku_kia_id');

        return view('pages.kb_pasca_salin.create', compact('bukuKias', 'nakes', 'faskes', 'selectedBukuKiaId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'buku_kia_id' => 'required|exists:buku_kias,id',
            'nakes_id' => 'required|exists:users,id',
            'fasilitas_kesehatan_id' => 'required|exists:fasilitas_kesehatans,id',
            'metode_kb' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        KbPascaSalin::create($request->all());

        Alert::success('Berhasil', 'Data KB Pasca Salin berhasil ditambahkan.');
        return redirect()->route('kb-pasca-salin.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(KbPascaSalin $kbPascaSalin)
    {
        return redirect()->route('kb-pasca-salin.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KbPascaSalin $kbPascaSalin)
    {
        $bukuKias = BukuKia::with('profilIbu')->get();
        
        $nakes = User::whereHas('role', function ($q) {
            $q->where('nama_role', 'nakes');
        })->get();

        $faskes = FasilitasKesehatan::all();

        return view('pages.kb_pasca_salin.edit', compact('kbPascaSalin', 'bukuKias', 'nakes', 'faskes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KbPascaSalin $kbPascaSalin)
    {
        $request->validate([
            'buku_kia_id' => 'required|exists:buku_kias,id',
            'nakes_id' => 'required|exists:users,id',
            'fasilitas_kesehatan_id' => 'required|exists:fasilitas_kesehatans,id',
            'metode_kb' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        $kbPascaSalin->update($request->all());

        Alert::success('Berhasil', 'Data KB Pasca Salin berhasil diperbarui.');
        return redirect()->route('kb-pasca-salin.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KbPascaSalin $kbPascaSalin)
    {
        $kbPascaSalin->delete();
        
        Alert::success('Berhasil', 'Data KB Pasca Salin berhasil dihapus.');
        return redirect()->route('kb-pasca-salin.index');
    }
}
