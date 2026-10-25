<?php

namespace App\Http\Controllers;

use App\Services\PortalDataService;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    protected PortalDataService $portalData;

    public function __construct(PortalDataService $portalData)
    {
        $this->portalData = $portalData;
    }

    public function index(Request $request)
    {
        $keyword = $request->query('q');
        $kelas = $request->query('kelas', 'Semua');
        $profil = $this->portalData->getProfilSekolah();

        $hasilPencarian = [];
        $hasSearched = false;

        if ($request->has('q') || $request->has('kelas')) {
            $hasSearched = true;
            $hasilPencarian = $this->portalData->cariSiswa($keyword, $kelas);
        } else {
            // Default: tampilkan contoh data pertama agar halaman tidak kosong melompong
            $all = $this->portalData->getAllSiswaNilai();
            $hasilPencarian = array_map(fn($s) => $this->portalData->formatSiswaNilai($s), $all);
        }

        return view('pages.hasil-ujian', compact('profil', 'hasilPencarian', 'keyword', 'kelas', 'hasSearched'));
    }

    public function cetak(string $nisn)
    {
        $profil = $this->portalData->getProfilSekolah();
        $siswa = $this->portalData->getSiswaByNisn($nisn);

        if (!$siswa) {
            return redirect()->route('nilai')->with('error', 'Data siswa dengan NISN ' . $nisn . ' tidak ditemukan.');
        }

        return view('pages.hasil-ujian-cetak', compact('profil', 'siswa'));
    }
}
