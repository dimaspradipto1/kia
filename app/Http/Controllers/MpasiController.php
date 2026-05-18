<?php

namespace App\Http\Controllers;

use App\Models\Mpasi;
use App\Models\ProfilAnak;
use App\Models\User;
use App\DataTables\MpasiDataTable;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

class MpasiController extends Controller
{
    public function index(MpasiDataTable $dataTable)
    {
        return $dataTable->render('pages.mpasi.index');
    }

    public function create(Request $request)
    {
        $profilAnaks   = ProfilAnak::with('bukuKia.profilIbu')->get();
        $nakes         = User::where('roles_id', 3)->get();
        $jenisMpasi    = Mpasi::JENIS_MPASI;
        $frekuensiList = Mpasi::FREKUENSI;
        $teksturList   = Mpasi::TEKSTUR;
        $selectedProfilAnakId = $request->query('profil_anak_id');

        return view('pages.mpasi.create', compact(
            'profilAnaks', 'nakes', 'jenisMpasi', 'frekuensiList', 'teksturList', 'selectedProfilAnakId'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'profil_anak_id'      => 'required|exists:profil_anaks,id',
            'nakes_id'            => 'required|exists:users,id',
            'tanggal_mulai_mpasi' => 'required|date',
            'jenis_mpasi'         => 'required|string|max:100',
            'frekuensi'           => 'required|string|max:100',
            'tekstur'             => 'required|string|max:100',
            'catatan_gizi'        => 'required|string|max:500',
            'dibuat_pada'         => 'required|date',
        ]);

        Mpasi::create($validated);

        Alert::success('Berhasil', 'Data MPASI berhasil disimpan.');
        return redirect()->route('mpasi.index');
    }

    public function edit(Mpasi $mpasi)
    {
        $profilAnaks   = ProfilAnak::with('bukuKia.profilIbu')->get();
        $nakes         = User::where('roles_id', 3)->get();
        $jenisMpasi    = Mpasi::JENIS_MPASI;
        $frekuensiList = Mpasi::FREKUENSI;
        $teksturList   = Mpasi::TEKSTUR;

        return view('pages.mpasi.edit', compact(
            'mpasi', 'profilAnaks', 'nakes', 'jenisMpasi', 'frekuensiList', 'teksturList'
        ));
    }

    public function update(Request $request, Mpasi $mpasi)
    {
        $validated = $request->validate([
            'profil_anak_id'      => 'required|exists:profil_anaks,id',
            'nakes_id'            => 'required|exists:users,id',
            'tanggal_mulai_mpasi' => 'required|date',
            'jenis_mpasi'         => 'required|string|max:100',
            'frekuensi'           => 'required|string|max:100',
            'tekstur'             => 'required|string|max:100',
            'catatan_gizi'        => 'required|string|max:500',
            'dibuat_pada'         => 'required|date',
        ]);

        $mpasi->update($validated);

        Alert::success('Berhasil', 'Data MPASI berhasil diperbarui.');
        return redirect()->route('mpasi.index');
    }

    public function destroy(Mpasi $mpasi)
    {
        $mpasi->delete();
        return response()->json(['status' => 'success', 'message' => 'Data MPASI berhasil dihapus.']);
    }
}
