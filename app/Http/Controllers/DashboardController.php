<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProfilIbu;
use App\Models\ProfilAnak;
use App\Models\BukuKia;
use App\Models\FasilitasKesehatan;
use App\Models\KunjunganAnc;
use App\Models\Dokumen;
use App\Models\Pembiayaan;
use App\Models\ProfilSuami;
use App\Models\PemantauanNifas;
use App\Models\KbPascaSalin;
use App\Models\WilayaDinkes;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roleName = $user->role ? strtolower($user->role->nama_role) : 'pengguna';
        
        $data = [
            'role' => $roleName,
            'user' => $user,
        ];

        if ($roleName === 'administrator' || $roleName === 'admin') {
            $data['total_users'] = User::count();
            $data['total_ibu'] = ProfilIbu::count();
            $data['total_anak'] = ProfilAnak::count();
            $data['total_buku_kia'] = BukuKia::count();
            $data['total_faskes'] = FasilitasKesehatan::count();
            $data['recent_users'] = User::with('role')->latest()->take(5)->get();
            $data['recent_buku'] = BukuKia::with('profilIbu')->latest()->take(5)->get();
            
        } elseif ($roleName === 'dinas kesehatan') {
            $data['total_faskes'] = FasilitasKesehatan::count();
            $data['total_ibu'] = ProfilIbu::count();
            $data['total_anak'] = ProfilAnak::count();
            $data['total_buku_kia'] = BukuKia::count();
            $data['recent_activities'] = BukuKia::with(['profilIbu', 'fasilitasKesehatan'])->latest()->take(5)->get();
            
        } elseif ($roleName === 'nakes') {
            $faskesId = $user->fasilitas_kesehatan_id;
            if ($faskesId) {
                $data['total_ibu'] = ProfilIbu::where('fasilitas_kesehatan_id', $faskesId)->count();
                $data['total_anak'] = ProfilAnak::whereHas('bukuKia', function ($q) use ($faskesId) {
                    $q->where('fasilitas_kesehatan_id', $faskesId);
                })->count();
                $data['total_buku_kia'] = BukuKia::where('fasilitas_kesehatan_id', $faskesId)->count();
                $data['recent_kunjungan'] = KunjunganAnc::where('fasilitas_kesehatan_id', $faskesId)
                    ->with('bukuKia.profilIbu')
                    ->latest()
                    ->take(5)
                    ->get();
                $data['my_faskes'] = FasilitasKesehatan::find($faskesId);
            } else {
                $data['total_ibu'] = ProfilIbu::count();
                $data['total_anak'] = ProfilAnak::count();
                $data['total_buku_kia'] = BukuKia::count();
                $data['recent_kunjungan'] = KunjunganAnc::with('bukuKia.profilIbu')->latest()->take(5)->get();
                $data['my_faskes'] = null;
            }
            
        } elseif ($roleName === 'ibu hamil') {
            $profilIbu = ProfilIbu::where('user_id', $user->id)->first();
            $bukuKia = null;
            $profilSuami = null;
            $children = collect();
            $ancVisits = collect();
            $pemantauanNifas = collect();
            $kbPascaSalin = collect();
            $dokumenList = collect();
            $pembiayaanList = collect();

            if ($profilIbu) {
                $bukuKia = BukuKia::where('profil_ibu_id', $profilIbu->id)->first();
                $profilSuami = ProfilSuami::where('profil_ibu_id', $profilIbu->id)->first();
                $pembiayaanList = Pembiayaan::where('profil_ibu_id', $profilIbu->id)->get();
                
                if ($bukuKia) {
                    $children = ProfilAnak::where('buku_kia_id', $bukuKia->id)->get();
                    $ancVisits = KunjunganAnc::where('buku_kia_id', $bukuKia->id)
                        ->with('fasilitasKesehatan')
                        ->latest()
                        ->get();
                    $pemantauanNifas = PemantauanNifas::where('buku_kia_id', $bukuKia->id)->latest()->get();
                    $kbPascaSalin = KbPascaSalin::where('buku_kia_id', $bukuKia->id)->latest()->get();
                    $dokumenList = Dokumen::where('buku_kia_id', $bukuKia->id)->latest()->get();
                }
            }

            $data['profil_ibu'] = $profilIbu;
            $data['buku_kia'] = $bukuKia;
            $data['profil_suami'] = $profilSuami;
            $data['children'] = $children;
            $data['anc_visits'] = $ancVisits;
            $data['pemantauan_nifas'] = $pemantauanNifas;
            $data['kb_pasca_salin'] = $kbPascaSalin;
            $data['dokumen_list'] = $dokumenList;
            $data['pembiayaan_list'] = $pembiayaanList;
        }

        return view('layouts.dashboard.index', $data);
    }
}

