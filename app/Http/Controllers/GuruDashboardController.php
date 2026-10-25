<?php

namespace App\Http\Controllers;

use App\Models\NilaiSiswa;
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

    /**
     * Halaman khusus Data & Input Nilai Siswa untuk Dewan Guru (Mengambil dari Tabel nilaisiswa)
     */
    public function dataNilai(Request $request)
    {
        DatabaseInitService::ensureDatabaseReady();

        $activeUser = Auth::user() ?? (object) session('user');

        if (!$activeUser || ($activeUser->role ?? '') !== 'guru') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Halaman ini khusus Dewan Guru.');
        }

        $profil = $this->portalData->getProfilSekolah();
        $mapelGuru = $activeUser->mapel ?? 'Matematika';

        // Ambil data nilai dari tabel MySQL 'nilaisiswa'
        $baseQuery = NilaiSiswa::where('mapel', 'like', "%{$mapelGuru}%");
        if ($baseQuery->count() === 0) {
            $baseQuery = NilaiSiswa::where('mapel', 'like', '%Matematika%');
        }

        $allMapelSiswa = $baseQuery->get();

        // Filter pencarian dan kelas
        $keyword = trim($request->query('q', ''));
        $kelasFilter = $request->query('kelas', 'Semua');
        $statusFilter = $request->query('status', 'Semua');

        $query = clone $baseQuery;

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('nisn', 'like', "%{$keyword}%")
                  ->orWhere('nis', 'like', "%{$keyword}%");
            });
        }

        if ($kelasFilter !== 'Semua') {
            $query->where(function ($q) use ($kelasFilter) {
                $q->where('kelas', $kelasFilter)
                  ->orWhere('tingkat', $kelasFilter);
            });
        }

        if ($statusFilter !== 'Semua') {
            $query->where('status', $statusFilter);
        }

        $filteredNilai = $query->orderBy('kelas')->orderBy('nama')->get();

        // Statistik dihitung dari data aktual database
        $totalSiswa = $allMapelSiswa->count();
        $totalTuntas = $allMapelSiswa->filter(fn($n) => $n->status === 'Lulus' || $n->akhir >= $n->kkm)->count();
        $totalRemedial = $allMapelSiswa->filter(fn($n) => $n->status === 'Remedial' || $n->akhir < $n->kkm)->count();
        $rataRataNilai = $totalSiswa > 0 ? round($allMapelSiswa->avg('akhir'), 1) : 0;

        $stats = [
            'total_siswa' => $totalSiswa,
            'total_tuntas' => $totalTuntas,
            'total_remedial' => $totalRemedial,
            'rata_rata' => $rataRataNilai,
            'mapel' => $mapelGuru,
            'kkm' => 75,
        ];

        $daftarKelas = ['Semua', '7-A', '8-B', '9-A', '9-C'];

        return view('guru.datanilai', compact(
            'profil',
            'activeUser',
            'filteredNilai',
            'stats',
            'keyword',
            'kelasFilter',
            'statusFilter',
            'daftarKelas'
        ));
    }

    /**
     * Halaman Form Tersendiri: Input & Edit Nilai Siswa (Database nilaisiswa)
     */
    public function formNilai(Request $request, ?string $nisn = null)
    {
        DatabaseInitService::ensureDatabaseReady();

        $activeUser = Auth::user() ?? (object) session('user');

        if (!$activeUser || ($activeUser->role ?? '') !== 'guru') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Halaman ini khusus Dewan Guru.');
        }

        $profil = $this->portalData->getProfilSekolah();
        $mapelGuru = $activeUser->mapel ?? 'Matematika';

        $targetNisn = $nisn ?? $request->query('nisn');
        $siswaEdit = null;
        $mode = 'create'; // 'create' atau 'edit'

        if ($targetNisn) {
            $siswaEdit = NilaiSiswa::where('nisn', $targetNisn)
                ->where('mapel', 'like', "%{$mapelGuru}%")
                ->first();

            if (!$siswaEdit) {
                $siswaEdit = NilaiSiswa::where('nisn', $targetNisn)->first();
            }

            if ($siswaEdit) {
                $mode = 'edit';
            }
        }

        // Ambil daftar siswa terdaftar unik dari tabel nilaisiswa
        $daftarSiswaTersedia = NilaiSiswa::select('nisn', 'nis', 'nama', 'kelas')
            ->distinct()
            ->orderBy('nama')
            ->get();

        $daftarKelas = ['7-A', '8-B', '9-A', '9-C'];

        return view('guru.inputnilai', compact(
            'profil',
            'activeUser',
            'mode',
            'siswaEdit',
            'targetNisn',
            'mapelGuru',
            'daftarKelas',
            'daftarSiswaTersedia'
        ));
    }

    /**
     * Proses simpan/update nilai siswa langsung ke tabel MySQL 'nilaisiswa'
     */
    public function simpanNilai(Request $request)
    {
        DatabaseInitService::ensureDatabaseReady();

        $activeUser = Auth::user() ?? (object) session('user');

        if (!$activeUser || ($activeUser->role ?? '') !== 'guru') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'nisn' => 'required',
            'tugas' => 'required|numeric|min:0|max:100',
            'uts' => 'required|numeric|min:0|max:100',
            'uas' => 'required|numeric|min:0|max:100',
        ]);

        $nisn = trim($request->input('nisn'));
        $nama = trim($request->input('nama', ''));
        $kelas = $request->input('kelas', '7-A');
        $tugas = round((float) $request->input('tugas'), 1);
        $uts = round((float) $request->input('uts'), 1);
        $uas = round((float) $request->input('uas'), 1);
        $mode = $request->input('mode', 'create');

        // Bobot penilaian standar kurikulum: Tugas 30%, UTS 30%, UAS 40%
        $akhir = round(($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4), 1);
        $predikat = $akhir >= 90 ? 'A' : ($akhir >= 80 ? 'B' : ($akhir >= 75 ? 'C' : 'D'));
        $status = $akhir >= 75 ? 'Lulus' : 'Remedial';
        $catatan = $request->input('catatan', 'Capaian kompetensi tuntas sesuai kriteria ketercapaian tujuan pembelajaran.');

        $mapel = $activeUser->mapel ?? 'Matematika';

        // Simpan langsung ke database tabel nilaisiswa
        $nilaiRecord = NilaiSiswa::updateOrCreate(
            ['nisn' => $nisn, 'mapel' => $mapel],
            [
                'nis' => $request->input('nis', '24250' . rand(1000, 9999)),
                'nama' => !empty($nama) ? $nama : 'Siswa ' . $nisn,
                'kelas' => $kelas,
                'tingkat' => substr($kelas, 0, 1),
                'semester' => 'Ganjil 2024/2025',
                'wali_kelas' => 'Guru Wali Kelas ' . $kelas,
                'guru' => $activeUser->name ?? 'Hendro Prasetyo, M.Pd.',
                'kkm' => 75.0,
                'tugas' => $tugas,
                'uts' => $uts,
                'uas' => $uas,
                'akhir' => $akhir,
                'predikat' => $predikat,
                'status' => $status,
                'catatan' => $catatan,
            ]
        );

        $namaTarget = !empty($nama) ? $nama : "NISN {$nisn}";
        $aksi = $mode === 'edit' ? 'diperbarui di database tabel nilaisiswa' : 'disimpan ke database tabel nilaisiswa';
        return redirect()->route('guru.nilai')->with('success', "Data nilai siswa {$namaTarget} berhasil {$aksi}! Nilai Akhir: {$akhir} (Predikat {$predikat} - {$status})");
    }

    /**
     * Hapus data nilai siswa dari database tabel 'nilaisiswa'
     */
    public function hapusNilai(string $nisn)
    {
        DatabaseInitService::ensureDatabaseReady();

        $activeUser = Auth::user() ?? (object) session('user');

        if (!$activeUser || ($activeUser->role ?? '') !== 'guru') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        $mapelGuru = $activeUser->mapel ?? 'Matematika';

        // Hapus dari database tabel nilaisiswa
        $deleted = NilaiSiswa::where('nisn', $nisn)
            ->where('mapel', 'like', "%{$mapelGuru}%")
            ->delete();

        if ($deleted === 0) {
            NilaiSiswa::where('nisn', $nisn)->delete();
        }

        return redirect()->route('guru.nilai')->with('success', "Data nilai siswa dengan NISN {$nisn} telah berhasil dihapus dari tabel nilaisiswa di database MySQL.");
    }

    /**
     * Reset nilai kembali ke data awal database
     */
    public function resetNilai()
    {
        DatabaseInitService::ensureDatabaseReady();
        DatabaseInitService::seedInitialNilaiSiswa(true);

        return redirect()->route('guru.nilai')->with('info', 'Seluruh data tabel nilaisiswa di database telah dikembalikan ke kondisi default sistem.');
    }
}
