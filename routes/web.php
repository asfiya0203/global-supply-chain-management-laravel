<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\PetaController;

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

// API — dipanggil AJAX dari JavaScript
Route::get('/api/negara-koordinat', [PetaController::class, 'koordinat'])->name('peta.koordinat');
Route::get('/api/negara/{id}', [PetaController::class, 'detail'])->name('peta.detail');

