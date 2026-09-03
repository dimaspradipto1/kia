<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Models\User;
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
        $credentials = $request->only('email', 'password');

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

        Alert::error('Gagal Masuk', 'Email atau password salah.');
        return redirect()->back();
    }

    public function register()
    {
        return view('layouts.auth.register');
    }

    public function registerproses(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles_id' => 4, // Ibu Hamil
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        Alert::success('Registrasi Berhasil', 'Selamat datang, ' . $user->name);

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
