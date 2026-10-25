@extends('layouts.app')

@section('title', 'Dewan Guru - PortalNilai-SMP3')

@section('content')
<!-- Header Banner -->
<section class="bg-primary text-white py-4" style="background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%) !important;">
    <div class="container text-center py-2">
        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold mb-2">Tenaga Pendidik</span>
        <h1 class="fw-bold mb-1">Dewan Guru SMP Negeri 3</h1>
        <p class="text-white-50 lead mx-auto mb-0" style="max-width: 650px; font-size: 1.05rem;">
            Daftar tenaga pendidik profesional, berdedikasi tinggi, dan bersertifikasi di SMP Negeri 3 Unggulan.
        </p>
    </div>
</section>

<div class="container py-4">
    <!-- Search & Filter Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
        <form action="{{ route('guru') }}" method="GET" class="row g-3 align-items-center">
            <!-- Search Keyword -->
            <div class="col-lg-7 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control border-start-0" placeholder="Cari nama guru, mata pelajaran, atau NIP...">
                </div>
            </div>

            <!-- Subject Select -->
            <div class="col-lg-3 col-md-4">
                <select name="mapel" class="form-select">
                    @foreach($daftarMapel as $m)
                        <option value="{{ $m }}" {{ ($mapel ?? 'Semua') === $m ? 'selected' : '' }}>
                            {{ $m === 'Semua' ? 'Semua Mata Pelajaran' : $m }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit & Reset -->
            <div class="col-lg-2 col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-portal-login flex-grow-1">
                    Cari Guru
                </button>
                @if(!empty($search) || ($mapel ?? 'Semua') !== 'Semua')
                    <a href="{{ route('guru') }}" class="btn btn-light border text-muted" title="Reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>

        <!-- Quick Subject Tag Pills -->
        <div class="d-flex flex-wrap gap-1 mt-3 pt-3 border-top">
            <small class="text-muted fw-semibold me-2 align-self-center">Pilihan Cepat:</small>
            @foreach(['Matematika', 'IPA', 'Bahasa Indonesia', 'Bahasa Inggris', 'Informatika'] as $quick)
                <a href="{{ route('guru', ['mapel' => $quick]) }}"
                   class="badge {{ ($mapel ?? '') === $quick ? 'bg-primary text-white' : 'bg-light text-dark border' }} text-decoration-none">
                    {{ $quick }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Teacher Cards Grid -->
    <div class="row g-4 mb-5">
        @forelse($guru as $item)
            <div class="col-lg-4 col-md-6">
                <div class="teacher-card p-4 h-100 d-flex flex-direction-column justify-content-between">
                    <div>
                        <!-- Avatar Badge -->
                        <div class="teacher-avatar {{ $item['avatar_color'] }}">
                            {{ mb_substr($item['nama'], 0, 1) }}
                        </div>

                        <!-- Name & Subject -->
                        <div class="text-center mb-3">
                            <h5 class="fw-bold text-dark mb-1">{{ $item['nama'] }}</h5>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 rounded-pill fw-semibold">
                                {{ $item['mapel'] }}
                            </span>
                        </div>

                        <!-- Info details -->
                        <div class="bg-light p-3 rounded-3 mb-3 small">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Jabatan:</span>
                                <span class="fw-semibold text-dark text-end" style="max-width: 65%;">{{ $item['jabatan'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">NIP:</span>
                                <span class="fw-semibold text-dark">{{ $item['nip'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Pendidikan:</span>
                                <span class="fw-semibold text-dark text-end" style="max-width: 65%;">{{ $item['pendidikan'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Pengalaman:</span>
                                <span class="fw-semibold text-dark">{{ $item['pengalaman'] }} Mengajar</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contact button -->
                    <div class="text-center pt-2">
                        <a href="mailto:{{ $item['email'] }}" class="btn btn-outline-secondary btn-sm rounded-pill w-100">
                            <i class="bi bi-envelope me-1"></i> Hubungi Guru
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                    <div class="feature-icon-wrapper bg-warning-subtle text-warning mx-auto mb-3" style="width: 70px; height: 70px; font-size: 2rem;">
                        <i class="bi bi-search"></i>
                    </div>
                    <h5 class="fw-bold">Guru Tidak Ditemukan</h5>
                    <p class="text-muted small mb-3">Tidak ada data dewan guru yang cocok dengan kata kunci atau filter mata pelajaran tersebut.</p>
                    <div>
                        <a href="{{ route('guru') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                            Tampilkan Semua Guru
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
