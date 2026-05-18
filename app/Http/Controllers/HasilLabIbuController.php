<?php

namespace App\Http\Controllers;

use App\DataTables\HasilLabIbuDataTable;
use App\Models\HasilLabIbu;
use App\Models\KunjunganAnc;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class HasilLabIbuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(HasilLabIbuDataTable $dataTable)
    {
        return $dataTable->render('pages.hasil_lab_ibu.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $selectedKunjunganId = $request->query('kunjungan_anc_id');
        $kunjunganAncs = KunjunganAnc::with('bukuKia.profilIbu')->get();
        return view('pages.hasil_lab_ibu.create', compact('kunjunganAncs', 'selectedKunjunganId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kunjungan_anc_id' => 'required|exists:kunjungan_ancs,id',
            'jenis_pemeriksaan' => 'required|string|max:255',
            'hasil' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'nilai_normal' => 'required|string|max:255',
            'tanggal_periksa' => 'required|date',
        ]);

        $data['nakes_id'] = auth()->id();

        HasilLabIbu::create($data);

        Alert::success('Berhasil', 'Hasil Lab Ibu berhasil ditambahkan.');
        return redirect()->route('hasil-lab-ibu.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(HasilLabIbu $hasilLabIbu)
    {
        return redirect()->route('hasil-lab-ibu.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HasilLabIbu $hasilLabIbu)
    {
        $kunjunganAncs = KunjunganAnc::with('bukuKia.profilIbu')->get();
        return view('pages.hasil_lab_ibu.edit', compact('hasilLabIbu', 'kunjunganAncs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HasilLabIbu $hasilLabIbu)
    {
        $data = $request->validate([
            'kunjungan_anc_id' => 'required|exists:kunjungan_ancs,id',
            'jenis_pemeriksaan' => 'required|string|max:255',
            'hasil' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'nilai_normal' => 'required|string|max:255',
            'tanggal_periksa' => 'required|date',
        ]);

        $data['nakes_id'] = auth()->id();

        $hasilLabIbu->update($data);

        Alert::success('Berhasil', 'Hasil Lab Ibu berhasil diperbarui.');
        return redirect()->route('hasil-lab-ibu.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HasilLabIbu $hasilLabIbu)
    {
        $hasilLabIbu->delete();
        return response()->json([
            'success' => true,
            'message' => 'Hasil Lab Ibu berhasil dihapus.'
        ]);
    }
}
