<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FasilitasKesehatanController;
use App\Http\Controllers\ProfilIbuController;
use App\Http\Controllers\ProfilSuamiController;
use App\Http\Controllers\ProfilAnakController;
use App\Http\Controllers\BukuKiaController;
use App\Http\Controllers\PembiayaanController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\WilayaDinkesController;
use App\Http\Controllers\KbPascaSalinController;
use App\Http\Controllers\PemantauanNifasController;

Route::get('/', [HomepageController::class,'index'])->name('homepage');

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'proseslogin')->name('proseslogin');
    Route::get('/logout', 'logout')->name('logout');
});

Route::middleware(['auth', 'checkrole'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('users/export-template', [UserController::class, 'exportTemplate'])->name('users.export-template');
    Route::post('users/import', [UserController::class, 'import'])->name('users.import');
    Route::post('users/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.update-password');
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('fasilitas-kesehatan', FasilitasKesehatanController::class)->parameters(['fasilitas-kesehatan' => 'fasilitasKesehatan']);
    Route::resource('profil-ibu', ProfilIbuController::class)->parameters(['profil-ibu' => 'profilIbu']);
    Route::resource('profil-suami', ProfilSuamiController::class)->parameters(['profil-suami' => 'profilSuami']);
    Route::resource('profil-anak', ProfilAnakController::class)->parameters(['profil-anak' => 'profilAnak']);
    Route::resource('buku-kia', BukuKiaController::class)->parameters(['buku-kia' => 'bukuKia']);
    Route::resource('pembiayaan', PembiayaanController::class);
    Route::resource('dokumen', DokumenController::class)->parameters(['dokumen' => 'dokumen']);
    Route::patch('dokumen/{dokumen}/status', [DokumenController::class, 'updateStatus'])->name('dokumen.update-status');
    Route::resource('wilaya-dinkes', WilayaDinkesController::class)->parameters(['wilaya-dinkes' => 'wilayaDinke']);
    Route::resource('kb-pasca-salin', KbPascaSalinController::class)->parameters(['kb-pasca-salin' => 'kbPascaSalin']);
    Route::resource('pemantauan-nifas', PemantauanNifasController::class)->parameters(['pemantauan-nifas' => 'pemantauanNifas']);
}); 
