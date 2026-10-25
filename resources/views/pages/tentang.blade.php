@extends('layouts.app')

@section('title', 'Tentang Kami - PortalNilai-SMP3')

@section('content')
<!-- Header Banner -->
<section class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%) !important;">
    <div class="container text-center py-2">
        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold mb-2">Profil Sekolah</span>
        <h1 class="fw-bold mb-2">Tentang SMP Negeri 3 Unggulan</h1>
        <p class="text-white-50 lead mx-auto" style="max-width: 650px;">
            Mengenal lebih dekat institusi pendidikan pencetak generasi cerdas, berkarakter mulia, dan berprestasi tingkat nasional.
        </p>
    </div>
</section>

<!-- Sambutan Kepala Sekolah -->
<section class="py-5">
    <div class="container">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
            <div class="row g-0 align-items-center">
                <div class="col-md-4 bg-light text-center p-5 border-end">
                    <div class="teacher-avatar bg-primary mx-auto mb-3" style="width: 100px; height: 100px; font-size: 2.5rem;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">{{ $profil['kepala_sekolah']['nama'] }}</h5>
                    <div class="text-primary fw-semibold small mb-2">Kepala SMP Negeri 3</div>
                    <span class="badge bg-secondary-subtle text-secondary">NIP: {{ $profil['kepala_sekolah']['nip'] }}</span>
                </div>
                <div class="col-md-8 p-4 p-lg-5">
                    <span class="badge bg-primary-subtle text-primary fw-bold mb-2">Kata Sambutan</span>
                    <h3 class="fw-bold text-dark mb-3">Selamat Datang di Portal Penilaian Digital</h3>
                    <p class="text-muted leading-relaxed mb-4">
                        "{{ $profil['kepala_sekolah']['sambutan'] }}"
                    </p>
                    <p class="text-muted small mb-0">
                        Melalui portal ini, orang tua siswa dapat memantau grafik perkembangan akademis putra-putrinya secara berkesinambungan tanpa terbatas ruang dan waktu. Kolaborasi antara sekolah dan orang tua adalah kunci sukses pendidikan generasi penerus bangsa.
                    </p>
                </div>
            </div>
        </div>

        <!-- Visi & Misi -->
        <div class="row g-4 mb-5">
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white border-top border-4 border-primary">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-eye-fill fs-3 text-primary"></i>
                        <h4 class="fw-bold text-dark mb-0">Visi Sekolah</h4>
                    </div>
                    <p class="lead text-primary fw-bold fst-italic mb-3">
                        "{{ $profil['visi'] }}"
                    </p>
                    <p class="text-muted small">
                        Visi ini menjadi kompas bagi seluruh warga sekolah dalam menjalankan setiap program pembelajaran, ekstrakurikuler, dan tata kelola lingkungan sekolah.
                    </p>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white border-top border-4 border-info">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-bullseye fs-3 text-info"></i>
                        <h4 class="fw-bold text-dark mb-0">Misi Sekolah</h4>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        @foreach($profil['misi'] as $idx => $misi)
                            <div class="d-flex align-items-start gap-3">
                                <span class="badge bg-info-subtle text-info rounded-circle px-2 py-1 fw-bold">{{ $idx + 1 }}</span>
                                <span class="text-muted small leading-relaxed">{{ $misi }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Sejarah Singkat -->
        <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5 mb-5 bg-white">
            <span class="badge bg-success-subtle text-success fw-bold mb-2 align-self-start">Napak Tilas</span>
            <h3 class="fw-bold text-dark mb-3">Sejarah Singkat SMP Negeri 3</h3>
            <p class="text-muted leading-relaxed mb-3">
                Didirikan sejak tahun 1985, SMP Negeri 3 telah bertransformasi menjadi salah satu sekolah rujukan berprestasi tinggi di kawasan regional. Berawal dari 6 ruang kelas sederhana, kini sekolah berkembang pesat dengan fasilitas modern berstandar nasional dan telah meluluskan ribuan alumni yang sukses di berbagai bidang.
            </p>
            <p class="text-muted leading-relaxed mb-0">
                Pada tahun 2024, SMP Negeri 3 resmi menerapkan Implementasi Kurikulum Merdeka secara menyeluruh, serta mengadopsi sistem digitalisasi sekolah terpadu termasuk PortalNilai-SMP3 untuk mewujudkan administrasi tanpa kertas (paperless) dan pembelajaran ramah lingkungan.
            </p>
        </div>

        <!-- Fasilitas Sekolah Grid -->
        <div class="mb-5">
            <div class="text-center mb-4">
                <span class="badge bg-warning-subtle text-warning fw-bold mb-2">Sarana & Prasarana</span>
                <h3 class="fw-bold text-dark">Fasilitas Penunjang Belajar</h3>
                <p class="text-muted small">Lingkungan belajar yang representatif dan kondusif bagi peserta didik</p>
            </div>

            <div class="row g-3">
                <div class="col-md-4 col-sm-6">
                    <div class="p-3 border rounded-3 bg-white d-flex align-items-center gap-3">
                        <div class="p-2 bg-primary-subtle text-primary rounded-3 fs-4"><i class="bi bi-display"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">Lab Komputer & CBT</h6>
                            <small class="text-muted">3 Ruangan, 120 Unit PC</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="p-3 border rounded-3 bg-white d-flex align-items-center gap-3">
                        <div class="p-2 bg-success-subtle text-success rounded-3 fs-4"><i class="bi bi-flask"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">Laboratorium IPA</h6>
                            <small class="text-muted">Fisika, Biologi, Kimia Dasar</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="p-3 border rounded-3 bg-white d-flex align-items-center gap-3">
                        <div class="p-2 bg-info-subtle text-info rounded-3 fs-4"><i class="bi bi-book-half"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">Perpustakaan Digital</h6>
                            <small class="text-muted">Ribuan Koleksi E-Book & Fisik</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="p-3 border rounded-3 bg-white d-flex align-items-center gap-3">
                        <div class="p-2 bg-warning-subtle text-warning rounded-3 fs-4"><i class="bi bi-dribbble"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">Gelanggang Olahraga</h6>
                            <small class="text-muted">Basket, Futsal, Voli, Badminton</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="p-3 border rounded-3 bg-white d-flex align-items-center gap-3">
                        <div class="p-2 bg-danger-subtle text-danger rounded-3 fs-4"><i class="bi bi-building"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">Aula Serbaguna</h6>
                            <small class="text-muted">Kapasitas 800 Orang</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="p-3 border rounded-3 bg-white d-flex align-items-center gap-3">
                        <div class="p-2 bg-emerald-subtle text-success rounded-3 fs-4"><i class="bi bi-moon-stars"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">Musholla As-Salam</h6>
                            <small class="text-muted">Pusat Ibadah & Kegiatan Rohis</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Akreditasi Card -->
        <div class="card bg-light border-0 rounded-4 p-4 text-center">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8">
                    <h4 class="fw-bold text-dark mb-1">Status Akreditasi Sekolah</h4>
                    <p class="text-muted mb-2">Terakreditasi <strong>A (Amat Baik)</strong> oleh Badan Akreditasi Nasional Sekolah/Madrasah (BAN-S/M)</p>
                    <span class="badge bg-success px-3 py-2 fs-6">Sertifikat Nomor: 123/BAN-SM/SK/2023</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
