<?php

namespace App\Http\Controllers;

use App\Models\KunjunganAnc;
use App\Models\BukuKia;
use App\Models\User;
use App\Models\FasilitasKesehatan;
use App\DataTables\KunjunganAncsDataTable;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

class KunjunganAncController extends Controller
{
    public function index(KunjunganAncsDataTable $dataTable)
    {
        return $dataTable->render('pages.kunjungan_anc.index');
    }

    public function create(Request $request)
    {
        $bukuKias = BukuKia::with('profilIbu')->get();
        $nakes = User::whereIn('roles_id', [3, 5])->get();
        $faskes = FasilitasKesehatan::all();
        $selectedBukuKiaId = $request->query('buku_kia_id');

        return view('pages.kunjungan_anc.create', compact('bukuKias', 'nakes', 'faskes', 'selectedBukuKiaId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'buku_kia_id' => 'required|exists:buku_kias,id',
            'fasilitas_kesehatan_id' => 'required|exists:fasilitas_kesehatans,id',
            'trimester' => 'required|integer|min:1|max:3',
            'kunjungan_ke' => 'required|integer|min:1|max:10',
            'tanggal_kunjungan' => 'required|date',
            'berat_badan' => 'required|numeric|min:30|max:150',
            'tekanan_darah_sistolik' => 'required|numeric|min:70|max:200',
            'tekanan_darah_diastolik' => 'required|numeric|min:40|max:130',
            'tinggi_fundus_cm' => 'nullable|numeric|min:0|max:50',
            'lila_cm' => 'required|numeric|min:10|max:50',
            'denyut_jantung_janin' => 'nullable|string|max:255',
            'letak_janin' => 'nullable|string|max:255',
            'status_tt' => 'nullable|string|max:255',
            'usg_dilakukan' => 'required|in:Ya,Tidak',
            'hasil_usg' => 'nullable|string|max:255',
            'skrining_jiwa' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'nakes_id' => 'required|exists:users,id',
        ]);

        KunjunganAnc::create($validated);

        Alert::success('Berhasil', 'Kunjungan ANC berhasil dicatat.');
        return redirect()->route('kunjungan-anc.index');
    }

    public function edit(KunjunganAnc $kunjunganAnc)
    {
        $bukuKias = BukuKia::with('profilIbu')->get();
        $nakes = User::whereIn('roles_id', [3, 5])->get();
        $faskes = FasilitasKesehatan::all();

        return view('pages.kunjungan_anc.edit', compact('kunjunganAnc', 'bukuKias', 'nakes', 'faskes'));
    }

    public function update(Request $request, KunjunganAnc $kunjunganAnc)
    {
        $validated = $request->validate([
            'buku_kia_id' => 'required|exists:buku_kias,id',
            'fasilitas_kesehatan_id' => 'required|exists:fasilitas_kesehatans,id',
            'trimester' => 'required|integer|min:1|max:3',
            'kunjungan_ke' => 'required|integer|min:1|max:10',
            'tanggal_kunjungan' => 'required|date',
            'berat_badan' => 'required|numeric|min:30|max:150',
            'tekanan_darah_sistolik' => 'required|numeric|min:70|max:200',
            'tekanan_darah_diastolik' => 'required|numeric|min:40|max:130',
            'tinggi_fundus_cm' => 'nullable|numeric|min:0|max:50',
            'lila_cm' => 'required|numeric|min:10|max:50',
            'denyut_jantung_janin' => 'nullable|string|max:255',
            'letak_janin' => 'nullable|string|max:255',
            'status_tt' => 'nullable|string|max:255',
            'usg_dilakukan' => 'required|in:Ya,Tidak',
            'hasil_usg' => 'nullable|string|max:255',
            'skrining_jiwa' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'nakes_id' => 'required|exists:users,id',
        ]);

        $kunjunganAnc->update($validated);

        Alert::success('Berhasil', 'Kunjungan ANC berhasil diperbarui.');
        return redirect()->route('kunjungan-anc.index');
    }

    public function destroy(KunjunganAnc $kunjunganAnc)
    {
        $kunjunganAnc->delete();
        return response()->json(['status' => 'success', 'message' => 'Catatan Kunjungan ANC berhasil dihapus.']);
    }
}
