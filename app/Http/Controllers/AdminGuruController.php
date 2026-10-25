<?php

namespace App\Http\Controllers;

use App\Models\Pengelola;
use App\Services\DatabaseInitService;
use App\Services\PortalDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminGuruController extends Controller
{
    protected PortalDataService $portalData;

    public function __construct(PortalDataService $portalData)
    {
        $this->portalData = $portalData;
    }

    /**
     * Memastikan hanya Admin yang dapat mengakses
     */
    private function checkAdminAuth()
    {
        DatabaseInitService::ensureDatabaseReady();

        $activeUser = Auth::user() ?? (object) session('user');

        if (!$activeUser || ($activeUser->role ?? '') !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Halaman ini khusus Administrator IT.');
        }

        return $activeUser;
    }

    /**
     * Tampilkan halaman kelola data guru & tenaga pendidik
     */
    public function index(Request $request)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck instanceof \Illuminate\Http\RedirectResponse) {
            return $authCheck;
        }
        $activeUser = $authCheck;

        $search = trim($request->query('search', ''));
        $selectedMapel = $request->query('mapel', 'Semua');
        $selectedRole = $request->query('role', 'Semua');

        $query = Pengelola::query();

        // Filter berdasarkan pencarian nama, NIP, email, atau username
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('mapel', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan mata pelajaran
        if ($selectedMapel !== 'Semua' && !empty($selectedMapel)) {
            $query->where('mapel', 'like', "%{$selectedMapel}%");
        }

        // Filter role
        if ($selectedRole !== 'Semua' && !empty($selectedRole)) {
            $query->where('role', $selectedRole);
        }

        $daftarGuru = $query->orderBy('role', 'asc')->orderBy('name', 'asc')->get();

        // Statistik ringkasan
        $stats = [
            'total_guru' => Pengelola::where('role', 'guru')->count(),
            'total_admin' => Pengelola::where('role', 'admin')->count(),
            'total_semua' => Pengelola::count(),
            'total_mapel' => Pengelola::whereNotNull('mapel')->where('mapel', '!=', '')->distinct('mapel')->count('mapel'),
        ];

        $daftarMapel = [
            'Semua', 'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris',
            'Ilmu Pengetahuan Alam (IPA)', 'Ilmu Pengetahuan Sosial (IPS)',
            'Informatika', 'Pendidikan Agama Islam', 'Pendidikan Pancasila & Kewarganegaraan',
            'Seni Budaya & Prakarya', 'Pendidikan Jasmani & Olahraga', 'Bimbingan & Konseling'
        ];

        $profil = $this->portalData->getProfilSekolah();

        return view('admin.guru.daftar_guru', compact(
            'daftarGuru',
            'stats',
            'profil',
            'activeUser',
            'search',
            'selectedMapel',
            'selectedRole',
            'daftarMapel'
        ));
    }

    /**
     * Halaman mandiri formulir tambah guru / tenaga baru
     */
    public function create()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck instanceof \Illuminate\Http\RedirectResponse) {
            return $authCheck;
        }
        $activeUser = $authCheck;
        $profil = $this->portalData->getProfilSekolah();

        $daftarMapel = [
            'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris',
            'Ilmu Pengetahuan Alam (IPA)', 'Ilmu Pengetahuan Sosial (IPS)',
            'Informatika', 'Pendidikan Agama Islam', 'Pendidikan Pancasila & Kewarganegaraan',
            'Seni Budaya & Prakarya', 'Pendidikan Jasmani & Olahraga', 'Bimbingan & Konseling'
        ];

        return view('admin.guru.tambah_guru', compact('activeUser', 'profil', 'daftarMapel'));
    }

    /**
     * Halaman mandiri formulir edit data guru / tenaga
     */
    public function edit($id)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck instanceof \Illuminate\Http\RedirectResponse) {
            return $authCheck;
        }
        $activeUser = $authCheck;
        $profil = $this->portalData->getProfilSekolah();
        $guru = Pengelola::findOrFail($id);

        $daftarMapel = [
            'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris',
            'Ilmu Pengetahuan Alam (IPA)', 'Ilmu Pengetahuan Sosial (IPS)',
            'Informatika', 'Pendidikan Agama Islam', 'Pendidikan Pancasila & Kewarganegaraan',
            'Seni Budaya & Prakarya', 'Pendidikan Jasmani & Olahraga', 'Bimbingan & Konseling'
        ];

        return view('admin.guru.edit_guru', compact('activeUser', 'profil', 'guru', 'daftarMapel'));
    }

    /**
     * Menampilkan file foto guru secara aman dari storage/foto_guru khusus untuk Admin
     */
    public function foto($id)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck instanceof \Illuminate\Http\RedirectResponse) {
            abort(403, 'Akses foto profil dibatasi khusus Administrator.');
        }

        $pengelola = Pengelola::findOrFail($id);

        if ($pengelola->foto && file_exists(storage_path('foto_guru/' . basename($pengelola->foto)))) {
            return response()->file(storage_path('foto_guru/' . basename($pengelola->foto)));
        }

        // Fallback jika berupa aset bawaan di public
        if ($pengelola->foto && file_exists(public_path($pengelola->foto))) {
            return response()->file(public_path($pengelola->foto));
        }

        // Fallback default SVG
        $defaultSvg = $pengelola->role === 'admin'
            ? public_path('assets/img/users/admin.svg')
            : public_path('assets/img/users/guru.svg');

        if (file_exists($defaultSvg)) {
            return response()->file($defaultSvg, ['Content-Type' => 'image/svg+xml']);
        }

        abort(404);
    }

    /**
     * Tambah data guru / pengelola baru
     */
    public function store(Request $request)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck instanceof \Illuminate\Http\RedirectResponse) {
            return $authCheck;
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:pengelola,username',
            'email' => 'required|email|max:150|unique:pengelola,email',
            'password' => 'required|string|min:4',
            'role' => 'required|in:guru,admin',
            'nip' => 'nullable|string|max:50',
            'mapel' => 'nullable|string|max:100',
            'jabatan' => 'nullable|string|max:150',
            'pendidikan' => 'nullable|string|max:200',
            'pengalaman' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:30',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan oleh akun lain.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar di sistem.',
            'password.min' => 'Kata sandi minimal 4 karakter.',
            'foto.image' => 'File foto profil harus berupa gambar valid.',
            'foto.mimes' => 'Format file foto harus berupa JPG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran file foto profil maksimal 2MB.',
        ]);

        $defaultFoto = $request->role === 'admin' ? 'assets/img/users/admin.svg' : 'assets/img/users/guru.svg';
        $fotoPath = $defaultFoto;

        // Simpan foto guru secara privat ke storage/foto_guru (terisolasi dari publik)
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $destPath = storage_path('foto_guru');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $file = $request->file('foto');
            $fileName = 'foto_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destPath, $fileName);
            $fotoPath = 'foto_guru/' . $fileName;
        }

        Pengelola::create([
            'name' => trim($request->name),
            'username' => strtolower(trim($request->username)),
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nip' => $request->nip ? trim($request->nip) : null,
            'mapel' => $request->mapel ? trim($request->mapel) : null,
            'jabatan' => $request->jabatan ? trim($request->jabatan) : null,
            'pendidikan' => $request->pendidikan ? trim($request->pendidikan) : null,
            'pengalaman' => $request->pengalaman ? trim($request->pengalaman) : null,
            'foto' => $fotoPath,
            'no_hp' => $request->no_hp ? trim($request->no_hp) : null,
        ]);

        return redirect()->route('admin.guru')->with('success', 'Data guru/tenaga pendidik baru berhasil ditambahkan.');
    }

    /**
     * Update data guru / pengelola
     */
    public function update(Request $request, $id)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck instanceof \Illuminate\Http\RedirectResponse) {
            return $authCheck;
        }

        $pengelola = Pengelola::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:pengelola,username,' . $id,
            'email' => 'required|email|max:150|unique:pengelola,email,' . $id,
            'password' => 'nullable|string|min:4',
            'role' => 'required|in:guru,admin',
            'nip' => 'nullable|string|max:50',
            'mapel' => 'nullable|string|max:100',
            'jabatan' => 'nullable|string|max:150',
            'pendidikan' => 'nullable|string|max:200',
            'pengalaman' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:30',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan oleh akun lain.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Kata sandi baru minimal 4 karakter.',
            'foto.image' => 'File foto profil harus berupa gambar valid.',
            'foto.mimes' => 'Format file foto harus berupa JPG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran file foto profil maksimal 2MB.',
        ]);

        $pengelola->name = trim($request->name);
        $pengelola->username = strtolower(trim($request->username));
        $pengelola->email = strtolower(trim($request->email));
        $pengelola->role = $request->role;
        $pengelola->nip = $request->nip ? trim($request->nip) : null;
        $pengelola->mapel = $request->mapel ? trim($request->mapel) : null;
        $pengelola->jabatan = $request->jabatan ? trim($request->jabatan) : null;
        $pengelola->pendidikan = $request->pendidikan ? trim($request->pendidikan) : null;
        $pengelola->pengalaman = $request->pengalaman ? trim($request->pengalaman) : null;
        $pengelola->no_hp = $request->no_hp ? trim($request->no_hp) : null;

        // Proses unggah foto baru jika ada
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            // Hapus foto lama di storage/foto_guru jika sebelumnya ada
            if ($pengelola->foto && str_starts_with($pengelola->foto, 'foto_guru/')) {
                $oldPath = storage_path('foto_guru/' . basename($pengelola->foto));
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $destPath = storage_path('foto_guru');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $file = $request->file('foto');
            $fileName = 'foto_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destPath, $fileName);
            $pengelola->foto = 'foto_guru/' . $fileName;
        }

        if ($request->filled('password')) {
            $pengelola->password = Hash::make($request->password);
        }

        $pengelola->save();

        return redirect()->route('admin.guru')->with('success', 'Data guru "' . $pengelola->name . '" berhasil diperbarui.');
    }

    /**
     * Hapus data guru / pengelola
     */
    public function destroy($id)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck instanceof \Illuminate\Http\RedirectResponse) {
            return $authCheck;
        }
        $activeUser = $authCheck;

        $pengelola = Pengelola::findOrFail($id);

        // Jangan izinkan admin menghapus akunnya sendiri saat sedang login
        if ($activeUser->id == $pengelola->id || $activeUser->username === $pengelola->username) {
            return redirect()->route('admin.guru')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        // Hapus file foto dari storage/foto_guru jika ada
        if ($pengelola->foto && str_starts_with($pengelola->foto, 'foto_guru/')) {
            $oldPath = storage_path('foto_guru/' . basename($pengelola->foto));
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        $nama = $pengelola->name;
        $pengelola->delete();

        return redirect()->route('admin.guru')->with('success', 'Data dewan guru/staf "' . $nama . '" berhasil dihapus dari sistem.');
    }
}
