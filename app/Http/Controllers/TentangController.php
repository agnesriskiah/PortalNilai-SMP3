<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;

class TentangController extends Controller
{
    protected PortalDataService $portalData;

    public function __construct(PortalDataService $portalData)
    {
        $this->portalData = $portalData;
    }

    public function index()
    {
        $profil = $this->portalData->getProfilSekolah();
        return view('pages.tentang', compact('profil'));
    }
}
