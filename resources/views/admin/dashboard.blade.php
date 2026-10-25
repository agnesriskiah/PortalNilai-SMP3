<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrator IT - PortalNilai-SMP3</title>

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
            background-color: #f1f5f9;
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
    <!-- Sidebar Admin Component -->
    @include('komponen_admin.sidebar_admin')

    <!-- Content Area -->
    <div class="content-area">
        <!-- Top Navbar in Dashboard -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 bg-white p-3 p-md-4 rounded-4 shadow-sm mb-4">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-danger-subtle text-danger fw-bold px-2 py-1 rounded-pill">
                        <i class="bi bi-shield-lock-fill me-1"></i> Admin IT Control Center
                    </span>
                    <span class="text-muted small">• Database MySQL Terhubung</span>
                </div>
                <h3 class="fw-bold text-dark mb-0 mt-1">Dashboard Administrator IT</h3>
                <small class="text-muted">Selamat datang, {{ $activeUser->name ?? 'Administrator' }} — Kelola sistem dan pantau data penilaian sekolah.</small>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-3 py-2 small fw-semibold">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Portal Publik
                </a>
                <div class="d-flex align-items-center gap-2 border-start ps-3">
                    <img src="{{ asset($activeUser->foto ?? 'assets/img/users/admin.svg') }}" alt="Avatar" width="42" height="42" class="rounded-circle border border-2 border-primary">
                    <div class="d-none d-lg-block text-start">
                        <div class="fw-bold small text-dark lh-sm">{{ $activeUser->name }}</div>
                        <small class="text-muted" style="font-size: 0.72rem;">{{ $activeUser->email }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Notification -->
        @include('components.notification')

        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <!-- Stat 1: Total Siswa / Data Nilai -->
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Data Nilai Siswa</span>
                            <h2 class="fw-bold text-primary mb-0 mt-1">{{ $stats['total_siswa'] }}</h2>
                            <small class="text-success fw-semibold"><i class="bi bi-check-circle me-1"></i>Tersimpan di Sistem</small>
                        </div>
                        <div class="p-3 bg-primary-subtle text-primary rounded-4 fs-3">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat 2: Total Dewan Guru -->
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Dewan Guru</span>
                            <h2 class="fw-bold text-success mb-0 mt-1">{{ $stats['total_guru'] }}</h2>
                            <small class="text-muted">Tenaga Pendidik Aktif</small>
                        </div>
                        <div class="p-3 bg-success-subtle text-success rounded-4 fs-3">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat 3: Jadwal Ujian -->
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Jadwal Ujian</span>
                            <h2 class="fw-bold text-info mb-0 mt-1">{{ $stats['total_jadwal'] }}</h2>
                            <small class="text-info fw-semibold"><i class="bi bi-calendar3 me-1"></i>Sesi Terjadwal</small>
                        </div>
                        <div class="p-3 bg-info-subtle text-info rounded-4 fs-3">
                            <i class="bi bi-calendar-event-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat 4: Akun Pengelola MySQL Terdaftar -->
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Pengelola MySQL</span>
                            <h2 class="fw-bold text-warning mb-0 mt-1">{{ $stats['total_pengelola_db'] }}</h2>
                            <small class="text-muted">Tabel <code>pengelola</code></small>
                        </div>
                        <div class="p-3 bg-warning-subtle text-warning rounded-4 fs-3">
                            <i class="bi bi-database-fill-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Akun Database MySQL (Tabel Pengelola) -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                <div>
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="bi bi-people text-primary me-2"></i>Data Akun Pengelola (Tabel <code>pengelola</code>)
                    </h5>
                    <small class="text-muted">Menampung akun Admin dan Dewan Guru terpisah dari tabel users.</small>
                </div>
                <div class="d-flex gap-2">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold">
                        <i class="bi bi-table me-1"></i> Tabel: pengelola
                    </span>
                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold">
                        <i class="bi bi-hdd-network me-1"></i> MySQL Connected
                    </span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary small text-uppercase">
                            <tr>
                                <th class="ps-4">Pengelola / Foto</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>NIP</th>
                                <th>Jabatan / Mapel</th>
                                <th class="pe-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daftarPengelola as $user)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ route('admin.guru.foto', $user->id) }}" alt="{{ $user->name }}" width="44" height="44" class="rounded-circle border p-0 bg-white object-fit-cover">
                                            <div>
                                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                                <small class="text-muted">{{ $user->no_hp ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-secondary">{{ $user->email }}</span>
                                    </td>
                                    <td>
                                        <code class="px-2 py-1 bg-light text-primary rounded fw-bold">{{ $user->username }}</code>
                                    </td>
                                    <td>
                                        <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-success' }} text-uppercase px-2 py-1">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $user->nip ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <span class="small text-dark">{{ $user->jabatan ?? $user->mapel ?? '-' }}</span>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                            <i class="bi bi-check2-circle me-1"></i> Aktif
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada pengelola di tabel pengelola.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tabel Ringkasan Nilai Siswa -->
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="bi bi-file-earmark-spreadsheet text-success me-2"></i>Rekap Nilai Siswa Terkini
                    </h5>
                    <small class="text-muted">Sampel data nilai siswa hasil ujian semester ganjil</small>
                </div>
                <a href="{{ route('nilai') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    Lihat Semua Nilai <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary small text-uppercase">
                            <tr>
                                <th class="ps-4">NISN / Nama Siswa</th>
                                <th>Kelas</th>
                                <th class="text-center">Matematika</th>
                                <th class="text-center">B. Indonesia</th>
                                <th class="text-center">B. Inggris</th>
                                <th class="text-center">IPA</th>
                                <th class="text-center">Rata-rata</th>
                                <th class="pe-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_slice($semuaNilai, 0, 5) as $nilai)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $nilai['nama'] }}</div>
                                        <small class="text-muted">NISN: {{ $nilai['nisn'] }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">{{ $nilai['kelas'] }}</span>
                                    </td>
                                    <td class="text-center fw-semibold">{{ $nilai['nilai_mapel']['matematika'] ?? 85 }}</td>
                                    <td class="text-center fw-semibold">{{ $nilai['nilai_mapel']['bahasa_indonesia'] ?? 88 }}</td>
                                    <td class="text-center fw-semibold">{{ $nilai['nilai_mapel']['bahasa_inggris'] ?? 84 }}</td>
                                    <td class="text-center fw-semibold">{{ $nilai['nilai_mapel']['ipa'] ?? 86 }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success fs-6">{{ $nilai['rata_rata'] }}</span>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">Lulus</span>
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
