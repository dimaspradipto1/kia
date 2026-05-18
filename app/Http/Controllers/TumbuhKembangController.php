<?php

namespace App\Http\Controllers;

use App\Models\TumbuhKembang;
use App\Models\ProfilAnak;
use App\Models\FasilitasKesehatan;
use App\Models\User;
use App\DataTables\TumbuhKembangDataTable;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

class TumbuhKembangController extends Controller
{
    private const STATUS_GIZI = [
        'Gizi Buruk', 'Gizi Kurang', 'Gizi Baik', 'Gizi Lebih', 'Obesitas',
    ];

    private const STATUS_TB = [
        'Sangat Pendek', 'Pendek', 'Normal', 'Tinggi',
    ];

    private const STATUS_STUNTING = [
        'Tidak Stunting', 'Stunting', 'Stunting Berat',
    ];

    public function index(TumbuhKembangDataTable $dataTable)
    {
        return $dataTable->render('pages.tumbuh_kembang.index');
    }

    public function create(Request $request)
    {
        $profilAnaks = ProfilAnak::with('bukuKia.profilIbu')->get();
        $faskes      = FasilitasKesehatan::all();
        $nakes       = User::where('roles_id', 3)->get();
        $statusGizi  = self::STATUS_GIZI;
        $statusTb    = self::STATUS_TB;
        $statusStunting = self::STATUS_STUNTING;
        $selectedProfilAnakId = $request->query('profil_anak_id');

        return view('pages.tumbuh_kembang.create', compact(
            'profilAnaks', 'faskes', 'nakes',
            'statusGizi', 'statusTb', 'statusStunting', 'selectedProfilAnakId'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'profil_anak_id'         => 'required|exists:profil_anaks,id',
            'fasilitas_kesehatan_id' => 'required|exists:fasilitas_kesehatans,id',
            'nakes_id'               => 'required|exists:users,id',
            'tanggal_ukur'           => 'required|date',
            'usia_bulan'             => 'required|integer|min:0|max:60',
            'berat_badan'            => 'required|numeric|min:0.5|max:50',
            'tinggi_badan'           => 'required|numeric|min:20|max:120',
            'lingkar_kepala'         => 'nullable|numeric|min:20|max:60',
            'lila_cm'                => 'nullable|numeric|min:5|max:30',
            'status_gizi_bb_u'       => 'required|string|max:50',
            'status_gizi_tb_u'       => 'required|string|max:50',
            'status_gizi_bb_tb'      => 'required|string|max:50',
            'status_stunting'        => 'nullable|string|max:50',
            'catatan'                => 'nullable|string',
        ]);

        TumbuhKembang::create($validated);

        Alert::success('Berhasil', 'Data tumbuh kembang berhasil disimpan.');
        return redirect()->route('tumbuh-kembang.index');
    }

    public function edit(TumbuhKembang $tumbuhKembang)
    {
        $profilAnaks = ProfilAnak::with('bukuKia.profilIbu')->get();
        $faskes      = FasilitasKesehatan::all();
        $nakes       = User::where('roles_id', 3)->get();
        $statusGizi  = self::STATUS_GIZI;
        $statusTb    = self::STATUS_TB;
        $statusStunting = self::STATUS_STUNTING;

        return view('pages.tumbuh_kembang.edit', compact(
            'tumbuhKembang', 'profilAnaks', 'faskes', 'nakes',
            'statusGizi', 'statusTb', 'statusStunting'
        ));
    }

    public function update(Request $request, TumbuhKembang $tumbuhKembang)
    {
        $validated = $request->validate([
            'profil_anak_id'         => 'required|exists:profil_anaks,id',
            'fasilitas_kesehatan_id' => 'required|exists:fasilitas_kesehatans,id',
            'nakes_id'               => 'required|exists:users,id',
            'tanggal_ukur'           => 'required|date',
            'usia_bulan'             => 'required|integer|min:0|max:60',
            'berat_badan'            => 'required|numeric|min:0.5|max:50',
            'tinggi_badan'           => 'required|numeric|min:20|max:120',
            'lingkar_kepala'         => 'nullable|numeric|min:20|max:60',
            'lila_cm'                => 'nullable|numeric|min:5|max:30',
            'status_gizi_bb_u'       => 'required|string|max:50',
            'status_gizi_tb_u'       => 'required|string|max:50',
            'status_gizi_bb_tb'      => 'required|string|max:50',
            'status_stunting'        => 'nullable|string|max:50',
            'catatan'                => 'nullable|string',
        ]);

        $tumbuhKembang->update($validated);

        Alert::success('Berhasil', 'Data tumbuh kembang berhasil diperbarui.');
        return redirect()->route('tumbuh-kembang.index');
    }

    public function destroy(TumbuhKembang $tumbuhKembang)
    {
        $tumbuhKembang->delete();
        return response()->json(['status' => 'success', 'message' => 'Data tumbuh kembang berhasil dihapus.']);
    }
}
