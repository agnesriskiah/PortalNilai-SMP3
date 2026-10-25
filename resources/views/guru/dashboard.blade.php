<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Kerja Dewan Guru - PortalNilai-SMP3</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo.svg') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }
        .content-area {
            flex-grow: 1;
            padding: 1.5rem 2rem;
            overflow-y: auto;
        }
        .stat-card {
            border: 0;
            border-radius: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.06);
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <!-- Sidebar Guru Component -->
    @include('komponen_guru.sidebar_guru')

    <!-- Content Area -->
    <div class="content-area">
        <!-- Top Navbar in Teacher Dashboard -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 bg-white p-3 p-md-4 rounded-4 shadow-sm mb-4">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success-subtle text-success fw-bold px-2 py-1 rounded-pill">
                        <i class="bi bi-person-workspace me-1"></i> Ruang Kerja Pendidik
                    </span>
                    <span class="text-muted small">• Tahun Ajaran 2024/2025</span>
                </div>
                <h3 class="fw-bold text-dark mb-0 mt-1">Dashboard Dewan Guru</h3>
                <small class="text-muted">Selamat datang, <strong>{{ $activeUser->name ?? 'Bapak/Ibu Guru' }}</strong> — Pengampu Mata Pelajaran {{ $activeUser->mapel ?? 'Matematika' }}.</small>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-3 py-2 small fw-semibold">
                    <i class="bi bi-house me-1"></i> Beranda Publik
                </a>
                <div class="d-flex align-items-center gap-2 border-start ps-3">
                    <img src="{{ asset($activeUser->foto ?? 'assets/img/users/guru.svg') }}" alt="Avatar" width="44" height="44" class="rounded-circle border border-2 border-success">
                    <div class="d-none d-lg-block text-start">
                        <div class="fw-bold small text-dark lh-sm">{{ $activeUser->name }}</div>
                        <small class="text-success fw-semibold" style="font-size: 0.72rem;">{{ $activeUser->mapel ?? 'Matematika' }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Notification -->
        @include('components.notification')

        <!-- Statistics Cards for Teacher -->
        <div class="row g-3 mb-4">
            <!-- Stat 1: Total Siswa Diampu -->
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Siswa Diampu</span>
                            <h2 class="fw-bold text-success mb-0 mt-1">{{ $stats['total_siswa_ampu'] }}</h2>
                            <small class="text-muted">Kelas VII, VIII, IX</small>
                        </div>
                        <div class="p-3 bg-success-subtle text-success rounded-4 fs-3">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat 2: Mata Pelajaran -->
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Mata Pelajaran</span>
                            <h4 class="fw-bold text-primary mb-0 mt-2">{{ $stats['mapel'] }}</h4>
                            <small class="text-muted">Kurikulum Merdeka</small>
                        </div>
                        <div class="p-3 bg-primary-subtle text-primary rounded-4 fs-3">
                            <i class="bi bi-journal-bookmark-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat 3: Rata-rata Nilai -->
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Rata-rata Nilai</span>
                            <h2 class="fw-bold text-warning mb-0 mt-1">{{ $stats['rata_rata_mapel'] }}</h2>
                            <small class="text-success fw-semibold"><i class="bi bi-arrow-up-short"></i>Di atas KKM (75.0)</small>
                        </div>
                        <div class="p-3 bg-warning-subtle text-warning rounded-4 fs-3">
                            <i class="bi bi-bar-chart-line-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat 4: NIP & Status -->
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Status Akun Guru</span>
                            <h5 class="fw-bold text-dark mb-0 mt-1">Terverifikasi</h5>
                            <small class="text-muted" style="font-size: 0.72rem;">NIP: {{ $stats['nip'] }}</small>
                        </div>
                        <div class="p-3 bg-info-subtle text-info rounded-4 fs-3">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Rekap Nilai yang Diampu -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                <div>
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="bi bi-pencil-square text-success me-2"></i>Rekapitulasi Nilai Siswa Mata Pelajaran {{ $stats['mapel'] }}
                    </h5>
                    <small class="text-muted">Daftar capaian belajar siswa pada mata pelajaran yang Anda ampu</small>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-success rounded-pill px-3" onclick="alert('Fitur tambah nilai siswa siap digunakan!');">
                        <i class="bi bi-plus-circle me-1"></i> Input Nilai Baru
                    </button>
                    <a href="{{ route('nilai') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        <i class="bi bi-printer me-1"></i> Cetak Leger
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary small text-uppercase">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>NISN / Nama Siswa</th>
                                <th>Kelas</th>
                                <th class="text-center">Nilai {{ $stats['mapel'] }}</th>
                                <th class="text-center">Predikat</th>
                                <th class="text-center">Keterangan</th>
                                <th class="pe-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semuaNilai as $index => $item)
                                <tr>
                                    <td class="ps-4 text-muted small">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item['nama'] }}</div>
                                        <small class="text-muted">NISN: {{ $item['nisn'] }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">{{ $item['kelas'] }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold fs-6 text-dark">
                                            {{ $item['nilai_mapel']['matematika'] ?? 85 }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $n = $item['nilai_mapel']['matematika'] ?? 85;
                                            $pred = $n >= 90 ? 'A (Sangat Baik)' : ($n >= 80 ? 'B (Baik)' : 'C (Cukup)');
                                            $badgeClass = $n >= 90 ? 'bg-success' : ($n >= 80 ? 'bg-primary' : 'bg-warning text-dark');
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $pred }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                            Tuntas KKM
                                        </span>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <a href="{{ route('nilai.cetak', $item['nisn']) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-1" title="Cetak Transkrip">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Jadwal Mengawas Ujian Guru -->
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="bi bi-clock-history text-warning me-2"></i>Jadwal Mengawas Ujian Guru
                    </h5>
                    <small class="text-muted">Tugas pengawasan ujian semester ganjil tahun ajaran berjalan</small>
                </div>
                <a href="{{ route('jadwal') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    Lihat Seluruh Jadwal <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary small text-uppercase">
                            <tr>
                                <th class="ps-4">Hari & Tanggal</th>
                                <th>Waktu / Sesi</th>
                                <th>Mata Pelajaran Ujian</th>
                                <th>Ruangan</th>
                                <th class="pe-4 text-center">Status Pengawas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_slice($semuaJadwal, 0, 4) as $jadwal)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $jadwal['hari'] }}, {{ $jadwal['tanggal'] }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $jadwal['waktu'] }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-primary">{{ $jadwal['mapel'] }}</span>
                                        <small class="text-muted d-block">{{ $jadwal['tingkat'] }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle">{{ $jadwal['ruang'] ?? $jadwal['ruangan'] ?? 'Ruang 01' }}</span>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <span class="badge bg-warning-subtle text-dark border border-warning-subtle rounded-pill px-3 py-1">
                                            <i class="bi bi-person-check-fill me-1 text-warning"></i> Bertugas
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
