<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    protected PortalDataService $portalData;

    public function __construct(PortalDataService $portalData)
    {
        $this->portalData = $portalData;
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $mapel = $request->query('mapel', 'Semua');
        $profil = $this->portalData->getProfilSekolah();
        $guru = $this->portalData->getDaftarGuru($mapel, $search);

        $daftarMapel = [
            'Semua', 'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris',
            'IPA', 'IPS', 'Informatika', 'Pendidikan Agama', 'PPKn', 'Seni Budaya', 'PJOK', 'BK'
        ];

        return view('pages.guru', compact('profil', 'guru', 'search', 'mapel', 'daftarMapel'));
    }
}
