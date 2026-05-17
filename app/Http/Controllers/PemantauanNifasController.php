<?php

namespace App\Http\Controllers;

use App\Models\PemantauanNifas;
use App\Models\BukuKia;
use App\Models\User;
use App\DataTables\PemantauanNifasDataTable;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PemantauanNifasController extends Controller
{
    public function index(PemantauanNifasDataTable $dataTable)
    {
        return $dataTable->render('pages.pemantauan_nifas.index');
    }

    public function create(Request $request)
    {
        $bukuKias = BukuKia::with('profilIbu')->get();
        // Fetch only Users that have a nakes role (role_id = 3)
        $nakes = User::where('roles_id', 3)->get();
        $selectedBukuKiaId = $request->query('buku_kia_id');
        
        return view('pages.pemantauan_nifas.create', compact('bukuKias', 'nakes', 'selectedBukuKiaId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'buku_kia_id' => 'required|exists:buku_kias,id',
            'nakes_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'hari_ke' => 'required|string|max:255',
            'demam' => 'required|in:Ya,Tidak',
            'pendarahan' => 'required|in:Ya,Tidak',
            'nyeri_ulu_hati' => 'required|in:Ya,Tidak',
            'pandangan_kabur' => 'required|in:Ya,Tidak',
            'keluar_cairan_berbau' => 'required|in:Ya,Tidak',
            'payudara_bengkak' => 'required|in:Ya,Tidak',
            'gangguan_jiwa' => 'required|in:Ya,Tidak',
            'gangguan_bak' => 'required|in:Ya,Tidak',
            'catatan' => 'nullable|string',
        ]);

        PemantauanNifas::create($data);
        Alert::success('Berhasil', 'Pemantauan Nifas berhasil ditambahkan.');
        return redirect()->route('pemantauan-nifas.index');
    }

    public function edit(PemantauanNifas $pemantauanNifas)
    {
        $bukuKias = BukuKia::with('profilIbu')->get();
        $nakes = User::where('roles_id', 3)->get();
        return view('pages.pemantauan_nifas.edit', compact('pemantauanNifas', 'bukuKias', 'nakes'));
    }

    public function update(Request $request, PemantauanNifas $pemantauanNifas)
    {
        $data = $request->validate([
            'buku_kia_id' => 'required|exists:buku_kias,id',
            'nakes_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'hari_ke' => 'required|string|max:255',
            'demam' => 'required|in:Ya,Tidak',
            'pendarahan' => 'required|in:Ya,Tidak',
            'nyeri_ulu_hati' => 'required|in:Ya,Tidak',
            'pandangan_kabur' => 'required|in:Ya,Tidak',
            'keluar_cairan_berbau' => 'required|in:Ya,Tidak',
            'payudara_bengkak' => 'required|in:Ya,Tidak',
            'gangguan_jiwa' => 'required|in:Ya,Tidak',
            'gangguan_bak' => 'required|in:Ya,Tidak',
            'catatan' => 'nullable|string',
        ]);

        $pemantauanNifas->update($data);
        Alert::success('Berhasil', 'Pemantauan Nifas berhasil diperbarui.');
        return redirect()->route('pemantauan-nifas.index');
    }

    public function destroy(PemantauanNifas $pemantauanNifas)
    {
        $pemantauanNifas->delete();
        return response()->json(['status' => 'success', 'message' => 'Pemantauan Nifas berhasil dihapus.']);
    }
}
