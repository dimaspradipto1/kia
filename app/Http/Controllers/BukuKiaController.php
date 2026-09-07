<?php

namespace App\Http\Controllers;

use App\Models\BukuKia;
use App\Models\ProfilIbu;
use App\Models\FasilitasKesehatan;
use App\Http\Requests\BukuKiaRequest;
use App\DataTables\BukuKiaDataTable;
use RealRashid\SweetAlert\Facades\Alert;

class BukuKiaController extends Controller
{
    public function index(BukuKiaDataTable $dataTable)
    {
        $user = auth()->user();
        if ($user && $user->role && strtolower($user->role->nama_role) === 'ibu hamil') {
            $userAgent = request()->header('User-Agent');
            $isMobile = preg_match('/Mobile|Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i', $userAgent);
            
            if ($isMobile) {
                $profilIbu = ProfilIbu::where('user_id', $user->id)->first();
                if ($profilIbu) {
                    $bukuKia = BukuKia::where('profil_ibu_id', $profilIbu->id)->first();
                    if ($bukuKia) {
                        return redirect()->route('buku-kia.show', $bukuKia->id);
                    }
                }
            }
        }

        return $dataTable->render('pages.buku_kia.index');
    }

    public function create()
    {
        $authUser = auth()->user();
        $userRole = strtolower($authUser->role->nama_role ?? '');

        if (in_array($userRole, ['kader posyandu', 'kader', 'nakes']) && $authUser->fasilitas_kesehatan_id) {
            $ibu = ProfilIbu::orderByRaw("CASE WHEN fasilitas_kesehatan_id = " . intval($authUser->fasilitas_kesehatan_id) . " THEN 0 ELSE 1 END")
                ->orderBy('nama_lengkap')
                ->get();
            $faskes = FasilitasKesehatan::where('is_active', true)
                ->orderByRaw("CASE WHEN id = " . intval($authUser->fasilitas_kesehatan_id) . " THEN 0 ELSE 1 END")
                ->orderBy('nama_faskes')
                ->get();
        } else {
            $ibu = ProfilIbu::orderBy('nama_lengkap')->get();
            $faskes = FasilitasKesehatan::where('is_active', true)->orderBy('nama_faskes')->get();
        }

        return view('pages.buku_kia.create', compact('ibu', 'faskes'));
    }

    public function store(BukuKiaRequest $request)
    {
        $data = $request->validated();
        $data['qr_code'] = 'KIA-' . strtoupper(uniqid());
        BukuKia::create($data);
        Alert::success('Berhasil', 'Buku KIA berhasil ditambahkan.');
        return redirect()->route('buku-kia.index');
    }

    public function show(BukuKia $bukuKia)
    {
        $bukuKia->load([
            'profilIbu',
            'profilSuami',
            'profilAnak',
            'pembiayaans',
            'dokumens',
            'kbPascaSalins.nakes',
            'kbPascaSalins.fasilitasKesehatan',
            'pemantauanNifas.nakes',
            'kunjunganAncs.nakes',
            'kunjunganAncs.fasilitasKesehatan',
        ]);
        return view('pages.buku_kia.show', compact('bukuKia'));
    }

    public function edit(BukuKia $bukuKia)
    {
        $ibu    = ProfilIbu::all();
        $faskes = FasilitasKesehatan::all();
        return view('pages.buku_kia.edit', compact('bukuKia', 'ibu', 'faskes'));
    }

    public function update(BukuKiaRequest $request, BukuKia $bukuKia)
    {
        $bukuKia->update($request->validated());
        Alert::success('Berhasil', 'Buku KIA berhasil diperbarui.');
        return redirect()->route('buku-kia.index');
    }

    public function destroy(BukuKia $bukuKia)
    {
        $bukuKia->delete();
        return response()->json(['status' => 'success', 'message' => 'Buku KIA berhasil dihapus.']);
    }
}
