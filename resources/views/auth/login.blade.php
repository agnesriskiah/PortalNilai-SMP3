<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Portal - SMP Negeri 3 Unggulan</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo.svg') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="bg-light d-flex flex-column min-vh-100 justify-content-center py-4">

    <!-- Flash Notifications -->
    <div class="container mb-3" style="max-width: 960px;">
        @include('components.notification')
    </div>

    <!-- Main Container Login -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <!-- Tombol Kembali ke Beranda -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('home') }}" class="btn btn-white bg-white border shadow-sm rounded-pill px-3 py-2 text-decoration-none text-dark fw-semibold small">
                        <i class="bi bi-arrow-left me-1 text-primary"></i> Kembali ke Beranda
                    </a>
                    <span class="text-muted small d-none d-sm-inline">
                        <i class="bi bi-shield-check text-success me-1"></i> Sistem Autentikasi Terverifikasi Database
                    </span>
                </div>

                <!-- Kartu Login -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <div class="row g-0">
                        <!-- Sisi Kiri: Branding & Profil Sekolah -->
                        <div class="col-lg-5 text-white p-4 p-md-5 d-flex flex-column justify-content-between position-relative"
                             style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #0284c7 100%);">

                            <div>
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo SMPN 3" width="56" height="56" class="bg-white p-2 rounded-circle shadow-sm">
                                    <div>
                                        <h4 class="fw-bold mb-0 text-white">PortalNilai-SMP3</h4>
                                        <small class="text-white-50">SMP Negeri 3 Unggulan</small>
                                    </div>
                                </div>

                                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold mb-3">
                                    <i class="bi bi-shield-lock-fill me-1"></i> Gerbang Masuk Sivitas Akademika
                                </span>

                                <h3 class="fw-bold text-white mb-3">
                                    Portal Administrasi & Ruang Kerja Guru
                                </h3>

                                <p class="text-white-50 small leading-relaxed mb-4">
                                    Akses terpusat bagi dewan guru pengampu mata pelajaran dan staf administrator sekolah untuk pengelolaan nilai rapor, leger nilai, jadwal ujian, dan data akademik.
                                </p>
                            </div>

                            <!-- Fitur Akses -->
                            <div class="d-flex flex-column gap-2 mb-4 bg-white bg-opacity-10 p-3 rounded-3 border border-white border-opacity-10">
                                <div class="d-flex align-items-center gap-2 text-white small">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Login Guru: Kelola & Input Nilai Rapor Siswa</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 text-white small">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Login Admin: Manajemen Pengguna & Sistem</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 text-white small">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span>Database Terintegrasi MySQL & Keamanan Password</span>
                                </div>
                            </div>

                            <!-- Bantuan Akun -->
                            <div class="pt-3 border-top border-white border-opacity-25 small text-white-50">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi bi-telephone-fill text-warning"></i>
                                    <span>Helpdesk IT: <strong>(021) 7890-1234</strong></span>
                                </div>
                                <div>Email: it.support@smpn3.sch.id</div>
                            </div>
                        </div>

                        <!-- Sisi Kanan: Form Login -->
                        <div class="col-lg-7 p-4 p-md-5 d-flex flex-column justify-content-center">
                            <div class="mb-4">
                                <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-1 rounded-pill mb-2">
                                    <i class="bi bi-person-badge-fill me-1"></i> Masuk ke Sistem
                                </span>
                                <h2 class="fw-bold text-dark mb-1">Login Portal</h2>
                                <p class="text-muted small">Silakan masukkan Email atau Username dan kata sandi Anda</p>
                            </div>

                            <!-- Error Message if any -->
                            @if(session('error'))
                                <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 rounded-3 mb-3 small">
                                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                                    <div>{{ session('error') }}</div>
                                </div>
                            @endif

                            @if(session('info'))
                                <div class="alert alert-info d-flex align-items-center gap-2 py-2 px-3 rounded-3 mb-3 small">
                                    <i class="bi bi-info-circle-fill fs-5"></i>
                                    <div>{{ session('info') }}</div>
                                </div>
                            @endif

                            <form id="formLogin" action="{{ route('login.process') }}" method="POST">
                                @csrf

                                <!-- Email / Username -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-uppercase text-secondary">
                                        <i class="bi bi-envelope-at-fill text-primary me-1"></i> Email / Username
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-person-fill"></i></span>
                                        <input type="text" name="username" class="form-control form-control-lg fs-6 border-start-0"
                                               placeholder="Masukkan email atau username Anda..." value="{{ old('username') }}" required autofocus>
                                    </div>
                                    <div class="form-text small text-muted">Bisa menggunakan Email atau Username (contoh: guru / admin).</div>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-uppercase text-secondary">
                                        <i class="bi bi-key-fill text-primary me-1"></i> Kata Sandi (Password)
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" id="loginPasswordPage" name="password" class="form-control form-control-lg fs-6 border-start-0 border-end-0"
                                               placeholder="Masukkan kata sandi..." required>
                                        <button type="button" class="btn btn-light border border-start-0 toggle-password" data-target="loginPasswordPage" title="Tampilkan sandi">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Ingat Saya & Lupa Sandi -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rememberMePage" name="remember">
                                        <label class="form-check-label small text-muted" for="rememberMePage">Ingat saya di perangkat ini</label>
                                    </div>
                                    <a href="javascript:void(0)" onclick="alert('Silakan hubungi IT Administrator sekolah untuk reset kata sandi akun Anda.');" class="small text-decoration-none text-primary fw-semibold">
                                        Lupa kata sandi?
                                    </a>
                                </div>

                                <!-- Tombol Masuk -->
                                <button type="submit" class="btn btn-portal-login w-100 py-3 fw-bold fs-6">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Masuk Sekarang
                                </button>
                            </form>

                            <!-- Info Siswa & Orang Tua -->
                            <div class="alert alert-light border rounded-3 p-3 mt-4 mb-0 d-flex align-items-center gap-2 small text-secondary">
                                <i class="bi bi-info-circle-fill text-info fs-5"></i>
                                <div>
                                    <strong>Untuk Siswa & Orang Tua:</strong> Cek nilai rapor atau hasil ujian tanpa login melalui menu
                                    <a href="{{ route('nilai') }}" class="text-primary fw-bold text-decoration-none">Hasil Ujian</a>.
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Footer Teks Bawah Login -->
                <div class="text-center mt-3 text-secondary small">
                    &copy; {{ date('Y') }} <strong>SMP Negeri 3 Unggulan</strong> • Sistem Informasi Penilaian Siswa
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
