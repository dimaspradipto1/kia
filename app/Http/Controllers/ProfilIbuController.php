<?php

namespace App\Http\Controllers;

use App\Models\ProfilIbu;
use App\Models\User;
use App\Models\FasilitasKesehatan;
use App\Http\Requests\ProfilIbuRequest;
use App\DataTables\ProfileIbuDataTable;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilIbuController extends Controller
{
    public function index(ProfileIbuDataTable $dataTable)
    {
        return $dataTable->render('pages.profil_ibu.index');
    }

    public function create()
    {
        $user = auth()->user();
        $isIbuHamil = $user && $user->role && strtolower($user->role->nama_role) === 'ibu hamil';

        if ($isIbuHamil) {
            $existing = ProfilIbu::where('user_id', $user->id)->first();
            if ($existing) {
                Alert::info('Info', 'Anda sudah memiliki Profil Ibu. Silakan perbarui data profil jika diperlukan.');
                return redirect()->route('profil-ibu.edit', $existing->id);
            }
        }

        $faskes = FasilitasKesehatan::where('is_active', true)->orderBy('nama_faskes')->get();
        return view('pages.profil_ibu.create', [
            'faskes' => $faskes,
            'isIbuHamil' => $isIbuHamil,
        ]);
    }

    public function store(ProfilIbuRequest $request)
    {
        $data = $request->validated();
        $authUser = auth()->user();
        $isIbuHamil = $authUser && $authUser->role && strtolower($authUser->role->nama_role) === 'ibu hamil';

        if ($isIbuHamil) {
            $data['user_id'] = $authUser->id;
            $faskes = FasilitasKesehatan::find($request->fasilitas_kesehatan_id);
            $authUser->update([
                'fasilitas_kesehatan_id' => $request->fasilitas_kesehatan_id,
                'wilaya_dinkes_id' => $faskes ? $faskes->wilayah_id : $authUser->wilaya_dinkes_id,
            ]);
            $successMsg = 'Profil Ibu berhasil disimpan.';
        } else {
            // Didaftarkan oleh Kader / Nakes / Admin -> Buat akun User untuk Ibu Hamil
            $email = $request->filled('email') ? $request->email : $request->nik . '@kia.id';
            $password = $request->filled('password') ? $request->password : $request->nik;

            $user = User::where('email', $email)->first();
            if (!$user) {
                $faskes = FasilitasKesehatan::find($request->fasilitas_kesehatan_id);
                $user = User::create([
                    'name' => $request->nama_lengkap,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'roles_id' => 4, // Ibu Hamil
                    'fasilitas_kesehatan_id' => $request->fasilitas_kesehatan_id,
                    'wilaya_dinkes_id' => $faskes ? $faskes->wilayah_id : null,
                    'is_active' => true,
                ]);
            }

            $data['user_id'] = $user->id;
            $successMsg = "Profil Ibu berhasil ditambahkan. Akun login dibuat: Email/NIK ({$email} / {$request->nik}), Sandi: {$password}.";
        }

        unset($data['email'], $data['password']);

        ProfilIbu::create($data);

        Alert::success('Berhasil', $successMsg);
        return redirect()->route('profil-ibu.index');
    }

    public function show(ProfilIbu $profilIbu)
    {
        return view('pages.profil_ibu.show', ['profilIbu' => $profilIbu]);
    }

    public function edit(ProfilIbu $profilIbu)
    {
        $authUser = auth()->user();
        $isIbuHamil = $authUser && $authUser->role && strtolower($authUser->role->nama_role) === 'ibu hamil';
        if ($isIbuHamil && $profilIbu->user_id !== $authUser->id) {
            Alert::error('Akses Ditolak', 'Anda hanya dapat mengedit profil Anda sendiri.');
            return redirect()->route('profil-ibu.index');
        }

        $faskes = FasilitasKesehatan::where('is_active', true)->orderBy('nama_faskes')->get();
        return view('pages.profil_ibu.edit', [
            'profilIbu' => $profilIbu,
            'faskes' => $faskes,
            'isIbuHamil' => $isIbuHamil,
        ]);
    }

    public function update(ProfilIbuRequest $request, ProfilIbu $profilIbu)
    {
        $authUser = auth()->user();
        $isIbuHamil = $authUser && $authUser->role && strtolower($authUser->role->nama_role) === 'ibu hamil';
        if ($isIbuHamil && $profilIbu->user_id !== $authUser->id) {
            Alert::error('Akses Ditolak', 'Anda hanya dapat memperbarui profil Anda sendiri.');
            return redirect()->route('profil-ibu.index');
        }

        $data = $request->validated();
        unset($data['email'], $data['password']);

        $profilIbu->update($data);

        // Selaraskan data user terkait (nama & faskes)
        if ($profilIbu->user) {
            $faskes = FasilitasKesehatan::find($request->fasilitas_kesehatan_id);
            $profilIbu->user->update([
                'name' => $request->nama_lengkap,
                'fasilitas_kesehatan_id' => $request->fasilitas_kesehatan_id,
                'wilaya_dinkes_id' => $faskes ? $faskes->wilayah_id : $profilIbu->user->wilaya_dinkes_id,
            ]);
        }

        Alert::success('Berhasil', 'Profil Ibu berhasil diperbarui.');
        return redirect()->route('profil-ibu.index');
    }

    public function destroy(ProfilIbu $profilIbu)
    {
        $authUser = auth()->user();
        if ($authUser && $authUser->role && strtolower($authUser->role->nama_role) === 'ibu hamil') {
            Alert::error('Akses Ditolak', 'Ibu Hamil tidak dapat menghapus profil.');
            return redirect()->route('profil-ibu.index');
        }

        $profilIbu->delete();
        Alert::success('Berhasil', 'Profil Ibu berhasil dihapus.');
        return redirect()->route('profil-ibu.index');
    }
}
