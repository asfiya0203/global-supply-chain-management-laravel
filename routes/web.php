<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\EkonomiController;
use App\Http\Controllers\UpdateHarianController;
use App\Http\Controllers\BeritaController;

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
Route::post('/admin/ekonomi/update', [EkonomiController::class, 'ambilSemuaEkonomi'])
    ->name('admin.ekonomi.update');

// Admin Update Kurs
Route::post('/admin/kurs/update', [KursController::class, 'ambilSemuaKurs'])
    ->name('admin.kurs.update');

Route::post('/admin/update-harian', [UpdateHarianController::class, 'update'])
    ->name('admin.update.harian');

// berita
Route::post('/admin/berita/update', [BeritaController::class, 'updateBerita'])
    ->name('admin.berita.update');
Route::post('/admin/bencana/update', [BeritaController::class, 'updateBencana'])
    ->name('admin.bencana.update');