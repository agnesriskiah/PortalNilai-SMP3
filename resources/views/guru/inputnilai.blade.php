<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode === 'edit' ? 'Ubah Nilai Siswa' : 'Input Nilai Siswa Baru' }} - Ruang Kerja Guru | PortalNilai-SMP3</title>

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
        .form-card {
            border: 0;
            border-radius: 1.25rem;
            box-shadow: 0 4px 25px rgba(0,0,0,0.05);
        }
        .calc-preview-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #e0f2fe 100%);
            border: 2px dashed #0284c7;
            border-radius: 16px;
        }
        .student-avatar-big {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.4rem;
            flex-shrink: 0;
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <!-- Sidebar Guru Component -->
    @include('komponen_guru.sidebar_guru')

    <!-- Content Area -->
    <div class="content-area">
        <!-- Top Navbar -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 bg-white p-3 p-md-4 rounded-4 shadow-sm mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item"><a href="{{ route('guru.dashboard') }}" class="text-decoration-none text-muted">Dashboard Guru</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('guru.nilai') }}" class="text-decoration-none text-muted">Input & Nilai Siswa</a></li>
                        <li class="breadcrumb-item active text-success fw-bold" aria-current="page">
                            {{ $mode === 'edit' ? 'Form Edit Nilai' : 'Form Input Nilai Baru' }}
                        </li>
                    </ol>
                </nav>
                <h3 class="fw-bold text-dark mb-0">
                    <i class="bi {{ $mode === 'edit' ? 'bi-pencil-square text-primary' : 'bi-plus-circle-fill text-success' }} me-2"></i>
                    {{ $mode === 'edit' ? 'Ubah & Perbarui Nilai Siswa' : 'Input Nilai Siswa Baru' }}
                </h3>
                <small class="text-muted">Mata Pelajaran: <strong>{{ $mapelGuru }}</strong> • Standar KKM: <strong>75.0</strong> • Semester Ganjil TA 2024/2025</small>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('guru.nilai') }}" class="btn btn-outline-secondary rounded-pill px-3 py-2 small fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Tabel Nilai
                </a>
                <div class="d-flex align-items-center gap-2 border-start ps-3 ms-2">
                    <img src="{{ asset($activeUser->foto ?? 'assets/img/users/guru.svg') }}" alt="Avatar" width="40" height="40" class="rounded-circle border border-2 border-success">
                    <div class="d-none d-lg-block text-start">
                        <div class="fw-bold small text-dark lh-sm">{{ $activeUser->name }}</div>
                        <small class="text-success fw-semibold" style="font-size: 0.72rem;">{{ $activeUser->mapel ?? 'Matematika' }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Notification -->
        @include('components.notification')

        <!-- Main Form Card Container -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <div class="card form-card bg-white p-4 p-md-5 mb-5">
                    <!-- Form Header Banner -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-3 mb-4 border-bottom gap-2">
                        <div>
                            <span class="badge {{ $mode === 'edit' ? 'bg-primary-subtle text-primary' : 'bg-success-subtle text-success' }} fw-bold px-3 py-1 rounded-pill mb-2">
                                <i class="bi {{ $mode === 'edit' ? 'bi-pencil-fill' : 'bi-plus-circle' }} me-1"></i>
                                Mode: {{ $mode === 'edit' ? 'Perbarui Data Nilai' : 'Tambah Siswa & Nilai Baru' }}
                            </span>
                            <h4 class="fw-bold text-dark mb-1">
                                {{ $mode === 'edit' ? 'Lembar Evaluasi Nilai: ' . ($siswaEdit['nama'] ?? '') : 'Formulir Penilaian Siswa Baru' }}
                            </h4>
                            <p class="text-muted small mb-0">
                                Pastikan komponen nilai (Tugas, UTS, UAS) diisi dengan rentang angka 0 sampai 100. Sistem otomatis menghitung nilai akhir dan predikat.
                            </p>
                        </div>

                        @if($mode === 'edit')
                            <div class="d-flex gap-2">
                                <a href="{{ route('nilai.cetak', $siswaEdit['nisn']) }}" target="_blank" class="btn btn-outline-secondary rounded-pill px-3 py-2 small fw-semibold" title="Cetak Rapor">
                                    <i class="bi bi-printer me-1"></i> Cetak Rapor
                                </a>
                                <button type="button" class="btn btn-outline-danger rounded-pill px-3 py-2 small fw-semibold" data-bs-toggle="modal" data-bs-target="#modalHapusNilai">
                                    <i class="bi bi-trash me-1"></i> Hapus Nilai
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Main Form Input / Edit -->
                    <form action="{{ route('guru.nilai.simpan') }}" method="POST" id="formKelolaNilai">
                        @csrf
                        <input type="hidden" name="mode" value="{{ $mode }}">

                        <!-- SECTION 1: IDENTITAS SISWA -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark text-uppercase small mb-3">
                                <i class="bi bi-person-badge-fill text-primary me-2"></i>1. Identitas Peserta Didik
                            </h6>

                            @if($mode === 'edit')
                                <!-- Tampilan Identitas Siswa Mode Edit -->
                                <input type="hidden" name="nisn" value="{{ $siswaEdit['nisn'] }}">
                                <input type="hidden" name="nama" value="{{ $siswaEdit['nama'] }}">
                                <input type="hidden" name="kelas" value="{{ $siswaEdit['kelas'] }}">

                                <div class="p-3 bg-light rounded-4 border d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="student-avatar-big bg-primary text-white shadow-sm">
                                            {{ mb_substr($siswaEdit['nama'] ?? 'S', 0, 1) }}
                                        </div>
                                        <div>
                                            <h5 class="fw-bold text-dark mb-1">{{ $siswaEdit['nama'] }}</h5>
                                            <div class="text-muted small">
                                                <span class="me-3">NISN: <strong class="text-dark">{{ $siswaEdit['nisn'] }}</strong></span>
                                                <span class="me-3">NIS: <strong class="text-dark">{{ $siswaEdit['nis'] }}</strong></span>
                                                <span>Kelas: <span class="badge bg-primary">{{ $siswaEdit['kelas'] }}</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-md-end">
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-bold">
                                            <i class="bi bi-book-fill me-1"></i> {{ $mapelGuru }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <!-- Tampilan Identitas Siswa Mode Tambah Baru -->
                                <!-- Pilihan cepat jika memilih siswa terdaftar -->
                                @if(count($daftarSiswaTersedia) > 0)
                                    <div class="mb-3 p-3 bg-light rounded-3 border">
                                        <label class="form-label fw-bold small text-muted text-uppercase mb-1">
                                            <i class="bi bi-lightning-charge-fill text-warning me-1"></i> Pilih Cepat Siswa Terdaftar (Opsional)
                                        </label>
                                        <select id="pilihSiswaCepat" class="form-select">
                                            <option value="">-- Ketik manual atau pilih siswa dari daftar ini --</option>
                                            @foreach($daftarSiswaTersedia as $st)
                                                <option value="{{ $st['nisn'] }}" data-nama="{{ $st['nama'] }}" data-nis="{{ $st['nis'] }}" data-kelas="{{ $st['kelas'] }}">
                                                    {{ $st['nama'] }} (NISN: {{ $st['nisn'] }} - Kelas {{ $st['kelas'] }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted" style="font-size: 0.75rem;">Memilih siswa di atas akan otomatis mengisi nama, NISN, NIS, dan kelas di bawah ini.</small>
                                    </div>
                                @endif

                                <div class="row g-3">
                                    <div class="col-md-7">
                                        <label class="form-label fw-bold small text-uppercase text-secondary">
                                            Nama Lengkap Siswa <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
                                            <input type="text" name="nama" id="inputNama" class="form-control form-control-lg fs-6" placeholder="Contoh: Muhammad Farhan Pratama" required>
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <label class="form-label fw-bold small text-uppercase text-secondary">
                                            Rombel / Kelas <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="bi bi-door-closed"></i></span>
                                            <select name="kelas" id="inputKelas" class="form-select form-select-lg fs-6" required>
                                                <option value="7-A">Kelas 7-A</option>
                                                <option value="8-B">Kelas 8-B</option>
                                                <option value="9-A">Kelas 9-A</option>
                                                <option value="9-C">Kelas 9-C</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-uppercase text-secondary">
                                            NISN (10 Digit Nomor Induk Siswa Nasional) <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="bi bi-card-text"></i></span>
                                            <input type="text" name="nisn" id="inputNisn" class="form-control form-control-lg fs-6" placeholder="Contoh: 0089123888" maxlength="10" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-uppercase text-secondary">
                                            NIS (Nomor Induk Sekolah)
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="bi bi-hash"></i></span>
                                            <input type="text" name="nis" id="inputNis" class="form-control form-control-lg fs-6" placeholder="Contoh: 242507088">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- SECTION 2: INPUT NILAI 3 KOMPONEN -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold text-dark text-uppercase small mb-0">
                                    <i class="bi bi-bar-chart-steps text-success me-2"></i>2. Nilai Capaian Mata Pelajaran: {{ $mapelGuru }}
                                </h6>
                                <span class="badge bg-light text-dark border px-3 py-1 rounded-pill small">
                                    Bobot: Tugas 30% • UTS 30% • UAS 40%
                                </span>
                            </div>

                            <div class="row g-3">
                                <!-- Nilai Tugas -->
                                <div class="col-md-4">
                                    <div class="card border rounded-4 p-3 bg-light h-100">
                                        <label class="form-label fw-bold small text-uppercase text-dark mb-1">
                                            <i class="bi bi-journal-check text-primary me-1"></i> Nilai Tugas (30%)
                                        </label>
                                        <small class="text-muted d-block mb-2" style="font-size: 0.73rem;">Rata-rata tugas & ulangan harian</small>
                                        <div class="input-group">
                                            <input type="number" step="0.1" min="0" max="100" name="tugas" id="formTugas"
                                                   class="form-control form-control-lg fs-5 fw-bold text-center score-input"
                                                   value="{{ old('tugas', $siswaEdit['tugas'] ?? '80') }}" placeholder="0 - 100" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nilai UTS -->
                                <div class="col-md-4">
                                    <div class="card border rounded-4 p-3 bg-light h-100">
                                        <label class="form-label fw-bold small text-uppercase text-dark mb-1">
                                            <i class="bi bi-file-earmark-text text-warning me-1"></i> Nilai UTS (30%)
                                        </label>
                                        <small class="text-muted d-block mb-2" style="font-size: 0.73rem;">Penilaian Tengah Semester (PTS)</small>
                                        <div class="input-group">
                                            <input type="number" step="0.1" min="0" max="100" name="uts" id="formUts"
                                                   class="form-control form-control-lg fs-5 fw-bold text-center score-input"
                                                   value="{{ old('uts', $siswaEdit['uts'] ?? '80') }}" placeholder="0 - 100" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nilai UAS -->
                                <div class="col-md-4">
                                    <div class="card border rounded-4 p-3 bg-light h-100">
                                        <label class="form-label fw-bold small text-uppercase text-dark mb-1">
                                            <i class="bi bi-award-fill text-danger me-1"></i> Nilai UAS (40%)
                                        </label>
                                        <small class="text-muted d-block mb-2" style="font-size: 0.73rem;">Penilaian Akhir Semester (PAS)</small>
                                        <div class="input-group">
                                            <input type="number" step="0.1" min="0" max="100" name="uas" id="formUas"
                                                   class="form-control form-control-lg fs-5 fw-bold text-center score-input"
                                                   value="{{ old('uas', $siswaEdit['uas'] ?? '80') }}" placeholder="0 - 100" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: LIVE CALCULATION PREVIEW -->
                        <div class="calc-preview-card p-4 mb-4">
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-3 gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="p-2 bg-primary text-white rounded-circle fs-5">
                                        <i class="bi bi-calculator"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-0">Hasil Kalkulasi Otomatis Nilai Akhir</h6>
                                        <small class="text-muted">Dihitung otomatis saat Anda mengubah nilai di atas</small>
                                    </div>
                                </div>
                                <span class="badge bg-primary text-white px-3 py-2 rounded-pill small">
                                    Standar KKM: 75.0
                                </span>
                            </div>

                            <div class="row text-center g-3 align-items-center bg-white p-3 rounded-3 shadow-sm">
                                <div class="col-4 border-end">
                                    <small class="text-muted d-block fw-semibold" style="font-size: 0.75rem;">NILAI AKHIR</small>
                                    <span class="fs-2 fw-extrabold text-primary" id="previewNilaiAkhir">80.0</span>
                                </div>
                                <div class="col-4 border-end">
                                    <small class="text-muted d-block fw-semibold" style="font-size: 0.75rem;">PREDIKAT</small>
                                    <span class="badge bg-primary fs-5 px-3 py-2 mt-1" id="previewPredikat">B (Baik)</span>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block fw-semibold" style="font-size: 0.75rem;">STATUS KKM</small>
                                    <span class="badge bg-success fs-5 px-3 py-2 mt-1" id="previewStatus">Tuntas KKM</span>
                                </div>
                            </div>

                            <div class="mt-2 text-center small text-muted">
                                Rumus: <code>(30% &times; Nilai Tugas) + (30% &times; Nilai UTS) + (40% &times; Nilai UAS)</code>
                            </div>
                        </div>

                        <!-- SECTION 4: CATATAN GURU -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-secondary">
                                <i class="bi bi-chat-left-text-fill text-info me-1"></i> Catatan Guru / Ketercapaian Pembelajaran
                            </label>
                            <textarea name="catatan" id="formCatatan" rows="3" class="form-control"
                                      placeholder="Tuliskan catatan evaluasi belajar, apresiasi, atau tindak lanjut bimbingan remedial...">{{ old('catatan', $siswaEdit['catatan'] ?? 'Capaian kompetensi tuntas sesuai kriteria ketercapaian tujuan pembelajaran.') }}</textarea>
                            <small class="text-muted" style="font-size: 0.75rem;">Catatan ini akan tercetak pada buku transkrip/rapor resmi siswa.</small>
                        </div>

                        <!-- SECTION 5: TOMBOL AKSI SIMPAN & BATAL -->
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center pt-3 border-top gap-3">
                            <a href="{{ route('guru.nilai') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold w-100 w-sm-auto order-2 order-sm-1">
                                <i class="bi bi-arrow-left me-1"></i> Batal & Kembali
                            </a>

                            <div class="d-flex gap-2 w-100 w-sm-auto justify-content-end order-1 order-sm-2">
                                <button type="submit" class="btn btn-success fw-bold rounded-pill px-5 py-2 w-100 w-sm-auto shadow-sm">
                                    <i class="bi {{ $mode === 'edit' ? 'bi-check2-circle' : 'bi-save-fill' }} me-2"></i>
                                    {{ $mode === 'edit' ? 'Simpan Perubahan Nilai' : 'Simpan Nilai Siswa' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL KONFIRMASI HAPUS NILAI (JIKA MODE EDIT) -->
<!-- ============================================== -->
@if($mode === 'edit' && $siswaEdit)
    <div class="modal fade" id="modalHapusNilai" tabindex="-1" aria-labelledby="modalHapusNilaiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-danger text-white py-3 px-4">
                    <h5 class="modal-title fw-bold" id="modalHapusNilaiLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Hapus Nilai
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 text-center">
                    <div class="p-3 bg-danger-subtle text-danger rounded-circle d-inline-flex mb-3 fs-1">
                        <i class="bi bi-trash-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Hapus Data Nilai Siswa?</h5>
                    <p class="text-muted small mb-3">
                        Apakah Anda yakin ingin menghapus data nilai untuk siswa <strong>{{ $siswaEdit['nama'] }}</strong> (NISN: {{ $siswaEdit['nisn'] }}) pada mata pelajaran {{ $mapelGuru }}?
                    </p>
                    <div class="alert alert-warning small mb-0 text-start py-2 px-3">
                        <i class="bi bi-info-circle me-1"></i> Data nilai yang dihapus dapat dikembalikan kapan saja melalui tombol <strong>Reset</strong> di halaman tabel nilai.
                    </div>
                </div>

                <div class="modal-footer bg-light px-4 py-3 justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('guru.nilai.hapus', $siswaEdit['nisn']) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger fw-bold rounded-pill px-4">
                            <i class="bi bi-trash-fill me-1"></i> Ya, Hapus Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script Live Calculator & Auto-fill -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputTugas = document.getElementById('formTugas');
    const inputUts = document.getElementById('formUts');
    const inputUas = document.getElementById('formUas');
    const previewAkhir = document.getElementById('previewNilaiAkhir');
    const previewPredikat = document.getElementById('previewPredikat');
    const previewStatus = document.getElementById('previewStatus');

    // Live Calculation
    function calculateGrade() {
        const tugas = parseFloat(inputTugas ? inputTugas.value : 0) || 0;
        const uts = parseFloat(inputUts ? inputUts.value : 0) || 0;
        const uas = parseFloat(inputUas ? inputUas.value : 0) || 0;

        const akhir = Math.round(((tugas * 0.3) + (uts * 0.3) + (uas * 0.4)) * 10) / 10;
        let predikat = 'D (Kurang)';
        let predClass = 'bg-danger';

        if (akhir >= 90) {
            predikat = 'A (Sangat Baik)';
            predClass = 'bg-success';
        } else if (akhir >= 80) {
            predikat = 'B (Baik)';
            predClass = 'bg-primary';
        } else if (akhir >= 75) {
            predikat = 'C (Cukup)';
            predClass = 'bg-warning text-dark';
        } else {
            predikat = 'D (Kurang)';
            predClass = 'bg-danger';
        }

        const isTuntas = akhir >= 75;
        const statusText = isTuntas ? 'Tuntas KKM' : 'Perlu Remedial';
        const statusClass = isTuntas ? 'bg-success' : 'bg-danger';

        if (previewAkhir) previewAkhir.textContent = akhir.toFixed(1);
        if (previewPredikat) {
            previewPredikat.textContent = predikat;
            previewPredikat.className = 'badge fs-5 px-3 py-2 mt-1 ' + predClass;
        }
        if (previewStatus) {
            previewStatus.textContent = statusText;
            previewStatus.className = 'badge fs-5 px-3 py-2 mt-1 ' + statusClass;
        }
    }

    document.querySelectorAll('.score-input').forEach(el => {
        el.addEventListener('input', calculateGrade);
    });

    // Run initial calculation on page load
    calculateGrade();

    // Dropdown Pilih Siswa Cepat (Mode Tambah Baru)
    const selectSiswaCepat = document.getElementById('pilihSiswaCepat');
    if (selectSiswaCepat) {
        selectSiswaCepat.addEventListener('change', function () {
            const selectedOpt = this.options[this.selectedIndex];
            if (this.value) {
                const nama = selectedOpt.getAttribute('data-nama');
                const nis = selectedOpt.getAttribute('data-nis');
                const kelas = selectedOpt.getAttribute('data-kelas');
                const nisn = this.value;

                if (document.getElementById('inputNama')) document.getElementById('inputNama').value = nama;
                if (document.getElementById('inputNisn')) document.getElementById('inputNisn').value = nisn;
                if (document.getElementById('inputNis')) document.getElementById('inputNis').value = nis;
                if (document.getElementById('inputKelas')) document.getElementById('inputKelas').value = kelas;
            }
        });
    }
});
</script>

</body>
</html>
