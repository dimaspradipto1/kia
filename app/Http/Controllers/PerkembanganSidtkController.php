<?php

namespace App\Http\Controllers;

use App\Models\PerkembanganSidtk;
use App\Models\ProfilAnak;
use App\Models\User;
use App\DataTables\PerkembanganSidtkDataTable;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

class PerkembanganSidtkController extends Controller
{
    public function index(PerkembanganSidtkDataTable $dataTable)
    {
        return $dataTable->render('pages.perkembangan_sidtk.index');
    }

    public function create(Request $request)
    {
        $profilAnaks = ProfilAnak::with('bukuKia.profilIbu')->get();
        $nakes       = User::where('roles_id', 3)->get();
        $domains     = PerkembanganSidtk::DOMAINS;
        $hasilOptions   = PerkembanganSidtk::HASIL;
        $tindakLanjuts  = PerkembanganSidtk::TINDAK_LANJUT;
        $selectedProfilAnakId = $request->query('profil_anak_id');

        return view('pages.perkembangan_sidtk.create', compact(
            'profilAnaks', 'nakes', 'domains', 'hasilOptions', 'tindakLanjuts', 'selectedProfilAnakId'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'profil_anak_id'  => 'required|exists:profil_anaks,id',
            'nakes_id'        => 'required|exists:users,id',
            'tanggal_skrining'=> 'required|date',
            'usia_bulan'      => 'required|integer|min:0|max:72',
            'domain'          => 'required|string|max:100',
            'hasil'           => 'required|string|max:50',
            'tindak_lanjut'   => 'required|string|max:100',
        ]);

        PerkembanganSidtk::create($validated);

        Alert::success('Berhasil', 'Data perkembangan SIDTK berhasil disimpan.');
        return redirect()->route('perkembangan-sidtk.index');
    }

    public function edit(PerkembanganSidtk $perkembanganSidtk)
    {
        $profilAnaks = ProfilAnak::with('bukuKia.profilIbu')->get();
        $nakes       = User::where('roles_id', 3)->get();
        $domains     = PerkembanganSidtk::DOMAINS;
        $hasilOptions   = PerkembanganSidtk::HASIL;
        $tindakLanjuts  = PerkembanganSidtk::TINDAK_LANJUT;

        return view('pages.perkembangan_sidtk.edit', compact(
            'perkembanganSidtk', 'profilAnaks', 'nakes', 'domains', 'hasilOptions', 'tindakLanjuts'
        ));
    }

    public function update(Request $request, PerkembanganSidtk $perkembanganSidtk)
    {
        $validated = $request->validate([
            'profil_anak_id'  => 'required|exists:profil_anaks,id',
            'nakes_id'        => 'required|exists:users,id',
            'tanggal_skrining'=> 'required|date',
            'usia_bulan'      => 'required|integer|min:0|max:72',
            'domain'          => 'required|string|max:100',
            'hasil'           => 'required|string|max:50',
            'tindak_lanjut'   => 'required|string|max:100',
        ]);

        $perkembanganSidtk->update($validated);

        Alert::success('Berhasil', 'Data perkembangan SIDTK berhasil diperbarui.');
        return redirect()->route('perkembangan-sidtk.index');
    }

    public function destroy(PerkembanganSidtk $perkembanganSidtk)
    {
        $perkembanganSidtk->delete();
        return response()->json(['status' => 'success', 'message' => 'Data perkembangan berhasil dihapus.']);
    }
}
