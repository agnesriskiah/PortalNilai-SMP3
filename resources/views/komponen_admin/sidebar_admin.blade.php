<!-- Sidebar Admin Component -->
@php
    $admin = auth()->user() ?? (object) session('user');
    $adminFoto = $admin->foto ?? 'assets/img/users/admin.svg';
@endphp

<div class="sidebar-admin d-flex flex-column flex-shrink-0 p-3 bg-dark text-white min-vh-100 shadow" style="width: 280px; background: linear-gradient(180deg, #0b1329 0%, #0f172a 100%) !important;">
    <!-- Brand Header -->
    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none border-bottom border-secondary pb-3 w-100 gap-2">
        <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo SMPN 3" width="42" height="42" class="bg-white p-1 rounded-circle">
        <div>
            <div class="fw-bold fs-6 lh-sm text-warning">PortalNilai-SMP3</div>
            <small class="text-white-50" style="font-size: 0.72rem;">PANEL ADMINISTRATOR</small>
        </div>
    </a>

    <!-- Admin Profile Badge -->
    <div class="my-3 p-3 rounded-3 bg-secondary bg-opacity-25 border border-secondary border-opacity-50">
        <div class="d-flex align-items-center gap-2">
            <img src="{{ asset($adminFoto) }}" alt="{{ $admin->name }}" width="48" height="48" class="rounded-circle border border-2 border-warning p-0 bg-white">
            <div class="overflow-hidden">
                <span class="badge bg-danger text-uppercase fw-bold px-2 py-0" style="font-size: 0.65rem;">Admin IT</span>
                <strong class="d-block text-truncate text-white small fw-bold mt-1">{{ $admin->name }}</strong>
                <small class="text-white-50 d-block text-truncate" style="font-size: 0.72rem;">NIP: {{ $admin->nip ?? '-' }}</small>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="text-uppercase text-secondary fw-bold px-2 mb-2" style="font-size: 0.68rem; letter-spacing: 0.05rem;">
        Menu Utama Admin
    </div>

    <ul class="nav nav-pills flex-column mb-auto gap-1">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : '' }} d-flex align-items-center gap-2 py-2 px-3 rounded-3">
                <i class="bi bi-speedometer2 text-warning fs-5"></i>
                <span>Dashboard Utama</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('nilai') }}" class="nav-link text-white {{ request()->routeIs('nilai*') ? 'active bg-primary' : '' }} d-flex align-items-center gap-2 py-2 px-3 rounded-3">
                <i class="bi bi-file-earmark-spreadsheet text-info fs-5"></i>
                <span>Data & Rapor Nilai</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('jadwal') }}" class="nav-link text-white {{ request()->routeIs('jadwal*') ? 'active bg-primary' : '' }} d-flex align-items-center gap-2 py-2 px-3 rounded-3">
                <i class="bi bi-calendar-check text-success fs-5"></i>
                <span>Jadwal Ujian Sekolah</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.guru') }}" class="nav-link text-white {{ request()->routeIs('admin.guru*') ? 'active bg-primary' : '' }} d-flex align-items-center gap-2 py-2 px-3 rounded-3">
                <i class="bi bi-people-fill text-warning fs-5"></i>
                <span>Data Guru & Tenaga</span>
            </a>
        </li>

        <li class="border-top border-secondary my-2"></li>

        <div class="text-uppercase text-secondary fw-bold px-2 mb-1" style="font-size: 0.68rem; letter-spacing: 0.05rem;">
            Akses Publik & Pengaturan
        </div>

        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link text-white-50 d-flex align-items-center gap-2 py-2 px-3 rounded-3 hover-white">
                <i class="bi bi-globe2 text-secondary fs-5"></i>
                <span>Lihat Web Publik</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('tentang') }}" class="nav-link text-white-50 d-flex align-items-center gap-2 py-2 px-3 rounded-3 hover-white">
                <i class="bi bi-info-circle text-secondary fs-5"></i>
                <span>Profil SMPN 3</span>
            </a>
        </li>
    </ul>

    <!-- Logout Footer -->
    <div class="border-top border-secondary pt-3 mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2 py-2 rounded-3 fw-bold small">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar (Logout)</span>
            </button>
        </form>
    </div>
</div>
