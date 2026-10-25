<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected PortalDataService $portalData;

    public function __construct(PortalDataService $portalData)
    {
        $this->portalData = $portalData;
    }

    public function login(Request $request)
    {
        if ($request->session()->has('user')) {
            return redirect()->route('home')->with('info', 'Anda saat ini sudah terautentikasi sebagai ' . session('user.name') . ' (' . ucfirst(session('user.role')) . ').');
        }

        $profil = $this->portalData->getProfilSekolah();
        return view('pages.login', compact('profil'));
    }

    public function processLogin(Request $request)
    {
        $identifier = trim($request->input('username', ''));
        $password = trim($request->input('password', ''));

        if (empty($identifier) || empty($password)) {
            return back()->with('error', 'Silakan masukkan Email atau Username dan kata sandi Anda.')->withInput();
        }

        // Cari guru berdasarkan email/username/NIP di data sekolah
        $guruData = $this->portalData->getGuruByNip($identifier);

        $userData = [
            'logged_in' => true,
            'role' => 'guru',
            'username' => $identifier,
            'nip' => $guruData['nip'] ?? $identifier,
            'name' => $guruData['nama'] ?? 'Bpk/Ibu Guru (' . $identifier . ')',
            'mapel' => $guruData['mapel'] ?? 'Guru Pengampu Mata Pelajaran',
            'jabatan' => $guruData['jabatan'] ?? 'Dewan Guru SMPN 3',
            'email' => $guruData['email'] ?? ($identifier . '@smpn3.sch.id'),
        ];

        session(['user' => $userData]);

        return redirect()->route('home')->with('success', 'Selamat datang, ' . $userData['name'] . '! Anda berhasil masuk ke Portal Dewan Guru SMP Negeri 3.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect()->route('home')->with('info', 'Anda telah berhasil keluar dari sistem.');
    }
}
