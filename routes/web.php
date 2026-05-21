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
use App\Http\Controllers\KunjunganAncController;
use App\Http\Controllers\HasilLabIbuController;
use App\Http\Controllers\BayiBaruLahirController;
use App\Http\Controllers\ImunisasiAnakController;
use App\Http\Controllers\TumbuhKembangController;
use App\Http\Controllers\PerkembanganSidtkController;
use App\Http\Controllers\MpasiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KonsultasiOnlineController;
use App\Http\Controllers\ArtikelEdukasiController;
use App\Http\Controllers\KategoriArtikelController;

Route::get('/', [HomepageController::class,'index'])->name('homepage');
Route::get('/about', [HomepageController::class,'about'])->name('homepage.about');
Route::get('/layanan', [HomepageController::class,'layanan'])->name('homepage.layanan');
Route::get('/contact', [HomepageController::class,'contact'])->name('homepage.contact');
Route::get('/artikel', [HomepageController::class,'artikel'])->name('homepage.artikel');

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'proseslogin')->name('proseslogin');
    Route::get('/logout', 'logout')->name('logout');
});

// Akses Publik Telemedisin (Guest)
Route::get('/konsultasi-publik', [KonsultasiOnlineController::class, 'guestForm'])->name('konsultasi-publik.form');
Route::post('/konsultasi-publik', [KonsultasiOnlineController::class, 'guestLogin'])->name('konsultasi-publik.login');

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
    Route::resource('kunjungan-anc', KunjunganAncController::class)->parameters(['kunjungan-anc' => 'kunjunganAnc']);
    Route::resource('hasil-lab-ibu', HasilLabIbuController::class)->parameters(['hasil-lab-ibu' => 'hasilLabIbu']);
    Route::resource('bayi-baru-lahir', BayiBaruLahirController::class)->parameters(['bayi-baru-lahir' => 'bayiBaruLahir']);
    Route::resource('imunisasi-anak', ImunisasiAnakController::class)->parameters(['imunisasi-anak' => 'imunisasiAnak']);
    Route::resource('tumbuh-kembang', TumbuhKembangController::class)->parameters(['tumbuh-kembang' => 'tumbuhKembang']);
    Route::resource('perkembangan-sidtk', PerkembanganSidtkController::class)->parameters(['perkembangan-sidtk' => 'perkembanganSidtk']);
    Route::resource('mpasi', MpasiController::class);
    Route::get('konsultasi-online/check-updates', [KonsultasiOnlineController::class, 'checkUpdates'])->name('konsultasi-online.check-updates');
    Route::get('konsultasi-online/{konsultasiOnline}/messages', [KonsultasiOnlineController::class, 'fetchMessages'])->name('konsultasi-online.messages');
    Route::post('konsultasi-online/{konsultasiOnline}/reply', [KonsultasiOnlineController::class, 'reply'])->name('konsultasi-online.reply');
    Route::resource('konsultasi-online', KonsultasiOnlineController::class)->parameters(['konsultasi-online' => 'konsultasiOnline']);

    // Manajemen Homepage
    Route::resource('artikel-edukasi', ArtikelEdukasiController::class)->parameters(['artikel-edukasi' => 'artikelEdukasi']);
    Route::resource('kategori-artikel', KategoriArtikelController::class)->parameters(['kategori-artikel' => 'kategoriArtikel']);

    // Laporan & Monitoring Routes
    Route::get('/laporan/statistik', [LaporanController::class, 'statistik'])->name('laporan.statistik');
    Route::get('/laporan/monitoring-faskes', [LaporanController::class, 'monitoringFaskes'])->name('laporan.monitoring-faskes');
    Route::get('/laporan/monitoring-buku-kia', [LaporanController::class, 'monitoringBukuKia'])->name('laporan.monitoring-buku-kia');
    Route::get('/laporan/monitoring-imunisasi', [LaporanController::class, 'monitoringImunisasi'])->name('laporan.monitoring-imunisasi');
    Route::get('/laporan/monitoring-gizi-balita', [LaporanController::class, 'monitoringGiziBalita'])->name('laporan.monitoring-gizi-balita');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
}); 
