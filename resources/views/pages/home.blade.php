@extends('layouts.app')

@section('title', 'Beranda - PortalNilai-SMP3 Unggulan')

@push('styles')
<style>
    /* Hero Modern Styling */
    .hero-modern {
        background: radial-gradient(circle at 10% 20%, #1e3a8a 0%, #0f172a 65%, #020617 100%);
        position: relative;
        overflow: hidden;
        padding: 5rem 0 6.5rem;
    }
    .hero-modern::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -80px;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(14, 165, 233, 0.22) 0%, rgba(14, 165, 233, 0) 70%);
        border-radius: 50%;
        filter: blur(40px);
        pointer-events: none;
    }
    .hero-modern::after {
        content: '';
        position: absolute;
        bottom: -150px;
        left: -100px;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(234, 179, 8, 0.15) 0%, rgba(234, 179, 8, 0) 70%);
        border-radius: 50%;
        filter: blur(50px);
        pointer-events: none;
    }
    .hero-glass-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 1.5rem;
        transition: transform 0.3s ease, border-color 0.3s ease;
    }
    .hero-glass-card:hover {
        border-color: rgba(255, 255, 255, 0.3);
    }
    .search-box-elevated {
        background: #ffffff;
        border-radius: 1.25rem;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35);
        padding: 1.75rem;
        border: 1px solid rgba(226, 232, 240, 0.8);
    }
    /* Floating Stats Bar */
    .stats-overlap {
        margin-top: -3.5rem;
        position: relative;
        z-index: 10;
    }
    .stat-pill-card {
        background: #ffffff;
        border-radius: 1.25rem;
        padding: 1.5rem;
        border: 1px solid #f1f5f9;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.06), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .stat-pill-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 30px -10px rgba(15, 23, 42, 0.1);
    }
    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    /* Service Card Modern */
    .service-card-modern {
        background: #ffffff;
        border-radius: 1.25rem;
        border: 1px solid #e2e8f0;
        padding: 2rem 1.75rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .service-card-modern:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 35px -10px rgba(15, 23, 42, 0.09);
        border-color: #38bdf8;
    }
    .service-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: transparent;
        transition: background 0.3s ease;
    }
    .service-card-modern:hover::before {
        background: linear-gradient(90deg, #1e3a8a, #0284c7);
    }
    /* Timeline Announcement */
    .announcement-item {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 1rem;
        padding: 1.25rem;
        transition: all 0.2s ease;
    }
    .announcement-item:hover {
        border-color: #cbd5e1;
        background-color: #f8fafc;
        transform: translateX(3px);
    }
    /* Schedule List Modern */
    .schedule-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        transition: all 0.2s ease;
    }
    .schedule-item:hover {
        border-color: #38bdf8;
        background-color: #f0f9ff;
    }
    .date-badge {
        min-width: 65px;
        height: 65px;
        border-radius: 0.85rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        line-height: 1.1;
    }
    /* Teacher Card Modern */
    .teacher-card-modern {
        background: #ffffff;
        border-radius: 1.25rem;
        border: 1px solid #e2e8f0;
        padding: 1.75rem 1.5rem;
        text-align: center;
        height: 100%;
        transition: all 0.25s ease;
    }
    .teacher-card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -8px rgba(15, 23, 42, 0.08);
        border-color: #059669;
    }
    .teacher-avatar-circle {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        margin: 0 auto 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        font-weight: 700;
        color: #ffffff;
    }
</style>
@endpush

@section('content')
<!-- Hero Section Modern -->
<section class="hero-modern text-white">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center g-5">
            <!-- Left Column: Copy & Search Form -->
            <div class="col-lg-7">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-20 mb-3">
                    <span class="badge bg-warning text-dark fw-bold rounded-pill px-2">TERAKREDITASI A</span>
                    <small class="text-white fw-semibold">NPSN: {{ $profil['npsn'] }} • Kurikulum Nasional</small>
                </div>

                <h1 class="display-5 fw-bold text-white mb-3 lh-sm">
                    Portal Informasi & Rekap Nilai <span class="text-warning">SMP Negeri 3</span>
                </h1>

                <p class="lead text-white-50 mb-4 pe-lg-4 fs-6">
                    Akses rekapitulasi nilai rapor, ulangan harian, UTS, UAS, jadwal evaluasi semester, dan informasi tenaga pendidik secara transparan dalam satu sistem terintegrasi.
                </p>

                <!-- Search Card -->
                <div class="search-box-elevated text-start">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <label class="form-label text-dark fw-bold small text-uppercase mb-0">
                            <i class="bi bi-search text-primary me-1"></i> Cek Nilai Siswa Mandiri
                        </label>
                        <span class="badge bg-success-subtle text-success small px-2 py-1 rounded-pill fw-semibold">
                            <i class="bi bi-shield-check me-1"></i> Akses Terbuka Tanpa Login
                        </span>
                    </div>

                    <form action="{{ route('nilai') }}" method="GET">
                        <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden border">
                            <span class="input-group-text bg-white border-0 text-muted ps-3">
                                <i class="bi bi-person-vcard fs-5 text-primary"></i>
                            </span>
                            <input type="text" name="q" class="form-control border-0 fs-6 py-3"
                                   placeholder="Ketik NISN (contoh: 0089123451) atau nama siswa..." required autofocus>
                            <button class="btn btn-primary px-4 fw-bold d-flex align-items-center gap-2" type="submit" style="background: linear-gradient(135deg, #1e3a8a, #0284c7); border: none;">
                                <i class="bi bi-search"></i>
                                <span>Cari Nilai</span>
                            </button>
                        </div>

                        <div class="d-flex flex-wrap align-items-center gap-2 mt-3 pt-1">
                            <small class="text-muted fw-semibold">Sampel NISN Siswa:</small>
                            <a href="{{ route('nilai', ['q' => '0089123451']) }}" class="badge bg-light text-primary border text-decoration-none py-1 px-2 rounded-2">
                                <i class="bi bi-arrow-right-short"></i> 0089123451 (Aditya)
                            </a>
                            <a href="{{ route('nilai', ['q' => '0089123452']) }}" class="badge bg-light text-primary border text-decoration-none py-1 px-2 rounded-2">
                                <i class="bi bi-arrow-right-short"></i> 0089123452 (Annisa)
                            </a>
                            <a href="{{ route('nilai', ['q' => '0089123453']) }}" class="badge bg-light text-primary border text-decoration-none py-1 px-2 rounded-2">
                                <i class="bi bi-arrow-right-short"></i> 0089123453 (Bagus)
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Academic Status Glass Widget -->
            <div class="col-lg-5">
                <div class="hero-glass-card p-4 p-md-4 shadow-lg">
                    <div class="d-flex align-items-center gap-3 pb-3 border-bottom border-white border-opacity-15 mb-3">
                        <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo SMPN 3" width="58" height="58" class="bg-white p-2 rounded-circle shadow-sm">
                        <div>
                            <h5 class="text-white fw-bold mb-0">SMP NEGERI 3 UNGGULAN</h5>
                            <small class="text-white-50">Sistem Informasi Akademik Resmi</small>
                        </div>
                    </div>

                    <div class="p-3 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-15 mb-3">
                        <div class="d-flex justify-content-between align-items-center text-white small mb-2">
                            <span class="text-white-50">Tahun Ajaran:</span>
                            <span class="fw-bold text-light">2026/2027</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center text-white small mb-2">
                            <span class="text-white-50">Status Semester:</span>
                            <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill">Ganjil (Aktif)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center text-white small mb-2">
                            <span class="text-white-50">Standar Kelulusan (KKM):</span>
                            <span class="badge bg-warning text-dark fw-bold">75.0 Poin</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center text-white small">
                            <span class="text-white-50">Evaluasi Berikutnya:</span>
                            <span class="text-info fw-bold">PAS Semester Ganjil</span>
                        </div>
                    </div>

                    <div class="row g-2 mb-3 text-center">
                        <div class="col-6">
                            <div class="p-2 rounded-3 bg-black bg-opacity-25 border border-white border-opacity-10">
                                <small class="text-white-50 d-block" style="font-size: 0.72rem;">RATA-RATA RAPOR</small>
                                <span class="fs-4 fw-bold text-warning">{{ $profil['statistik']['rata_rata_sekolah'] ?? 86.4 }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded-3 bg-black bg-opacity-25 border border-white border-opacity-10">
                                <small class="text-white-50 d-block" style="font-size: 0.72rem;">KELULUSAN</small>
                                <span class="fs-4 fw-bold text-success">{{ $profil['statistik']['tingkat_kelulusan'] ?? '100%' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('jadwal') }}" class="btn btn-outline-light rounded-pill py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-calendar3"></i>
                            <span>Buka Kalender Jadwal Ujian</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Floating Statistics Overlap Banner -->
<div class="container stats-overlap">
    <div class="row g-3">
        <!-- Stat 1: Siswa Aktif -->
        <div class="col-6 col-lg-3">
            <div class="stat-pill-card d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div>
                    <h3 class="fw-bold text-dark mb-0 lh-1">{{ $profil['statistik']['siswa_aktif'] }}</h3>
                    <small class="text-muted fw-semibold">Siswa Aktif</small>
                </div>
            </div>
        </div>
        <!-- Stat 2: Dewan Guru -->
        <div class="col-6 col-lg-3">
            <div class="stat-pill-card d-flex align-items-center gap-3">
                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <h3 class="fw-bold text-dark mb-0 lh-1">{{ $profil['statistik']['guru_staff'] }}</h3>
                    <small class="text-muted fw-semibold">Dewan Guru & Staff</small>
                </div>
            </div>
        </div>
        <!-- Stat 3: Rombel -->
        <div class="col-6 col-lg-3">
            <div class="stat-pill-card d-flex align-items-center gap-3">
                <div class="stat-icon bg-info-subtle text-info">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                </div>
                <div>
                    <h3 class="fw-bold text-dark mb-0 lh-1">{{ $profil['statistik']['rombongan_belajar'] ?? 24 }}</h3>
                    <small class="text-muted fw-semibold">Rombel Kelas</small>
                </div>
            </div>
        </div>
        <!-- Stat 4: Akreditasi -->
        <div class="col-6 col-lg-3">
            <div class="stat-pill-card d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning-subtle text-warning">
                    <i class="bi bi-award-fill"></i>
                </div>
                <div>
                    <h3 class="fw-bold text-dark mb-0 lh-1">A</h3>
                    <small class="text-muted fw-semibold">BAN-S/M Unggul</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Layanan Utama Portal (Fitur) -->
<section class="py-5 mt-4">
    <div class="container">
        <div class="text-center mb-5" style="max-width: 650px; margin-inline: auto;">
            <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill fw-bold mb-2">
                LAYANAN UTAMA
            </span>
            <h2 class="fw-bold text-dark mb-2">Fasilitas Digital Siswa & Pendidik</h2>
            <p class="text-muted">Akses informasi hasil pembelajaran, agenda evaluasi, serta profil dewan guru secara mudah dan transparan.</p>
        </div>

        <div class="row g-4">
            <!-- Feature 1: Hasil Ujian -->
            <div class="col-md-6 col-lg-3">
                <div class="service-card-modern">
                    <div>
                        <div class="p-3 bg-primary-subtle text-primary rounded-4 d-inline-block mb-3 fs-3">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Hasil Ujian & Rapor</h5>
                        <p class="text-muted small mb-4">
                            Cek nilai ulangan harian, PTS, dan PAS lengkap dengan rincian predikat, status kelulusan KKM, dan transkrip cetak.
                        </p>
                    </div>
                    <a href="{{ route('nilai') }}" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold py-2">
                        Buka Nilai Siswa <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Feature 2: Jadwal Ujian -->
            <div class="col-md-6 col-lg-3">
                <div class="service-card-modern">
                    <div>
                        <div class="p-3 bg-info-subtle text-info rounded-4 d-inline-block mb-3 fs-3">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Jadwal Evaluasi Belajar</h5>
                        <p class="text-muted small mb-4">
                            Informasi agenda tanggal, alokasi jam ujian, tingkat kelas, denah ruang, serta daftar guru pengawas bertugas.
                        </p>
                    </div>
                    <a href="{{ route('jadwal') }}" class="btn btn-outline-info btn-sm rounded-pill fw-semibold py-2">
                        Buka Jadwal Ujian <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Feature 3: Dewan Guru -->
            <div class="col-md-6 col-lg-3">
                <div class="service-card-modern">
                    <div>
                        <div class="p-3 bg-success-subtle text-success rounded-4 d-inline-block mb-3 fs-3">
                            <i class="bi bi-person-lines-fill"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Direktori Guru</h5>
                        <p class="text-muted small mb-4">
                            Daftar dewan guru pengampu mata pelajaran, wali kelas, kompetensi akademik, serta informasi kontak resmi pendidik.
                        </p>
                    </div>
                    <a href="{{ route('guru') }}" class="btn btn-outline-success btn-sm rounded-pill fw-semibold py-2">
                        Lihat Data Guru <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Feature 4: Tentang Sekolah -->
            <div class="col-md-6 col-lg-3">
                <div class="service-card-modern">
                    <div>
                        <div class="p-3 bg-warning-subtle text-warning rounded-4 d-inline-block mb-3 fs-3">
                            <i class="bi bi-building-fill-check"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Profil SMP Negeri 3</h5>
                        <p class="text-muted small mb-4">
                            Kilas sejarah sekolah, visi misi, fasilitas laboratorium komputer CBT, program unggulan, dan capaian prestasi.
                        </p>
                    </div>
                    <a href="{{ route('tentang') }}" class="btn btn-outline-warning btn-sm rounded-pill fw-semibold py-2">
                        Profil Lengkap <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Pengumuman Akademik & Jadwal Ujian Ringkas -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="row g-5">
            <!-- Kolom Kiri: Pengumuman Akademik -->
            <div class="col-lg-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="badge bg-danger-subtle text-danger fw-bold mb-1">PAPAN INFORMASI</span>
                        <h3 class="fw-bold text-dark mb-0">Pengumuman Akademik</h3>
                    </div>
                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill small">
                        Terakhir Diperbarui: Hari Ini
                    </span>
                </div>

                <div class="d-flex flex-column gap-3">
                    @forelse($pengumuman as $p)
                        <div class="announcement-item shadow-sm {{ $p['is_urgent'] ? 'border-start border-4 border-danger' : 'border-start border-4 border-primary' }}">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge {{ $p['is_urgent'] ? 'bg-danger text-white' : 'bg-primary-subtle text-primary' }} rounded-pill small px-3">
                                    {{ $p['kategori'] }}
                                </span>
                                <small class="text-muted"><i class="bi bi-calendar-event me-1"></i>{{ $p['tanggal'] }}</small>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">{{ $p['judul'] }}</h6>
                            <p class="text-muted small mb-0">{{ $p['ringkasan'] }}</p>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">Belum ada pengumuman terbaru.</div>
                    @endforelse
                </div>
            </div>

            <!-- Kolom Kanan: Jadwal Ujian Terdekat -->
            <div class="col-lg-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="badge bg-primary-subtle text-primary fw-bold mb-1">AGENDA TERJADWAL</span>
                        <h3 class="fw-bold text-dark mb-0">Jadwal Ujian Terdekat</h3>
                    </div>
                    <a href="{{ route('jadwal') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">
                        Semua Jadwal <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="d-flex flex-column gap-3">
                    @forelse($jadwalRingkas as $j)
                        <div class="schedule-item d-flex align-items-center justify-content-between shadow-sm">
                            <div class="d-flex align-items-center gap-3">
                                <div class="date-badge bg-primary-subtle text-primary">
                                    <small class="text-uppercase" style="font-size: 0.65rem;">{{ $j['hari'] }}</small>
                                    <span class="fs-5">{{ explode(' ', $j['tanggal'])[0] ?? '01' }}</span>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">{{ $j['mapel'] }}</h6>
                                    <div class="d-flex align-items-center gap-2 small text-muted">
                                        <span><i class="bi bi-clock me-1 text-primary"></i>{{ $j['waktu'] }}</span>
                                        <span>•</span>
                                        <span><i class="bi bi-door-open me-1 text-info"></i>{{ $j['ruang'] ?? $j['ruangan'] ?? 'Ruang Ujian' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2 fw-semibold">
                                    Kelas {{ $j['tingkat'] }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">Belum ada agenda ujian mendatang.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Cuplikan Dewan Guru -->
<section class="py-5">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
            <div>
                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill fw-bold mb-2">
                    TENAGA PENDIDIK
                </span>
                <h3 class="fw-bold text-dark mb-1">Dewan Guru SMP Negeri 3</h3>
                <p class="text-muted small mb-0">Dibimbing oleh tenaga pendidik profesional, bersertifikasi, dan berdedikasi tinggi</p>
            </div>
            <a href="{{ route('guru') }}" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold px-3 py-2">
                Lihat Seluruh Dewan Guru ({{ $profil['statistik']['guru_staff'] }}) <i class="bi bi-arrow-right ms-1"></i>
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

<!-- Section: Call To Action Login Guru & Admin -->
<section class="py-5 text-white position-relative" style="background: linear-gradient(135deg, #0b1329 0%, #1e3a8a 60%, #0369a1 100%);">
    <div class="container text-center py-4 position-relative" style="z-index: 2;">
        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold mb-3">
            <i class="bi bi-shield-lock-fill me-1"></i> RUANG KERJA TERPADU
        </span>
        <h2 class="fw-bold mb-3">Portal Khusus Dewan Guru & Pengelola IT</h2>
        <p class="text-white-50 mx-auto mb-4" style="max-width: 620px;">
            Bagi Bapak/Ibu Guru pengampu mata pelajaran dan staf IT Administrator, silakan masuk untuk pengelolaan leger nilai rapor, verifikasi data evaluasi, dan kalender pengawasan ujian.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('login') }}" class="btn btn-warning px-4 py-3 fw-bold rounded-pill text-dark shadow-sm d-flex align-items-center gap-2">
                <i class="bi bi-box-arrow-in-right fs-5"></i>
                <span>Masuk ke Portal Pengelola</span>
            </a>
            <a href="{{ route('nilai') }}" class="btn btn-outline-light px-4 py-3 rounded-pill fw-semibold d-flex align-items-center gap-2">
                <i class="bi bi-search"></i>
                <span>Cek Nilai Siswa (Publik)</span>
            </a>
        </div>
    </div>
</section>
@endsection
