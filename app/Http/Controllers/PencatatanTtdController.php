<?php

namespace App\Http\Controllers;

use App\Models\PencatatanTtd;
use App\Models\BukuKia;
use App\DataTables\PencatatanTtdDataTable;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PencatatanTtdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PencatatanTtdDataTable $dataTable)
    {
        return $dataTable->render('pages.pencatatan_ttd.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $bukuKias = BukuKia::with('profilIbu')->get();
        $selectedBukuKiaId = $request->query('buku_kia_id');

        return view('pages.pencatatan_ttd.create', compact('bukuKias', 'selectedBukuKiaId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'buku_kia_id' => 'required|exists:buku_kias,id',
            'tanggal' => 'required|date',
            'diminum' => 'required|in:Ya,Tidak',
            'catatan' => 'nullable|string',
        ]);

        PencatatanTtd::create($data);
        Alert::success('Berhasil', 'Pencatatan TTD/MMS berhasil ditambahkan.');
        return redirect()->route('pencatatan-ttd.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PencatatanTtd $pencatatanTtd)
    {
        return redirect()->route('pencatatan-ttd.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PencatatanTtd $pencatatanTtd)
    {
        $bukuKias = BukuKia::with('profilIbu')->get();
        return view('pages.pencatatan_ttd.edit', compact('pencatatanTtd', 'bukuKias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PencatatanTtd $pencatatanTtd)
    {
        $data = $request->validate([
            'buku_kia_id' => 'required|exists:buku_kias,id',
            'tanggal' => 'required|date',
            'diminum' => 'required|in:Ya,Tidak',
            'catatan' => 'nullable|string',
        ]);

        $pencatatanTtd->update($data);
        Alert::success('Berhasil', 'Pencatatan TTD/MMS berhasil diperbarui.');
        return redirect()->route('pencatatan-ttd.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PencatatanTtd $pencatatanTtd)
    {
        $pencatatanTtd->delete();
        return response()->json(['status' => 'success', 'message' => 'Pencatatan TTD/MMS berhasil dihapus.']);
    }
}
