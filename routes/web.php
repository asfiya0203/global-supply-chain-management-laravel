<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\EkonomiController;
use App\Http\Controllers\UpdateHarianController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PerbandinganController;

Route::get('/', function () {
    return view('welcome');
});

// login dan daftar
Route::get('/login',[AuthController::class, 'showLogin'])->name('login');
Route::post('/login',[AuthController::class, 'login'])->name('login.auth');

Route::get('/register',[AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register.store');

// Admin
Route::get('/admin', [AdminController::class, 'showAdmin'])->name('dashboard_admin');
Route::get('/admin', [AdminController::class, 'dashboard'])->name('dashboard_admin');

// API dashboard pengguna
Route::get('/dashboard', [HalamanController::class, 'dashboard'])->name('dashboard');
Route::get('/api/kurs/grafik/{negara_id}', [HalamanController::class, 'grafik']);
Route::get('/api/ekonomi/grafik/gdp/{id}', [HalamanController::class, 'grafikGdp'])
    ->name('ekonomi.grafik.gdp');

Route::get('/api/ekonomi/grafik/inflasi/{id}',  [HalamanController::class, 'grafikInflasi'])
    ->name('ekonomi.grafik.inflasi');

Route::get('/api/ekonomi/grafik/populasi/{id}', [HalamanController::class, 'grafikPopulasi'])
    ->name('ekonomi.grafik.populasi');

Route::get('/halaman-tren', [HalamanController::class, 'halamanTren'])
    ->name('halaman.tren');

Route::get('/api/pelabuhan/{id}', [HalamanController::class, 'pelabuhanByNegara']);    

Route::get('/api/skor-risiko/grafik/{id}', [HalamanController::class, 'grafikSkorRisiko']);

// API grafik ekonomi
Route::get('/api/ekonomi/grafik/gdp/{negara_id}', [HalamanController::class, 'grafikGdp']);
Route::get('/api/ekonomi/grafik/inflasi/{negara_id}', [HalamanController::class, 'grafikInflasi']);
Route::get('/api/ekonomi/grafik/populasi/{negara_id}', [HalamanController::class, 'grafikPopulasi']);

Route::get('/api/cuaca/{id}', [HalamanController::class, 'cuacaDetail'])->name('cuaca.detail');
Route::get('/api/kurs/{id}', [HalamanController::class, 'kursDetail'])->name('kurs.detail');
Route::get('/api/ekonomi/{id}', [HalamanController::class, 'ekonomiNegara'])->name('ekonomi.negara');
Route::get('/api/ekonomi/{id}/tren', [HalamanController::class, 'trenEkonomi'])->name('ekonomi.tren');

Route::get('/berita-hari-ini', [HalamanController::class, 'halamanBerita'])->name('halaman.berita');

Route::get('/pelabuhan', [HalamanController::class, 'halamanPelabuhan'])->name('halaman.pelabuhan');
// API map
Route::get('/api/negara-koordinat', [PetaController::class, 'koordinat'])->name('peta.koordinat');
Route::get('/api/negara/{id}', [PetaController::class, 'detail'])->name('peta.detail');

// Api Indikator Ekonomi
Route::post('/admin/ekonomi/update', [EkonomiController::class, 'ambilSemuaEkonomi'])->name('admin.ekonomi.update');
// Tombol update cuaca + kurs
Route::post('/admin/update-cuaca-kurs', [UpdateHarianController::class, 'updateCuacaKurs'])->name('admin.update.cuaca.kurs');
// Tombol update berita
Route::post('/admin/update-berita-bencana', [UpdateHarianController::class, 'updateBerita'])->name('admin.update.berita.bencana');

Route::get('/perbandingan', [PerbandinganController::class, 'index'])->name('perbandingan');

use App\Http\Controllers\FavoritController;

Route::middleware('auth')->group(function () {

    // Halaman Simpan Negara
    Route::get('/simpan-negara', [FavoritController::class, 'index'])
        ->name('halaman.simpan-negara');

    // Simpan negara ke favorit
    Route::post('/favorit', [FavoritController::class, 'store'])
        ->name('favorit.store');

    // Hapus negara dari favorit
    Route::delete('/favorit/{id}', [FavoritController::class, 'destroy'])
        ->name('favorit.destroy');

});

Route::post('/favorit', [FavoritController::class, 'store'])
    ->name('favorit.store');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])
        ->name('dashboard');

    Route::delete('/berita/{id}', [AdminController::class, 'destroyBerita'])
        ->name('berita.destroy');

});