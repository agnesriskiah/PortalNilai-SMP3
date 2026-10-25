<?php

namespace App\Http\Controllers;

use App\Models\Pengelola;
use App\Services\DatabaseInitService;
use App\Services\PortalDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected PortalDataService $portalData;

    public function __construct(PortalDataService $portalData)
    {
        $this->portalData = $portalData;
    }

    /**
     * Tampilkan halaman form login portal
     */
    public function login(Request $request)
    {
        // Pastikan database MySQL, tabel pengelola, dan dummy user sudah terinisialisasi
        DatabaseInitService::ensureDatabaseReady();

        if (Auth::check() || $request->session()->has('user')) {
            $user = Auth::user() ?? (object) session('user');
            if (($user->role ?? '') === 'admin') {
                return redirect()->route('admin.dashboard')->with('info', 'Anda sudah login sebagai Administrator IT.');
            }
            if (($user->role ?? '') === 'guru') {
                return redirect()->route('guru.dashboard')->with('info', 'Anda sudah login sebagai Dewan Guru.');
            }
            return redirect()->route('home')->with('info', 'Anda saat ini sudah terautentikasi.');
        }

        $profil = $this->portalData->getProfilSekolah();
        return view('auth.login', compact('profil'));
    }

    /**
     * Proses autentikasi user dari database MySQL (tabel pengelola)
     */
    public function processLogin(Request $request)
    {
        // Pastikan tabel pengelola tersedia
        DatabaseInitService::ensureDatabaseReady();

        $identifier = trim($request->input('username', ''));
        $password = trim($request->input('password', ''));
        $remember = $request->boolean('remember');

        if (empty($identifier) || empty($password)) {
            return back()->with('error', 'Silakan masukkan Email atau Username dan kata sandi Anda.')->withInput();
        }

        // Cari data pada tabel pengelola berdasarkan email atau username
        $pengelola = Pengelola::where('email', $identifier)
            ->orWhere('username', $identifier)
            ->first();

        if ($pengelola && Hash::check($password, $pengelola->password)) {
            // Login akun pengelola
            Auth::login($pengelola, $remember);
            session(['user' => $pengelola->toArray()]);

            // Pengalihan berdasarkan role di tabel pengelola
            if ($pengelola->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, ' . $pengelola->name . '! Anda masuk ke Dashboard Administrator IT.');
            } elseif ($pengelola->role === 'guru') {
                return redirect()->route('guru.dashboard')->with('success', 'Selamat datang, ' . $pengelola->name . '! Anda masuk ke Ruang Kerja Dewan Guru.');
            }

            return redirect()->route('home')->with('success', 'Login berhasil. Selamat datang di PortalNilai-SMP3.');
        }

        // Jika gagal autentikasi
        return back()->with('error', 'Kombinasi Email / Username dan kata sandi tidak ditemukan pada data pengelola. Silakan periksa kembali.')->withInput();
    }

    /**
     * Logout pengguna dan bersihkan sesi
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah berhasil keluar (logout) dari sistem portal.');
    }
}
