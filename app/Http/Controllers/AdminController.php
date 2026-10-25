<?php

namespace App\Http\Controllers;

use App\Models\Pengelola;
use App\Services\DatabaseInitService;
use App\Services\PortalDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected PortalDataService $portalData;

    public function __construct(PortalDataService $portalData)
    {
        $this->portalData = $portalData;
    }

    public function dashboard(Request $request)
    {
        // Pastikan database dan tabel pengelola ready
        DatabaseInitService::ensureDatabaseReady();

        $activeUser = Auth::user() ?? (object) session('user');

        if (!$activeUser || ($activeUser->role ?? '') !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Halaman ini khusus Administrator IT.');
        }

        $profil = $this->portalData->getProfilSekolah();
        $semuaNilai = $this->portalData->getSemuaNilai();
        $semuaJadwal = $this->portalData->getSemuaJadwal();
        $daftarGuru = $this->portalData->getDaftarGuru();

        // Ambil data akun pengelola dari database MySQL (tabel pengelola)
        $daftarPengelola = Pengelola::all();

        $stats = [
            'total_siswa' => count($semuaNilai),
            'total_guru' => count($daftarGuru),
            'total_jadwal' => count($semuaJadwal),
            'total_pengelola_db' => $daftarPengelola->count(),
            'rata_rata_sekolah' => round(collect($semuaNilai)->avg('rata_rata'), 1),
        ];

        return view('admin.dashboard', compact('profil', 'activeUser', 'stats', 'daftarPengelola', 'semuaNilai', 'semuaJadwal'));
    }
}
