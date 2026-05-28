<?php

namespace App\Http\Controllers;

use App\Models\FasilitasKesehatan;
use Illuminate\Http\Request;
use App\DataTables\FasilitasKesehatanDataTable;
use App\Http\Requests\FasilitasKesehatanRequest;
use RealRashid\SweetAlert\Facades\Alert;

class FasilitasKesehatanController extends Controller
{
    public function index(FasilitasKesehatanDataTable $dataTable)
    {
        return $dataTable->render('pages.fasilitas_kesehatan.index');
    }

    public function create()
    {
        return view('pages.fasilitas_kesehatan.create');
    }

    public function store(FasilitasKesehatanRequest $request)
    {
        $data = $request->validated();
        if ($request->jam_buka && $request->jam_tutup) {
            $data['jam_operasional'] = $request->jam_buka . ' - ' . $request->jam_tutup;
        }

        FasilitasKesehatan::create($data);

        Alert::success('Berhasil', 'Fasilitas Kesehatan berhasil ditambahkan.');
        return redirect()->route('fasilitas-kesehatan.index');
    }

    public function show(FasilitasKesehatan $fasilitasKesehatan)
    {
        return view('pages.fasilitas_kesehatan.show', compact('fasilitasKesehatan'));
    }

    public function edit(FasilitasKesehatan $fasilitasKesehatan)
    {
        return view('pages.fasilitas_kesehatan.edit', compact('fasilitasKesehatan'));
    }

    public function update(FasilitasKesehatanRequest $request, FasilitasKesehatan $fasilitasKesehatan)
    {
        $data = $request->validated();
        if ($request->jam_buka && $request->jam_tutup) {
            $data['jam_operasional'] = $request->jam_buka . ' - ' . $request->jam_tutup;
        }

        $fasilitasKesehatan->update($data);

        Alert::success('Berhasil', 'Fasilitas Kesehatan berhasil diperbarui.');
        return redirect()->route('fasilitas-kesehatan.index');
    }

    public function saveKoordinat(Request $request, FasilitasKesehatan $fasilitasKesehatan)
    {
        $request->validate([
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $fasilitasKesehatan->update([
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json(['success' => true, 'id' => $fasilitasKesehatan->id]);
    }

    public function destroy(FasilitasKesehatan $fasilitasKesehatan)
    {
        $fasilitasKesehatan->delete();
        Alert::success('Berhasil', 'Fasilitas Kesehatan berhasil dihapus.');
        return redirect()->route('fasilitas-kesehatan.index');
    }
}
