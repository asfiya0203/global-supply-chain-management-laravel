<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\CuacaController;
use App\Http\Controllers\EkonomiController;
use App\Http\Controllers\KursController;

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

// Pengguna
Route::get('/dashboard', [HalamanController::class, 'dashboard'])->name('dashboard');

// Peta — halaman
Route::get('/peta', [PetaController::class, 'index'])->name('peta.index');

// API map
Route::get('/api/negara-koordinat', [PetaController::class, 'koordinat'])->name('peta.koordinat');
Route::get('/api/negara/{id}', [PetaController::class, 'detail'])->name('peta.detail');

// Api cuaca
Route::get('/api/cuaca/{id}', [CuacaController::class, 'detail'])->name('cuaca.detail');

// Api Indikator Ekonomi

Route::post('/admin/ekonomi/update', [EkonomiController::class, 'ambilSemuaEkonomi'])
    ->name('admin.ekonomi.update');

Route::get('/api/ekonomi/{id}', [EkonomiController::class, 'ekonomiNegara'])
    ->name('ekonomi.negara');

Route::get('/api/ekonomi/{id}/tren', [EkonomiController::class, 'trenEkonomi'])
    ->name('ekonomi.tren');

// kurs mata uang
Route::get('/api/kurs/{id}', [KursController::class, 'kursNegara'])
    ->name('kurs.negara');

Route::get('/api/kurs/{id}/tren', [KursController::class, 'trenKurs'])
    ->name('kurs.tren');

// Admin Update Kurs
Route::post('/admin/kurs/update', [KursController::class, 'ambilSemuaKurs'])
    ->name('admin.kurs.update');
