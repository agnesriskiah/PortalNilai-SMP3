<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected PortalDataService $portalData;

    public function __construct(PortalDataService $portalData)
    {
        $this->portalData = $portalData;
    }

    public function index()
    {
        $profil = $this->portalData->getProfilSekolah();
        $pengumuman = $this->portalData->getPengumuman();
        $jadwalRingkas = array_slice($this->portalData->getJadwalUjian(), 0, 4);
        $guruUnggulan = array_slice($this->portalData->getDaftarGuru(), 0, 4);

        return view('pages.home', compact('profil', 'pengumuman', 'jadwalRingkas', 'guruUnggulan'));
    }
}
