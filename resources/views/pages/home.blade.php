@extends('layouts.app')

@section('title', 'Beranda - PortalNilai-SMP3 Unggulan')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container position-relative">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm">
                    <i class="bi bi-stars me-1"></i> Portal Penilaian Resmi Terakreditasi A
                </span>
                <h1 class="display-5 fw-extrabold text-white mb-3 tracking-tight">
                    Transparansi Nilai & Informasi Akademik <span class="text-info">SMP Negeri 3</span>
                </h1>
                <p class="lead text-white-50 mb-4 pe-lg-4">
                    Akses rekapitulasi nilai ujian harian, UTS, UAS, jadwal evaluasi belajar, dan data pendidik secara cepat, akurat, dan transparan dalam satu sistem terintegrasi.
                </p>

                <!-- Quick Check Nilai Box directly in Hero -->
                <div class="hero-search-card">
                    <form action="{{ route('nilai') }}" method="GET">
                        <label class="form-label text-dark fw-bold small text-uppercase mb-2">
                            <i class="bi bi-search text-primary me-1"></i> Cek Cepat Hasil Ujian Siswa
                        </label>
                        <div class="input-group input-group-lg">
                            <input type="text" name="q" class="form-control fs-6" placeholder="Masukkan NISN (contoh: 0089123451) atau Nama..." required>
                            <button class="btn btn-portal-login px-4 fs-6" type="submit">
                                <i class="bi bi-search me-1"></i> Cek Nilai
                            </button>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <small class="text-muted">Contoh NISN aktif:</small>
                            <a href="{{ route('nilai', ['q' => '0089123451']) }}" class="badge bg-light text-primary border text-decoration-none">0089123451 (Aditya)</a>
                            <a href="{{ route('nilai', ['q' => '0089123452']) }}" class="badge bg-light text-primary border text-decoration-none">0089123452 (Annisa)</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Hero Graphic / Mascot Card -->
            <div class="col-lg-5 text-center d-none d-lg-block">
                <div class="bg-white bg-opacity-10 p-4 rounded-4 backdrop-blur border border-white border-opacity-25 shadow-lg text-start">
                    <div class="d-flex align-items-center gap-3 mb-3 border-bottom border-white border-opacity-10 pb-3">
                        <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo" width="56" height="56" class="bg-white p-2 rounded-circle shadow-sm">
                        <div>
                            <h5 class="text-white fw-bold mb-0">SMP NEGERI 3</h5>
                            <span class="badge bg-info text-dark">Tahun Ajaran 2026/2027</span>
                        </div>
                    </div>
                    <p class="text-white-50 small mb-3">
                        "{{ $profil['motto'] }}"
                    </p>
                    <div class="bg-dark bg-opacity-50 p-3 rounded-3 mb-3">
                        <div class="d-flex justify-content-between text-white-50 small mb-1">
                            <span>Status Semester:</span>
                            <span class="text-light fw-bold">Ganjil (Aktif)</span>
                        </div>
                        <div class="d-flex justify-content-between text-white-50 small mb-1">
                            <span>Target KKM Sekolah:</span>
                            <span class="badge bg-warning text-dark">75 Poin</span>
                        </div>
                        <div class="d-flex justify-content-between text-white-50 small">
                            <span>Jadwal Ujian Terdekat:</span>
                            <span class="text-info fw-bold">04 Nov 2026</span>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('jadwal') }}" class="btn btn-outline-light btn-sm rounded-pill">
                            <i class="bi bi-calendar-check me-1"></i> Lihat Jadwal Lengkap
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Row -->
<section class="py-4 bg-white border-bottom shadow-sm">
    <div class="container">
        <div class="row g-3 text-center">
            <div class="col-6 col-md-3">
                <div class="p-2">
                    <div class="stat-number text-primary">{{ $profil['statistik']['siswa_aktif'] }}</div>
                    <div class="text-secondary small fw-semibold mt-1">Siswa Aktif</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-2 border-start-md">
                    <div class="stat-number text-info">{{ $profil['statistik']['guru_staff'] }}</div>
                    <div class="text-secondary small fw-semibold mt-1">Dewan Guru & Staff</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-2 border-start-md">
                    <div class="stat-number text-success">{{ $profil['statistik']['tingkat_kelulusan'] }}</div>
                    <div class="text-secondary small fw-semibold mt-1">Tingkat Kelulusan</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-2 border-start-md">
                    <div class="stat-number text-warning">A</div>
                    <div class="text-secondary small fw-semibold mt-1">Akreditasi BAN-S/M</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Feature Cards (Menu Utama) -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill fw-bold mb-2">Layanan Utama</span>
            <h2 class="fw-bold text-dark">Fitur Portal Nilai & Akademik</h2>
            <p class="text-muted">Kemudahan akses seluruh layanan penilaian dan informasi sekolah dalam satu pintu</p>
        </div>

        <div class="row g-4">
            <!-- Card 1: Hasil Ujian -->
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon-wrapper bg-primary-subtle text-primary">
                        <i class="bi bi-award-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Hasil Ujian</h5>
                    <p class="text-muted small mb-4">
                        Cek rekapitulasi nilai rapor, ulangan harian, UTS, dan UAS secara transparan berdasarkan NISN siswa.
                    </p>
                    <a href="{{ route('nilai') }}" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-semibold">
                        Cek Nilai Siswa <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Card 2: Jadwal Ujian -->
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon-wrapper bg-info-subtle text-info">
                        <i class="bi bi-calendar-week-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Jadwal Ujian</h5>
                    <p class="text-muted small mb-4">
                        Daftar jadwal lengkap Penilaian Akhir Semester (PAS), ruang ujian, waktu, dan nama guru pengawas.
                    </p>
                    <a href="{{ route('jadwal') }}" class="btn btn-outline-info btn-sm rounded-pill w-100 fw-semibold">
                        Lihat Jadwal <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Card 3: Dewan Guru -->
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon-wrapper bg-success-subtle text-success">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Dewan Guru</h5>
                    <p class="text-muted small mb-4">
                        Informasi lengkap guru pengampu mata pelajaran, wali kelas, kompetensi, dan kontak koordinasi.
                    </p>
                    <a href="{{ route('guru') }}" class="btn btn-outline-success btn-sm rounded-pill w-100 fw-semibold">
                        Profil Guru <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Card 4: Tentang Kami -->
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon-wrapper bg-warning-subtle text-warning">
                        <i class="bi bi-building-check"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Tentang Kami</h5>
                    <p class="text-muted small mb-4">
                        Mengenal profil SMP Negeri 3, visi misi, sejarah, sarana prasarana, serta capaian prestasi sekolah.
                    </p>
                    <a href="{{ route('tentang') }}" class="btn btn-outline-warning btn-sm rounded-pill w-100 fw-semibold">
                        Profil Sekolah <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Pengumuman & Jadwal Singkat -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="row g-4">
            <!-- Kolom Pengumuman -->
            <div class="col-lg-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="badge bg-danger-subtle text-danger fw-bold mb-1">Informasi Terkini</span>
                        <h4 class="fw-bold text-dark mb-0">Pengumuman Akademik</h4>
                    </div>
                </div>

                <div class="d-flex flex-column gap-3">
                    @foreach($pengumuman as $p)
                        <div class="p-3 rounded-3 border {{ $p['is_urgent'] ? 'border-danger-subtle bg-danger-subtle bg-opacity-10' : 'bg-light' }}">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="badge {{ $p['is_urgent'] ? 'bg-danger text-white' : 'bg-secondary text-white' }} small">
                                    {{ $p['kategori'] }}
                                </span>
                                <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $p['tanggal'] }}</small>
                            </div>
                            <h6 class="fw-bold text-dark mt-2 mb-1">{{ $p['judul'] }}</h6>
                            <p class="text-muted small mb-0">{{ $p['ringkasan'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Kolom Jadwal Ujian Terdekat -->
            <div class="col-lg-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="badge bg-primary-subtle text-primary fw-bold mb-1">Agenda Evaluasi</span>
                        <h4 class="fw-bold text-dark mb-0">Jadwal Ujian Terdekat</h4>
                    </div>
                    <a href="{{ route('jadwal') }}" class="btn btn-sm btn-link text-decoration-none">Semua Jadwal &rarr;</a>
                </div>

                <div class="card border rounded-3 overflow-hidden shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-portal mb-0">
                            <thead>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <th>Tingkat</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jadwalRingkas as $j)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $j['mapel'] }}</div>
                                            <small class="text-muted">{{ $j['hari'] }}, {{ $j['tanggal'] }}</small>
                                        </td>
                                        <td><span class="badge bg-light text-dark border">Kelas {{ $j['tingkat'] }}</span></td>
                                        <td><small class="text-secondary">{{ $j['waktu'] }}</small></td>
                                        <td><span class="badge bg-info-subtle text-info fw-semibold">{{ $j['status'] }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Cuplikan Dewan Guru -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill fw-bold mb-2">Tenaga Pendidik</span>
                <h3 class="fw-bold text-dark mb-0">Dewan Guru SMP Negeri 3</h3>
                <p class="text-muted small mb-0">Didukung oleh pendidik profesional dan berdedikasi tinggi</p>
            </div>
            <a href="{{ route('guru') }}" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold">
                Lihat Semua Guru ({{ $profil['statistik']['guru_staff'] }}) <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($guruUnggulan as $g)
                <div class="col-md-6 col-lg-3">
                    <div class="teacher-card p-4 text-center h-100">
                        <div class="teacher-avatar {{ $g['avatar_color'] }}">
                            {{ mb_substr($g['nama'], 0, 1) }}
                        </div>
                        <h6 class="fw-bold text-dark mb-1">{{ $g['nama'] }}</h6>
                        <span class="badge bg-light text-primary border mb-2">{{ $g['mapel'] }}</span>
                        <div class="text-muted small mb-2">{{ $g['jabatan'] }}</div>
                        <small class="text-secondary d-block">NIP: {{ $g['nip'] }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Section: Call To Action Login -->
<section class="py-5 text-white" style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%);">
    <div class="container text-center py-3">
        <h3 class="fw-bold mb-2">Portal Khusus Dewan Guru & Tenaga Pendidik</h3>
        <p class="text-white-50 mx-auto mb-4" style="max-width: 600px;">
            Bagi bapak/ibu guru pengampu mata pelajaran dan wali kelas, silakan masuk ke sistem untuk menginput nilai evaluasi belajar, menyusun e-rapor, dan memeriksa jadwal mengawas.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('login') }}" class="btn btn-warning px-4 py-2 fw-bold rounded-pill text-dark">
                <i class="bi bi-person-workspace me-1"></i> Masuk Sebagai Guru
            </a>
            <a href="{{ route('tentang') }}" class="btn btn-outline-light px-4 py-2 rounded-pill">
                <i class="bi bi-question-circle me-1"></i> Bantuan & Kontak
            </a>
        </div>
    </div>
</section>
@endsection
