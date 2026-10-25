<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DatabaseInitService;
use App\Services\PortalDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruDashboardController extends Controller
{
    protected PortalDataService $portalData;

    public function __construct(PortalDataService $portalData)
    {
        $this->portalData = $portalData;
    }

    public function dashboard(Request $request)
    {
        // Pastikan database ready
        DatabaseInitService::ensureDatabaseReady();

        $activeUser = Auth::user() ?? (object) session('user');

        if (!$activeUser || ($activeUser->role ?? '') !== 'guru') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Halaman ini khusus Dewan Guru.');
        }

        $profil = $this->portalData->getProfilSekolah();
        $semuaNilai = $this->portalData->getSemuaNilai();
        $semuaJadwal = $this->portalData->getSemuaJadwal();

        $stats = [
            'total_siswa_ampu' => count($semuaNilai),
            'total_kelas' => 4,
            'mapel' => $activeUser->mapel ?? 'Matematika',
            'nip' => $activeUser->nip ?? '19800820 200501 1 008',
            'rata_rata_mapel' => round(collect($semuaNilai)->avg('rata_rata'), 1),
        ];

        return view('guru.dashboard', compact('profil', 'activeUser', 'stats', 'semuaNilai', 'semuaJadwal'));
    }
}
