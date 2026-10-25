<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    protected PortalDataService $portalData;

    public function __construct(PortalDataService $portalData)
    {
        $this->portalData = $portalData;
    }

    public function index(Request $request)
    {
        $tingkat = $request->query('tingkat', 'Semua');
        $profil = $this->portalData->getProfilSekolah();
        $jadwal = $this->portalData->getJadwalUjian($tingkat);

        return view('pages.jadwal-ujian', compact('profil', 'jadwal', 'tingkat'));
    }
}
