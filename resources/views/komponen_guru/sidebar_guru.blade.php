<!-- Sidebar Guru Component -->
@php
    $guru = auth()->user() ?? (object) session('user');
    $guruFoto = ($guru->foto && str_starts_with($guru->foto, 'foto_guru/'))
        ? route('guru.foto', $guru->id)
        : asset($guru->foto ?? 'assets/img/users/guru.svg');
@endphp

<div class="sidebar-guru d-flex flex-column flex-shrink-0 p-3 bg-dark text-white min-vh-100 shadow" style="width: 280px; background: linear-gradient(180deg, #064e3b 0%, #0f172a 100%) !important;">
    <!-- Brand Header -->
    <a href="{{ route('guru.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none border-bottom border-success border-opacity-50 pb-3 w-100 gap-2">
        <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo SMPN 3" width="42" height="42" class="bg-white p-1 rounded-circle">
        <div>
            <div class="fw-bold fs-6 lh-sm text-warning">PortalNilai-SMP3</div>
            <small class="text-white-50" style="font-size: 0.72rem;">PORTAL DEWAN GURU</small>
        </div>
    </a>

    <!-- Guru Profile Badge -->
    <div class="my-3 p-3 rounded-3 bg-success bg-opacity-20 border border-success border-opacity-50">
        <div class="d-flex align-items-center gap-2">
            <img src="{{ $guruFoto }}" alt="{{ $guru->name }}" width="48" height="48" class="rounded-circle border border-2 border-warning p-0 bg-white object-fit-cover">
            <div class="overflow-hidden">
                <span class="badge bg-success text-uppercase fw-bold px-2 py-0" style="font-size: 0.65rem;">Dewan Guru</span>
                <strong class="d-block text-truncate text-white small fw-bold mt-1">{{ $guru->name }}</strong>
                <small class="text-warning d-block text-truncate" style="font-size: 0.72rem;">{{ $guru->mapel ?? 'Matematika' }}</small>
                <small class="text-white-50 d-block text-truncate" style="font-size: 0.7rem;">NIP: {{ $guru->nip ?? '-' }}</small>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="text-uppercase text-white-50 fw-bold px-2 mb-2" style="font-size: 0.68rem; letter-spacing: 0.05rem;">
        Menu Kerja Guru
    </div>

    <ul class="nav nav-pills flex-column mb-auto gap-1">
        <li class="nav-item">
            <a href="{{ route('guru.dashboard') }}" class="nav-link text-white {{ request()->routeIs('guru.dashboard') ? 'active bg-success' : '' }} d-flex align-items-center gap-2 py-2 px-3 rounded-3">
                <i class="bi bi-speedometer2 text-warning fs-5"></i>
                <span>Dashboard Guru</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('guru.nilai') }}" class="nav-link text-white {{ request()->routeIs('guru.nilai*') ? 'active bg-success' : '' }} d-flex align-items-center gap-2 py-2 px-3 rounded-3">
                <i class="bi bi-pencil-square text-info fs-5"></i>
                <span>Input & Nilai Siswa</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('jadwal') }}" class="nav-link text-white {{ request()->routeIs('jadwal*') ? 'active bg-success' : '' }} d-flex align-items-center gap-2 py-2 px-3 rounded-3">
                <i class="bi bi-clock-history text-warning fs-5"></i>
                <span>Jadwal Mengawas Ujian</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('guru') }}" class="nav-link text-white {{ request()->routeIs('guru*') ? 'active bg-success' : '' }} d-flex align-items-center gap-2 py-2 px-3 rounded-3">
                <i class="bi bi-people-fill text-light fs-5"></i>
                <span>Rekan Dewan Guru</span>
            </a>
        </li>

        <li class="border-top border-secondary border-opacity-50 my-2"></li>

        <div class="text-uppercase text-white-50 fw-bold px-2 mb-1" style="font-size: 0.68rem; letter-spacing: 0.05rem;">
            Akses Publik
        </div>

        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link text-white-50 d-flex align-items-center gap-2 py-2 px-3 rounded-3 hover-white">
                <i class="bi bi-globe2 text-secondary fs-5"></i>
                <span>Halaman Beranda</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('tentang') }}" class="nav-link text-white-50 d-flex align-items-center gap-2 py-2 px-3 rounded-3 hover-white">
                <i class="bi bi-info-circle text-secondary fs-5"></i>
                <span>Tentang Sekolah</span>
            </a>
        </li>
    </ul>

    <!-- Logout Footer -->
    <div class="border-top border-secondary border-opacity-50 pt-3 mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2 py-2 rounded-3 fw-bold small">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar (Logout)</span>
            </button>
        </form>
    </div>
</div>
