<?php

namespace App\Http\Controllers;

use App\Models\ImunisasiAnak;
use App\Models\ProfilAnak;
use App\Models\FasilitasKesehatan;
use App\Models\User;
use App\DataTables\ImunisasiAnakDataTable;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

class ImunisasiAnakController extends Controller
{
    // Daftar jenis imunisasi standar program pemerintah
    private const JENIS_IMUNISASI = [
        'BCG', 'Hepatitis B', 'Polio', 'DPT-HB-HIB',
        'Campak', 'MMR', 'HIB', 'PCV', 'Rotavirus', 'Varisela',
        'DT', 'Td', 'HPV', 'Japanese Encephalitis',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(ImunisasiAnakDataTable $dataTable)
    {
        return $dataTable->render('pages.imunisasi_anak.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $profilAnaks  = ProfilAnak::with('bukuKia.profilIbu')->get();
        $faskes       = FasilitasKesehatan::all();
        $nakes        = User::where('roles_id', 3)->get();
        $jenisOptions = self::JENIS_IMUNISASI;
        $selectedProfilAnakId = $request->query('profil_anak_id');

        return view('pages.imunisasi_anak.create', compact(
            'profilAnaks', 'faskes', 'nakes', 'jenisOptions', 'selectedProfilAnakId'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'profil_anak_id'        => 'required|exists:profil_anaks,id',
            'fasilitas_kesehatan_id'=> 'required|exists:fasilitas_kesehatans,id',
            'nakes_id'              => 'required|exists:users,id',
            'jenis_imunisasi'       => 'required|string|max:100',
            'dosis_ke'              => 'required|integer|min:1|max:10',
            'tanggal_pemberian'     => 'required|date',
            'batch_vaksin'          => 'nullable|string|max:100',
            'efek_samping'          => 'nullable|string|max:255',
        ]);

        if (empty($validated['batch_vaksin'])) {
            $validated['batch_vaksin'] = '-';
        }
        if (empty($validated['efek_samping'])) {
            $validated['efek_samping'] = 'Tidak Ada';
        }

        ImunisasiAnak::create($validated);

        Alert::success('Berhasil', 'Data imunisasi anak berhasil disimpan.');
        return redirect()->route('imunisasi-anak.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImunisasiAnak $imunisasiAnak)
    {
        $profilAnaks  = ProfilAnak::with('bukuKia.profilIbu')->get();
        $faskes       = FasilitasKesehatan::all();
        $nakes        = User::where('roles_id', 3)->get();
        $jenisOptions = self::JENIS_IMUNISASI;

        return view('pages.imunisasi_anak.edit', compact(
            'imunisasiAnak', 'profilAnaks', 'faskes', 'nakes', 'jenisOptions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImunisasiAnak $imunisasiAnak)
    {
        $validated = $request->validate([
            'profil_anak_id'        => 'required|exists:profil_anaks,id',
            'fasilitas_kesehatan_id'=> 'required|exists:fasilitas_kesehatans,id',
            'nakes_id'              => 'required|exists:users,id',
            'jenis_imunisasi'       => 'required|string|max:100',
            'dosis_ke'              => 'required|integer|min:1|max:10',
            'tanggal_pemberian'     => 'required|date',
            'batch_vaksin'          => 'nullable|string|max:100',
            'efek_samping'          => 'nullable|string|max:255',
        ]);

        if (empty($validated['batch_vaksin'])) {
            $validated['batch_vaksin'] = '-';
        }
        if (empty($validated['efek_samping'])) {
            $validated['efek_samping'] = 'Tidak Ada';
        }

        $imunisasiAnak->update($validated);

        Alert::success('Berhasil', 'Data imunisasi anak berhasil diperbarui.');
        return redirect()->route('imunisasi-anak.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImunisasiAnak $imunisasiAnak)
    {
        $imunisasiAnak->delete();
        return response()->json(['status' => 'success', 'message' => 'Data imunisasi berhasil dihapus.']);
    }
}
