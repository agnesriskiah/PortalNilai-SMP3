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

    /**
     * Menampilkan file foto profil guru dari storage/foto_guru ke website publik
     */
    public function foto($id)
    {
        $guru = \App\Models\Pengelola::find($id);

        if ($guru && $guru->foto) {
            $storagePath = storage_path('foto_guru/' . basename($guru->foto));
            if (file_exists($storagePath)) {
                return response()->file($storagePath);
            }

            if (file_exists(public_path($guru->foto))) {
                return response()->file(public_path($guru->foto));
            }
        }

        abort(404);
    }
}
