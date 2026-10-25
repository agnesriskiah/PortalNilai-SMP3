<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes - Portal Nilai SMP Negeri 3
|--------------------------------------------------------------------------
| Struktur rute jelas, terorganisir, dan menggunakan named routes.
*/

// Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

// Tentang Kami
Route::get('/tentang-kami', [TentangController::class, 'index'])->name('tentang');

// Hasil Ujian / Nilai Siswa
Route::get('/hasil-ujian', [NilaiController::class, 'index'])->name('nilai');
Route::get('/hasil-ujian/cetak/{nisn}', [NilaiController::class, 'cetak'])->name('nilai.cetak');

// Jadwal Ujian
Route::get('/jadwal-ujian', [JadwalController::class, 'index'])->name('jadwal');

// Daftar Guru
Route::get('/guru', [GuruController::class, 'index'])->name('guru');

// Autentikasi / Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
