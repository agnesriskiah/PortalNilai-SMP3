<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - Portal Nilai SMP Negeri 3 Unggulan
|--------------------------------------------------------------------------
| Struktur rute terorganisir, menggunakan named routes, dan controller terpisah.
*/

// Halaman Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [TentangController::class, 'index'])->name('tentang');
Route::get('/hasil-ujian', [NilaiController::class, 'index'])->name('nilai');
Route::get('/hasil-ujian/cetak/{nisn}', [NilaiController::class, 'cetak'])->name('nilai.cetak');
Route::get('/jadwal-ujian', [JadwalController::class, 'index'])->name('jadwal');
Route::get('/guru', [GuruController::class, 'index'])->name('guru');

// Autentikasi / Login & Logout (Khusus Guru & Admin)
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Administrator IT
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Dashboard Dewan Guru
Route::get('/guru/dashboard', [GuruDashboardController::class, 'dashboard'])->name('guru.dashboard');
