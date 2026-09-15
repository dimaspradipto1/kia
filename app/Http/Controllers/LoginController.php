<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Models\User;
use App\Models\ProfilIbu;
use App\Models\FasilitasKesehatan;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function login(UserDataTable $dataTable)
    {
        return $dataTable->render('layouts.auth.login');
    }

    public function proseslogin(LoginRequest $request)
    {
        $loginInput = trim($request->input('email'));
        $password = $request->input('password');

        // Cek apakah login menggunakan format Email atau NIK
        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $loginInput, 'password' => $password];
        } else {
            // Cari profil ibu dengan NIK tersebut
            $profilIbu = ProfilIbu::where('nik', $loginInput)->first();
            if ($profilIbu && $profilIbu->user) {
                $credentials = ['email' => $profilIbu->user->email, 'password' => $password];
            } else {
                $credentials = ['email' => $loginInput, 'password' => $password];
            }
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                Alert::error('Akses Ditolak', 'Akun Anda tidak aktif.');
                return redirect()->back();
            }

            $request->session()->regenerate();
            Alert::success('Berhasil Masuk', 'Selamat datang kembali, ' . $user->name);

            return redirect()->route('dashboard');
        }

        Alert::error('Gagal Masuk', 'Email/NIK atau password salah.');
        return redirect()->back()->withInput($request->only('email'));
    }

    public function register()
    {
        $faskes = FasilitasKesehatan::where('is_active', true)->orderBy('nama_faskes')->get();
        return view('layouts.auth.register', compact('faskes'));
    }

    public function registerproses(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16|unique:profil_ibus,nik',
            'email' => 'required|string|email|max:255|unique:users',
            'nomor_wa' => 'nullable|string|max:25',
            'fasilitas_kesehatan_id' => 'required|exists:fasilitas_kesehatans,id',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.digits' => 'NIK harus berjumlah 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar dalam sistem.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'fasilitas_kesehatan_id.required' => 'Fasilitas Kesehatan wajib dipilih.',
            'fasilitas_kesehatan_id.exists' => 'Fasilitas Kesehatan tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $faskes = FasilitasKesehatan::find($request->fasilitas_kesehatan_id);
        $ibuRoleId = \App\Models\Role::whereRaw('LOWER(nama_role) = ?', ['ibu hamil'])->value('id') ?? 4;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles_id' => $ibuRoleId,
            'fasilitas_kesehatan_id' => $request->fasilitas_kesehatan_id,
            'wilaya_dinkes_id' => $faskes ? $faskes->wilayah_id : null,
            'is_active' => true,
        ]);

        ProfilIbu::create([
            'user_id' => $user->id,
            'fasilitas_kesehatan_id' => $request->fasilitas_kesehatan_id,
            'nik' => $request->nik,
            'nama_lengkap' => $request->name,
            'nomor_wa' => $request->nomor_wa ?? null,
            'tempat_lahir' => '-',
            'tanggal_lahir' => '1995-01-01',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        Alert::success('Registrasi Berhasil', 'Selamat datang, ' . $user->name . '. Akun Anda dan Profil Pasien telah terdaftar.');

        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Alert::success('Berhasil Keluar', 'Anda telah keluar dari sistem.');
        return redirect()->route('login');
    }
}
