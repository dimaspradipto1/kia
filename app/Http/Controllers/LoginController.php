<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function login()
    {
        return view('layouts.auth.login');
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

            return redirect()->intended('/dashboard');
        }

        Alert::error('Gagal Masuk', 'Email atau password salah.');
        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        Alert::success('Berhasil Keluar', 'Anda telah keluar dari sistem.');
        return redirect()->route('login');
    }
}
