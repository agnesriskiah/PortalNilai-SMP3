<!-- Main Navbar Komponen Website -->
<header class="sticky-top">
    <!-- Top notification banner for school info -->
    <div class="bg-dark text-white-50 py-1 px-3 d-none d-md-block" style="font-size: 0.8rem; background-color: #0b1329 !important;">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <span class="me-3"><i class="bi bi-geo-alt-fill text-warning me-1"></i> Jl. Pendidikan No. 45, Kota Pelajar</span>
                <span><i class="bi bi-telephone-fill text-info me-1"></i> (021) 7890-1234</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                @if(auth()->check() || session()->has('user'))
                    @php
                        $activeUser = auth()->user() ?? (object) session('user');
                    @endphp
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                        <i class="bi bi-circle-fill text-success me-1" style="font-size: 0.5rem;"></i> Sesi Aktif: {{ ucfirst($activeUser->role ?? 'User') }}
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
                    @if(auth()->check() || session()->has('user'))
                        @php
                            $user = auth()->user() ?? (object) session('user');
                            $userRole = $user->role ?? 'user';
                            $dashboardRoute = $userRole === 'admin' ? route('admin.dashboard') : route('guru.dashboard');
                            $userPhoto = $user->foto ?? ($userRole === 'admin' ? 'assets/img/users/admin.svg' : 'assets/img/users/guru.svg');
                        @endphp
                        <!-- User Profile Dropdown when Logged In -->
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center gap-2 py-2 px-3 rounded-3 shadow-sm bg-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset($userPhoto) }}" alt="{{ $user->name }}" width="28" height="28" class="rounded-circle border">
                                <span class="badge {{ $userRole === 'guru' ? 'bg-success' : 'bg-dark' }} text-uppercase">
                                    {{ $userRole }}
                                </span>
                                <span class="fw-semibold text-truncate text-dark" style="max-width: 150px;">
                                    {{ $user->name }}
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3 p-2" style="min-width: 250px;">
                                <li class="px-3 py-2 border-bottom mb-2 bg-light rounded-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset($userPhoto) }}" alt="{{ $user->name }}" width="40" height="40" class="rounded-circle border">
                                        <div class="overflow-hidden">
                                            <strong class="d-block text-truncate text-dark">{{ $user->name }}</strong>
                                            <span class="badge {{ $userRole === 'guru' ? 'bg-success' : 'bg-dark' }} text-uppercase small" style="font-size: 0.65rem;">
                                                {{ $userRole }}
                                            </span>
                                            <small class="text-muted d-block text-truncate">ID: {{ $user->username ?? $user->email }}</small>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <a class="dropdown-item py-2 rounded-2 fw-semibold text-primary" href="{{ $dashboardRoute }}">
                                        <i class="bi bi-speedometer2 me-2"></i> Buka Dashboard ({{ ucfirst($userRole) }})
                                    </a>
                                </li>

                                @if($userRole === 'guru')
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
                                @else
                                    <li>
                                        <a class="dropdown-item py-2 rounded-2" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-shield-lock me-2 text-dark"></i> Panel Administrasi
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 rounded-2" href="{{ route('nilai') }}">
                                            <i class="bi bi-award me-2 text-info"></i> Seluruh Nilai Siswa
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
                        <!-- Button Login -->
                        <a href="{{ route('login') }}" class="btn btn-portal-login d-flex align-items-center gap-2 {{ request()->routeIs('login') ? 'border border-2 border-warning shadow' : '' }}">
                            <i class="bi bi-box-arrow-in-right fs-6"></i>
                            <span>Login Portal</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</header>
