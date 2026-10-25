<!-- Main Navbar -->
<header class="sticky-top">
    <!-- Top notification banner for school info -->
    <div class="bg-dark text-white-50 py-1 px-3 d-none d-md-block" style="font-size: 0.8rem; background-color: #0b1329 !important;">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <span class="me-3"><i class="bi bi-geo-alt-fill text-warning me-1"></i> Jl. Pendidikan No. 45, Kota Pelajar</span>
                <span><i class="bi bi-telephone-fill text-info me-1"></i> (021) 7890-1234</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                @if(session()->has('user'))
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                        <i class="bi bi-circle-fill text-success me-1" style="font-size: 0.5rem;"></i> Sesi Aktif: {{ ucfirst(session('user.role')) }}
                    </span>
                @else
                    <span class="badge bg-warning text-dark fw-bold me-2">Akreditasi A</span>
                    <span class="text-light">NPSN: 20103456</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-portal py-2 py-lg-3">
        <div class="container">
            <!-- Brand Logo & Name -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo SMP Negeri 3" width="48" height="48" class="d-inline-block">
                <div class="brand-text">
                    <h1>PortalNilai-SMP3</h1>
                    <span>SMP NEGERI 3 UNGGULAN</span>
                </div>
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPortalContent" aria-controls="navbarPortalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Links & Action Button -->
            <div class="collapse navbar-collapse" id="navbarPortalContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}" href="{{ route('tentang') }}">
                            <i class="bi bi-info-circle me-1"></i> Tentang Kami
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('nilai*') ? 'active' : '' }}" href="{{ route('nilai') }}">
                            <i class="bi bi-award me-1"></i> Hasil Ujian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('jadwal') ? 'active' : '' }}" href="{{ route('jadwal') }}">
                            <i class="bi bi-calendar3 me-1"></i> Jadwal Ujian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('guru') ? 'active' : '' }}" href="{{ route('guru') }}">
                            <i class="bi bi-people me-1"></i> Guru
                        </a>
                    </li>
                </ul>

                <!-- Button Login / User Profile Dropdown -->
                <div class="d-flex align-items-center gap-2 mt-2 mt-lg-0">
                    @if(session()->has('user'))
                        <!-- User Profile Dropdown when Logged In -->
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center gap-2 py-2 px-3 rounded-3 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="badge {{ session('user.role') === 'guru' ? 'bg-success' : (session('user.role') === 'admin' ? 'bg-dark' : 'bg-primary') }} text-uppercase">
                                    {{ session('user.role') }}
                                </span>
                                <span class="fw-semibold text-truncate" style="max-width: 150px;">
                                    {{ session('user.name') }}
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3 p-2" style="min-width: 250px;">
                                <li class="px-3 py-2 border-bottom mb-2 bg-light rounded-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="p-2 rounded-circle {{ session('user.role') === 'guru' ? 'bg-success-subtle text-success' : (session('user.role') === 'admin' ? 'bg-dark-subtle text-dark' : 'bg-primary-subtle text-primary') }} fs-5">
                                            <i class="bi {{ session('user.role') === 'guru' ? 'bi-person-workspace' : (session('user.role') === 'admin' ? 'bi-shield-lock-fill' : 'bi-mortarboard-fill') }}"></i>
                                        </div>
                                        <div class="overflow-hidden">
                                            <strong class="d-block text-truncate text-dark">{{ session('user.name') }}</strong>
                                            <span class="badge {{ session('user.role') === 'guru' ? 'bg-success' : (session('user.role') === 'admin' ? 'bg-dark' : 'bg-primary') }} text-uppercase small" style="font-size: 0.65rem;">
                                                {{ session('user.role') }}
                                            </span>
                                            <small class="text-muted d-block text-truncate">ID: {{ session('user.username') }}</small>
                                        </div>
                                    </div>
                                </li>

                                @if(session('user.role') === 'siswa')
                                    <li>
                                        <a class="dropdown-item py-2 rounded-2" href="{{ route('nilai', ['q' => session('user.username')]) }}">
                                            <i class="bi bi-file-earmark-text me-2 text-primary"></i> Rapor Nilai Saya
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 rounded-2" href="{{ route('jadwal') }}">
                                            <i class="bi bi-calendar-event me-2 text-info"></i> Jadwal Ujian Saya
                                        </a>
                                    </li>
                                @elseif(session('user.role') === 'guru')
                                    <li>
                                        <a class="dropdown-item py-2 rounded-2" href="{{ route('nilai') }}">
                                            <i class="bi bi-pencil-square me-2 text-success"></i> Rekapitulasi Nilai Siswa
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 rounded-2" href="{{ route('jadwal') }}">
                                            <i class="bi bi-clock-history me-2 text-warning"></i> Jadwal Mengawas Ujian
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 rounded-2" href="{{ route('guru') }}">
                                            <i class="bi bi-people me-2 text-primary"></i> Dewan Guru & Rekan
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item py-2 rounded-2" href="{{ route('nilai') }}">
                                            <i class="bi bi-speedometer2 me-2 text-dark"></i> Kelola Seluruh Nilai
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 rounded-2" href="{{ route('jadwal') }}">
                                            <i class="bi bi-calendar3 me-2 text-info"></i> Kelola Jadwal Ujian
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 rounded-2" href="{{ route('guru') }}">
                                            <i class="bi bi-person-lines-fill me-2 text-primary"></i> Kelola Data Guru
                                        </a>
                                    </li>
                                @endif

                                <li><hr class="dropdown-divider my-2"></li>

                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger rounded-2 fw-semibold">
                                            <i class="bi bi-box-arrow-right me-2"></i> Keluar (Logout)
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- Button Login (Khusus Guru) -->
                        <a href="{{ route('login') }}" class="btn btn-portal-login d-flex align-items-center gap-2 {{ request()->routeIs('login') ? 'border border-2 border-warning shadow' : '' }}">
                            <i class="bi bi-person-workspace fs-6"></i>
                            <span>Login Guru</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</header>
