<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input & Data Nilai Siswa - Ruang Kerja Guru | PortalNilai-SMP3</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo.svg') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
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
        .student-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
            flex-shrink: 0;
        }
        .score-pill {
            display: inline-block;
            min-width: 44px;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.92rem;
            text-align: center;
        }
        .table-datanilai th {
            font-size: 0.76rem;
            letter-spacing: 0.05rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #64748b;
            background-color: #f1f5f9;
            padding-top: 14px;
            padding-bottom: 14px;
            border-bottom: 2px solid #e2e8f0;
        }
        .table-datanilai td {
            padding-top: 14px;
            padding-bottom: 14px;
            vertical-align: middle;
        }
        .calc-preview-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%);
            border: 1px dashed #0284c7;
            border-radius: 12px;
        }
        @media print {
            .sidebar-guru, .no-print, .btn, .modal {
                display: none !important;
            }
            .content-area {
                padding: 0;
            }
            body {
                background: white;
            }
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <!-- Sidebar Guru Component -->
    @include('komponen_guru.sidebar_guru')

    <!-- Content Area -->
    <div class="content-area">
        <!-- Top Navbar in Teacher Workspace -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 bg-white p-3 p-md-4 rounded-4 shadow-sm mb-4 no-print">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item"><a href="{{ route('guru.dashboard') }}" class="text-decoration-none text-muted">Dashboard Guru</a></li>
                        <li class="breadcrumb-item active text-success fw-bold" aria-current="page">Input & Nilai Siswa</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-success-subtle text-success fw-bold px-2 py-1 rounded-pill">
                        <i class="bi bi-pencil-square me-1"></i> Modul Penilaian Siswa
                    </span>
                    <span class="text-muted small">• Semester Ganjil TA 2024/2025</span>
                </div>
                <h3 class="fw-bold text-dark mb-0 mt-1">Kelola Nilai Belajar Siswa</h3>
            </div>

            <div class="d-flex align-items-center gap-2">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset($activeUser->foto ?? 'assets/img/users/guru.svg') }}" alt="Avatar" width="42" height="42" class="rounded-circle border border-2 border-success">
                    <div class="d-none d-lg-block text-start">
                        <div class="fw-bold small text-dark lh-sm">{{ $activeUser->name }}</div>
                        <small class="text-success fw-semibold" style="font-size: 0.72rem;">{{ $stats['mapel'] }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Notification -->
        @include('components.notification')

        <!-- 4 Statistics Cards -->
        <div class="row g-3 mb-4">
            <!-- Stat 1: Total Siswa -->
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card shadow-sm p-3 bg-white h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Total Siswa Dinilai</span>
                            <h2 class="fw-bold text-dark mb-0 mt-1">{{ $stats['total_siswa'] }}</h2>
                            <small class="text-muted">Kelas 7, 8, & 9</small>
                        </div>
                        <div class="p-3 bg-primary-subtle text-primary rounded-4 fs-3">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat 2: Rata-Rata Nilai Mapel -->
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card shadow-sm p-3 bg-white h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Rata-rata Kelas</span>
                            <h2 class="fw-bold text-primary mb-0 mt-1">{{ $stats['rata_rata'] }}</h2>
                            <small class="text-success fw-semibold"><i class="bi bi-check2-circle me-1"></i>Standar KKM: {{ $stats['kkm'] }}</small>
                        </div>
                        <div class="p-3 bg-warning-subtle text-warning rounded-4 fs-3">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat 3: Siswa Tuntas KKM -->
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card shadow-sm p-3 bg-white h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Tuntas KKM (&ge; 75)</span>
                            <h2 class="fw-bold text-success mb-0 mt-1">{{ $stats['total_tuntas'] }}</h2>
                            <small class="text-success fw-semibold">{{ round(($stats['total_tuntas'] / max(1, $stats['total_siswa'])) * 100) }}% Siswa Lulus</small>
                        </div>
                        <div class="p-3 bg-success-subtle text-success rounded-4 fs-3">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat 4: Perlu Remedial -->
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card shadow-sm p-3 bg-white h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Perlu Remedial (&lt; 75)</span>
                            <h2 class="fw-bold text-danger mb-0 mt-1">{{ $stats['total_remedial'] }}</h2>
                            <small class="text-danger fw-semibold">Agenda Evaluasi Lanjutan</small>
                        </div>
                        <div class="p-3 bg-danger-subtle text-danger rounded-4 fs-3">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar Card -->
        <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 mb-4 bg-white no-print">
            <form action="{{ route('guru.nilai') }}" method="GET" class="row g-3 align-items-end">
                <!-- Search Keyword -->
                <div class="col-lg-5 col-md-6">
                    <label class="form-label fw-bold text-dark small text-uppercase">
                        <i class="bi bi-search text-primary me-1"></i> Cari Siswa (Nama / NISN / NIS)
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-person"></i></span>
                        <input type="text" name="q" value="{{ $keyword ?? '' }}" class="form-control border-start-0" placeholder="Ketik nama atau NISN siswa...">
                    </div>
                </div>

                <!-- Filter Kelas -->
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <label class="form-label fw-bold text-dark small text-uppercase">
                        <i class="bi bi-funnel text-primary me-1"></i> Rombel / Kelas
                    </label>
                    <select name="kelas" class="form-select">
                        @foreach($daftarKelas as $kls)
                            <option value="{{ $kls }}" {{ ($kelasFilter ?? 'Semua') === $kls ? 'selected' : '' }}>
                                {{ $kls === 'Semua' ? 'Semua Kelas' : 'Kelas ' . $kls }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Status -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label class="form-label fw-bold text-dark small text-uppercase">
                        <i class="bi bi-award text-primary me-1"></i> Status KKM
                    </label>
                    <select name="status" class="form-select">
                        <option value="Semua" {{ ($statusFilter ?? 'Semua') === 'Semua' ? 'selected' : '' }}>Semua Status</option>
                        <option value="Lulus" {{ ($statusFilter ?? '') === 'Lulus' ? 'selected' : '' }}>Tuntas KKM</option>
                        <option value="Remedial" {{ ($statusFilter ?? '') === 'Remedial' ? 'selected' : '' }}>Remedial</option>
                    </select>
                </div>

                <!-- Filter Action Buttons -->
                <div class="col-lg-2 col-md-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-semibold rounded-pill">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    @if(!empty($keyword) || ($kelasFilter ?? 'Semua') !== 'Semua' || ($statusFilter ?? 'Semua') !== 'Semua')
                        <a href="{{ route('guru.nilai') }}" class="btn btn-light border text-muted rounded-pill px-3" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Main Grade Table Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-5">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                <div>
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="bi bi-table text-success me-2"></i>Tabel Capaian Nilai Siswa — {{ $stats['mapel'] }}
                    </h5>
                    <small class="text-muted">
                        Standar KKM: <strong>{{ $stats['kkm'] }}</strong> • Bobot Perhitungan: <strong>Tugas (30%) + UTS (30%) + UAS (40%)</strong>
                    </small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-semibold">
                        Menampilkan: <strong>{{ count($filteredNilai) }}</strong> siswa
                    </span>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 fw-semibold no-print" onclick="window.print()">
                        <i class="bi bi-printer me-1"></i> Cetak Leger
                    </button>
                    @if(session()->has('custom_nilai') || session()->has('siswa_tambahan'))
                        <form action="{{ route('guru.nilai.reset') }}" method="POST" class="d-inline" onsubmit="return confirm('Kembalikan semua nilai ke data default?');">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill px-3 py-2 fw-semibold no-print" title="Reset Perubahan">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('guru.nilai.input') }}" class="btn btn-sm btn-success rounded-pill px-3 py-2 fw-semibold no-print">
                        <i class="bi bi-plus-circle me-1"></i> Input Nilai Baru
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-datanilai">
                        <thead>
                            <tr>
                                <th class="ps-4 text-center" style="width: 50px;">No</th>
                                <th>Identitas Siswa</th>
                                <th class="text-center" style="width: 90px;">Kelas</th>
                                <th class="text-center" style="width: 85px;">Tugas (30%)</th>
                                <th class="text-center" style="width: 85px;">UTS (30%)</th>
                                <th class="text-center" style="width: 85px;">UAS (40%)</th>
                                <th class="text-center" style="width: 100px;">Nilai Akhir</th>
                                <th class="text-center" style="width: 110px;">Predikat</th>
                                <th class="text-center" style="width: 130px;">Status KKM</th>
                                <th class="pe-4 text-center no-print" style="width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($filteredNilai as $index => $item)
                                @php
                                    $nAkhir = (float) $item['akhir'];
                                    $kkmVal = (float) $item['kkm'];
                                    $isLulus = ($item['status'] === 'Lulus' || $nAkhir >= $kkmVal);
                                    $predClass = $nAkhir >= 90 ? 'bg-success' : ($nAkhir >= 80 ? 'bg-primary' : ($nAkhir >= 75 ? 'bg-warning text-dark' : 'bg-danger'));
                                    $initial = mb_substr($item['nama'], 0, 1);
                                    $avatarColors = ['bg-primary text-white', 'bg-success text-white', 'bg-info text-dark', 'bg-warning text-dark', 'bg-dark text-white'];
                                    $avatarColor = $avatarColors[$index % count($avatarColors)];
                                @endphp
                                <tr>
                                    <td class="ps-4 text-center text-muted fw-bold">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="student-avatar {{ $avatarColor }} shadow-sm">
                                                {{ $initial }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark fs-6">{{ $item['nama'] }}</div>
                                                <div class="small text-muted">
                                                    <span>NISN: <strong>{{ $item['nisn'] }}</strong></span>
                                                    <span class="ms-2">• NIS: {{ $item['nis'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 rounded-pill fw-bold">
                                            {{ $item['kelas'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="score-pill bg-light border text-dark">{{ $item['tugas'] }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="score-pill bg-light border text-dark">{{ $item['uts'] }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="score-pill bg-light border text-dark">{{ $item['uas'] }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="score-pill {{ $isLulus ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }} fs-6">
                                            {{ $item['akhir'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $predClass }} px-2 py-1">
                                            {{ $item['predikat'] }}
                                            @if($item['predikat'] === 'A')
                                                <small class="d-none d-lg-inline">(Sangat Baik)</small>
                                            @elseif($item['predikat'] === 'B')
                                                <small class="d-none d-lg-inline">(Baik)</small>
                                            @elseif($item['predikat'] === 'C')
                                                <small class="d-none d-lg-inline">(Cukup)</small>
                                            @else
                                                <small class="d-none d-lg-inline">(Kurang)</small>
                                            @endif
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($isLulus)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                                <i class="bi bi-check-circle-fill me-1"></i> Tuntas
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1">
                                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Remedial
                                            </span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-center no-print">
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <!-- Button Edit Nilai (Halaman Form Tersendiri) -->
                                            <a href="{{ route('guru.nilai.edit', $item['nisn']) }}"
                                               class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-semibold"
                                               title="Ubah & Input Nilai">
                                                <i class="bi bi-pencil-square me-1"></i> Edit
                                            </a>

                                            <!-- Button Hapus Nilai -->
                                            <form action="{{ route('guru.nilai.hapus', $item['nisn']) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data nilai {{ $item['nama'] }} (NISN: {{ $item['nisn'] }})?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" title="Hapus Nilai Siswa">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                            <!-- Button Cetak Transkrip Rapor -->
                                            <a href="{{ route('nilai.cetak', $item['nisn']) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-1"
                                               title="Cetak Transkrip Rapor">
                                                <i class="bi bi-printer"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="text-muted mb-3">
                                            <i class="bi bi-inbox fs-1 text-secondary opacity-50"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark">Data Nilai Siswa Tidak Ditemukan</h5>
                                        <p class="text-muted small mx-auto mb-3" style="max-width: 450px;">
                                            Tidak ada data siswa yang cocok dengan kriteria pencarian "{{ $keyword }}" atau filter kelas yang Anda pilih.
                                        </p>
                                        <a href="{{ route('guru.nilai') }}" class="btn btn-sm btn-primary rounded-pill px-4">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Tampilkan Seluruh Siswa
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer Card with Calculation Reference -->
            <div class="card-footer bg-light p-3 border-top d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 small text-muted">
                <div>
                    <i class="bi bi-info-circle text-primary me-1"></i>
                    <strong>Panduan Pedoman Penilaian:</strong> Nilai Akhir dihitung dari $30\% \times \text{Tugas} + 30\% \times \text{UTS} + 40\% \times \text{UAS}$. Predikat A (&ge; 90), B (80-89), C (75-79), D (&lt; 75).
                </div>
                <div>
                    Guru Pengampu: <strong>{{ $activeUser->name ?? 'Dewan Guru' }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
