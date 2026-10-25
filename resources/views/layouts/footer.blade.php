<!-- Main Footer -->
<footer class="footer-portal">
    <div class="container">
        <div class="row g-4 justify-content-between">
            <!-- Col 1: School Identity -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img src="{{ asset('assets/img/logo.svg') }}" alt="SMPN 3" width="44" height="44" class="bg-white p-1 rounded-circle">
                    <div>
                        <h5 class="text-white mb-0 fw-bold">PortalNilai-SMP3</h5>
                        <small class="text-white-50">SMP Negeri 3 Unggulan</small>
                    </div>
                </div>
                <p class="text-secondary small pe-lg-3">
                    Sistem informasi penilaian digital terpadu untuk kemudahan akses rekapitulasi nilai, jadwal ujian, dan transparansi akademik bagi seluruh sivitas sekolah.
                </p>
                <div class="d-flex gap-2 mt-3">
                    <span class="badge bg-secondary-subtle text-dark border">Cerdas</span>
                    <span class="badge bg-secondary-subtle text-dark border">Berkarakter</span>
                    <span class="badge bg-secondary-subtle text-dark border">Berprestasi</span>
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div class="col-lg-2 col-md-6 col-6">
                <h5>Menu Cepat</h5>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="{{ route('home') }}"><i class="bi bi-chevron-right me-1 text-primary"></i> Beranda</a></li>
                    <li><a href="{{ route('tentang') }}"><i class="bi bi-chevron-right me-1 text-primary"></i> Tentang Kami</a></li>
                    <li><a href="{{ route('nilai') }}"><i class="bi bi-chevron-right me-1 text-primary"></i> Hasil Ujian</a></li>
                    <li><a href="{{ route('jadwal') }}"><i class="bi bi-chevron-right me-1 text-primary"></i> Jadwal Ujian</a></li>
                    <li><a href="{{ route('guru') }}"><i class="bi bi-chevron-right me-1 text-primary"></i> Dewan Guru</a></li>

                    @if(session()->has('user'))
                        <li>
                            <a href="{{ route('nilai') }}" class="text-info fw-bold">
                                <i class="bi bi-pencil-square me-1"></i> Rekap Nilai Siswa
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'text-warning fw-bold' : '' }}">
                                <i class="bi bi-person-workspace me-1 text-primary"></i> Login Guru
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Col 3: Academic Information -->
            <div class="col-lg-3 col-md-6 col-6">
                <h5>Layanan Akademik</h5>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li><a href="{{ route('nilai') }}"><i class="bi bi-file-earmark-check me-1 text-info"></i> Rekapitulasi Nilai PAS/PTS</a></li>
                    <li><a href="{{ route('jadwal') }}"><i class="bi bi-clock-history me-1 text-info"></i> Kalender Ujian Semester</a></li>
                    <li><a href="javascript:void(0)" onclick="alert('Pendaftaran remedial mata pelajaran dikoordinasikan langsung melalui guru pengampu masing-masing.');"><i class="bi bi-arrow-repeat me-1 text-info"></i> Pendaftaran Remedial</a></li>
                    <li><a href="javascript:void(0)" onclick="alert('Layanan konseling akademik SMPN 3 tersedia setiap hari sekolah di ruang BK.');"><i class="bi bi-chat-dots me-1 text-info"></i> Konseling Akademik & BK</a></li>
                </ul>
            </div>

            <!-- Col 4: School Contact -->
            <div class="col-lg-3 col-md-6">
                <h5>Kontak Sekolah</h5>
                <ul class="list-unstyled d-flex flex-column gap-2 small text-secondary">
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-geo-alt-fill text-warning mt-1"></i>
                        <span>Jl. Pendidikan No. 45, Kompleks Pendidikan, Kota Pelajar</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-telephone-fill text-info"></i>
                        <span>(021) 7890-1234</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-envelope-fill text-success"></i>
                        <span>info@smpn3-unggulan.sch.id</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-globe text-primary"></i>
                        <span>www.smpn3-unggulan.sch.id</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sesi Status Bar if Logged In -->
        @if(session()->has('user'))
            <div class="mt-4 p-3 rounded-3 bg-dark bg-opacity-75 border border-secondary border-opacity-25 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <div class="d-flex align-items-center gap-2 small text-light">
                    <span class="badge {{ session('user.role') === 'guru' ? 'bg-success' : (session('user.role') === 'admin' ? 'bg-dark border' : 'bg-primary') }} text-uppercase">
                        {{ session('user.role') }}
                    </span>
                    <span>Anda terhubung sebagai: <strong>{{ session('user.name') }}</strong> (ID: {{ session('user.username') }})</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-3 rounded-pill">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout Sekarang
                    </button>
                </form>
            </div>
        @endif

        <!-- Footer Bottom -->
        <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-secondary small">
            <div>
                &copy; {{ date('Y') }} <strong>PortalNilai-SMP3</strong> - SMP Negeri 3 Unggulan. Hak Cipta Dilindungi.
            </div>
            <div class="mt-2 mt-md-0 d-flex gap-3">
                <span>Versi Sistem 2.4.0</span>
                <span>•</span>
                <span>Standar Kurikulum Merdeka</span>
            </div>
        </div>
    </div>
</footer>
