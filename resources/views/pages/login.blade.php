@extends('layouts.auth')

@section('title', 'Login Khusus Guru - PortalNilai-SMP3')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-11">
            <!-- Tombol Kembali ke Beranda -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('home') }}" class="btn btn-white bg-white border shadow-sm rounded-pill px-3 py-2 text-decoration-none text-dark fw-semibold small">
                    <i class="bi bi-arrow-left me-1 text-primary"></i> Kembali ke Beranda
                </a>
                <span class="text-muted small d-none d-sm-inline">
                    <i class="bi bi-shield-lock-fill text-success me-1"></i> Akses Terbatas Khusus Tenaga Pendidik
                </span>
            </div>

            <!-- Kartu Login Khusus Guru -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                <div class="row g-0">
                    <!-- Sisi Kiri: Branding & Informasi Khusus Guru -->
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
                                <i class="bi bi-person-workspace me-1"></i> Portal Khusus Guru
                            </span>

                            <h3 class="fw-bold text-white mb-3">
                                Ruang Kerja & Penilaian Dewan Guru
                            </h3>

                            <p class="text-white-50 small leading-relaxed mb-4">
                                Akses sistem terintegrasi bagi dewan guru pengampu mata pelajaran dan wali kelas untuk pengelolaan nilai rapor, penilaian ujian, dan koordinasi akademik.
                            </p>
                        </div>

                        <!-- Fitur Khusus Pendidik -->
                        <div class="d-flex flex-column gap-2 mb-4 bg-white bg-opacity-10 p-3 rounded-3 border border-white border-opacity-10">
                            <div class="d-flex align-items-center gap-2 text-white small">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>Input & Rekap Nilai Siswa (Tugas, UTS, UAS)</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 text-white small">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>Pengesahan Rapor Digital & Leger Nilai</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 text-white small">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>Jadwal Mengawas Ujian & Lokasi Ruangan</span>
                            </div>
                        </div>

                        <!-- Bantuan Akun -->
                        <div class="pt-3 border-top border-white border-opacity-25 small text-white-50">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-telephone-fill text-warning"></i>
                                <span>Pusat Bantuan Kurikulum: <strong>(021) 7890-1234</strong></span>
                            </div>
                            <div>Email: kurikulum@smpn3-unggulan.sch.id</div>
                        </div>
                    </div>

                    <!-- Sisi Kanan: Form Login Guru -->
                    <div class="col-lg-7 p-4 p-md-5 d-flex flex-column justify-content-center">
                        <div class="mb-4">
                            <span class="badge bg-success-subtle text-success fw-bold px-3 py-1 rounded-pill mb-2">
                                <i class="bi bi-lock-fill me-1"></i> Autentikasi Dewan Guru
                            </span>
                            <h2 class="fw-bold text-dark mb-1">Login Dewan Guru</h2>
                            <p class="text-muted small">Silakan masukkan Email atau Username dan kata sandi Anda</p>
                        </div>

                        <form id="formLogin" action="{{ route('login.process') }}" method="POST">
                            @csrf

                            <!-- Email / Username Guru -->
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase text-secondary">
                                    <i class="bi bi-envelope-at-fill text-primary me-1"></i> Email / Username
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" name="username" class="form-control form-control-lg fs-6 border-start-0"
                                           placeholder="Masukkan email atau username guru Anda..." required autofocus>
                                </div>
                                <div class="form-text small text-muted">Contoh: hendro.prasetyo@smpn3.sch.id atau username guru Anda.</div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase text-secondary">
                                    <i class="bi bi-key-fill text-primary me-1"></i> Kata Sandi (Password)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" id="loginPasswordPage" name="password" class="form-control form-control-lg fs-6 border-start-0 border-end-0"
                                           placeholder="Masukkan kata sandi akun guru..." required>
                                    <button type="button" class="btn btn-light border border-start-0 toggle-password" data-target="loginPasswordPage" title="Tampilkan sandi">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Ingat Saya & Bantuan -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMePage" name="remember">
                                    <label class="form-check-label small text-muted" for="rememberMePage">Ingat saya di perangkat ini</label>
                                </div>
                                <a href="javascript:void(0)" onclick="alert('Untuk reset password akun guru, silakan hubungi Bagian Kurikulum atau Admin IT SMP Negeri 3.');" class="small text-decoration-none text-primary fw-semibold">
                                    Lupa password guru?
                                </a>
                            </div>

                            <!-- Tombol Masuk -->
                            <button type="submit" class="btn btn-portal-login w-100 py-3 fw-bold fs-6">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Masuk Sebagai Guru
                            </button>
                        </form>

                        <!-- Informasi Khusus Siswa & Orang Tua -->
                        <div class="alert alert-light border rounded-3 p-3 mt-4 mb-0 d-flex align-items-center gap-2 small text-secondary">
                            <i class="bi bi-info-circle-fill text-info fs-5"></i>
                            <div>
                                <strong>Untuk Siswa & Orang Tua Murid:</strong> Pengecekan hasil ujian dan nilai siswa tidak memerlukan login, langsung gunakan menu
                                <a href="{{ route('nilai') }}" class="text-primary fw-bold text-decoration-none">Hasil Ujian</a>.
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Footer Teks Bawah Login -->
            <div class="text-center mt-3 text-secondary small">
                &copy; {{ date('Y') }} <strong>SMP Negeri 3 Unggulan</strong> • Portal Khusus Tenaga Pendidik
            </div>
        </div>
    </div>
</div>
@endsection
