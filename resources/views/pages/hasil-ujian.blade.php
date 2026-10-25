@extends('layouts.app')

@section('title', 'Hasil Ujian - PortalNilai-SMP3')

@section('content')
<!-- Header Banner -->
<section class="bg-primary text-white py-4" style="background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%) !important;">
    <div class="container text-center py-2">
        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold mb-2">Transparansi Akademik</span>
        <h1 class="fw-bold mb-1">Hasil Ujian & Evaluasi Siswa</h1>
        <p class="text-white-50 lead mx-auto mb-0" style="max-width: 650px; font-size: 1.05rem;">
            Cari dan tinjau rekapitulasi nilai Penilaian Akhir Semester (PAS) dan Ujian Tengah Semester (PTS) SMP Negeri 3.
        </p>
    </div>
</section>

<div class="container py-4">
    <!-- Search & Filter Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
        <form action="{{ route('nilai') }}" method="GET" class="row g-3 align-items-end">
            <!-- Keyword Search -->
            <div class="col-lg-6 col-md-7">
                <label class="form-label fw-bold text-dark small text-uppercase">
                    <i class="bi bi-search text-primary me-1"></i> Cari Berdasarkan NISN / NIS / Nama Siswa
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-person-badge"></i></span>
                    <input type="text" name="q" value="{{ $keyword ?? '' }}" class="form-control border-start-0" placeholder="Contoh: 0089123451 atau Aditya...">
                </div>
            </div>

            <!-- Kelas Filter -->
            <div class="col-lg-3 col-md-3">
                <label class="form-label fw-bold text-dark small text-uppercase">
                    <i class="bi bi-funnel text-primary me-1"></i> Tingkat / Kelas
                </label>
                <select name="kelas" class="form-select">
                    <option value="Semua" {{ ($kelas ?? '') === 'Semua' ? 'selected' : '' }}>Semua Kelas</option>
                    <option value="7" {{ ($kelas ?? '') === '7' ? 'selected' : '' }}>Tingkat 7 (Kelas 7)</option>
                    <option value="8" {{ ($kelas ?? '') === '8' ? 'selected' : '' }}>Tingkat 8 (Kelas 8)</option>
                    <option value="9" {{ ($kelas ?? '') === '9' ? 'selected' : '' }}>Tingkat 9 (Kelas 9)</option>
                    <option value="7-A" {{ ($kelas ?? '') === '7-A' ? 'selected' : '' }}>Kelas 7-A</option>
                    <option value="8-B" {{ ($kelas ?? '') === '8-B' ? 'selected' : '' }}>Kelas 8-B</option>
                    <option value="9-A" {{ ($kelas ?? '') === '9-A' ? 'selected' : '' }}>Kelas 9-A</option>
                    <option value="9-C" {{ ($kelas ?? '') === '9-C' ? 'selected' : '' }}>Kelas 9-C</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="col-lg-3 col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-portal-login flex-grow-1">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
                @if(!empty($keyword) || ($kelas ?? '') !== 'Semua')
                    <a href="{{ route('nilai') }}" class="btn btn-light border text-muted" title="Reset Pencarian">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>

        <!-- Quick Search Pill Shortcuts -->
        <div class="d-flex flex-wrap align-items-center gap-2 mt-3 pt-3 border-top">
            <small class="text-muted fw-semibold">Data Siswa Contoh:</small>
            <a href="{{ route('nilai', ['q' => '0089123451']) }}" class="badge bg-light text-primary border text-decoration-none">
                0089123451 (Aditya - 7A)
            </a>
            <a href="{{ route('nilai', ['q' => '0089123452']) }}" class="badge bg-light text-primary border text-decoration-none">
                0089123452 (Annisa - 7A)
            </a>
            <a href="{{ route('nilai', ['q' => '0078123488']) }}" class="badge bg-light text-primary border text-decoration-none">
                0078123488 (Bagas - 8B)
            </a>
            <a href="{{ route('nilai', ['q' => '0067123990']) }}" class="badge bg-light text-primary border text-decoration-none">
                0067123990 (Cantika - 9C)
            </a>
        </div>
    </div>

    <!-- Hasil Pencarian -->
    @if(count($hasilPencarian) > 0)
        @foreach($hasilPencarian as $siswa)
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-white">
                <!-- Header Kartu Siswa -->
                <div class="card-header bg-white p-4 border-bottom">
                    <div class="row align-items-center g-3">
                        <div class="col-md-7 d-flex align-items-center gap-3">
                            <div class="teacher-avatar bg-primary text-white m-0" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                {{ mb_substr($siswa['nama'], 0, 1) }}
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <h4 class="fw-bold text-dark mb-0">{{ $siswa['nama'] }}</h4>
                                    <span class="badge bg-primary">{{ $siswa['kelas'] }}</span>
                                </div>
                                <div class="text-muted small mt-1">
                                    <span class="me-3"><strong>NISN:</strong> {{ $siswa['nisn'] }}</span>
                                    <span class="me-3"><strong>NIS:</strong> {{ $siswa['nis'] }}</span>
                                    <span><strong>Wali Kelas:</strong> {{ $siswa['wali_kelas'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action buttons: Print & Semester -->
                        <div class="col-md-5 text-md-end">
                            <span class="badge bg-light text-dark border p-2 me-2 mb-2 mb-md-0 d-inline-block">
                                <i class="bi bi-calendar-event me-1 text-primary"></i> {{ $siswa['semester'] }}
                            </span>
                            <a href="{{ route('nilai.cetak', ['nisn' => $siswa['nisn']]) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill fw-semibold">
                                <i class="bi bi-printer me-1"></i> Cetak Rapor
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Kartu Metrik Ringkasan Nilai -->
                <div class="bg-light p-3 border-bottom">
                    <div class="row g-2 text-center">
                        <div class="col-6 col-md-3">
                            <div class="stat-box py-2">
                                <small class="text-muted d-block">Rata-Rata Nilai</small>
                                <span class="fs-4 fw-extrabold text-primary">{{ $siswa['ringkasan']['rata_rata'] }}</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box py-2">
                                <small class="text-muted d-block">Peringkat Kelas</small>
                                <span class="fs-4 fw-extrabold text-info">#{{ $siswa['peringkat'] }} <small class="fs-6 text-muted">/ {{ $siswa['total_siswa_kelas'] }}</small></span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box py-2">
                                <small class="text-muted d-block">Status Remedial</small>
                                @if($siswa['ringkasan']['jumlah_remedial'] == 0)
                                    <span class="badge bg-success-subtle text-success fs-6 fw-bold mt-1">Tidak Ada</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger fs-6 fw-bold mt-1">{{ $siswa['ringkasan']['jumlah_remedial'] }} Mapel</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box py-2">
                                <small class="text-muted d-block">Status Akademik</small>
                                <span class="badge {{ $siswa['ringkasan']['jumlah_remedial'] == 0 ? 'bg-success' : 'bg-warning text-dark' }} fs-6 mt-1">
                                    {{ $siswa['ringkasan']['status_kelulusan'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Rincian Nilai -->
                <div class="table-responsive">
                    <table class="table table-portal mb-0 align-middle">
                        <thead>
                            <tr>
                                <th style="width: 50px;" class="text-center">No</th>
                                <th>Mata Pelajaran & Guru Pengampu</th>
                                <th class="text-center" style="width: 70px;">KKM</th>
                                <th class="text-center" style="width: 80px;">Tugas</th>
                                <th class="text-center" style="width: 80px;">UTS</th>
                                <th class="text-center" style="width: 80px;">UAS</th>
                                <th class="text-center" style="width: 90px;">Nilai Akhir</th>
                                <th class="text-center" style="width: 80px;">Predikat</th>
                                <th class="text-center" style="width: 120px;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa['nilai'] as $idx => $n)
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $idx + 1 }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $n['mapel'] }}</div>
                                        <small class="text-muted"><i class="bi bi-person me-1"></i>{{ $n['guru'] }}</small>
                                    </td>
                                    <td class="text-center fw-semibold">{{ $n['kkm'] }}</td>
                                    <td class="text-center">{{ $n['tugas'] }}</td>
                                    <td class="text-center">{{ $n['uts'] }}</td>
                                    <td class="text-center">{{ $n['uas'] }}</td>
                                    <td class="text-center">
                                        <span class="fw-bold fs-6 {{ $n['akhir'] >= $n['kkm'] ? 'text-primary' : 'text-danger' }}">
                                            {{ $n['akhir'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $n['predikat'] === 'A' ? 'badge-grade-a' : ($n['predikat'] === 'B' ? 'badge-grade-b' : 'badge-grade-c') }}">
                                            {{ $n['predikat'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($n['status'] === 'Lulus')
                                            <span class="badge-status-lulus small">
                                                <i class="bi bi-check-circle-fill"></i> Lulus
                                            </span>
                                        @else
                                            <span class="badge-status-remedial small">
                                                <i class="bi bi-exclamation-triangle-fill"></i> Remedial
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer Catatan Rapor -->
                <div class="card-footer bg-light p-3 border-top">
                    <div class="d-flex align-items-center gap-2 small text-muted">
                        <i class="bi bi-info-circle-fill text-primary"></i>
                        <span><strong>Catatan Evaluasi:</strong> {{ $siswa['ringkasan']['keterangan'] }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <!-- Empty State -->
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white my-4">
            <div class="feature-icon-wrapper bg-warning-subtle text-warning mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2.2rem;">
                <i class="bi bi-search"></i>
            </div>
            <h4 class="fw-bold text-dark">Data Nilai Siswa Tidak Ditemukan</h4>
            <p class="text-muted mx-auto mb-4" style="max-width: 500px;">
                Tidak ada data siswa yang cocok dengan kata kunci pencarian "{{ $keyword }}". Pastikan penulisan NISN atau Nama lengkap sudah benar.
            </p>
            <div>
                <a href="{{ route('nilai') }}" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Nilai Lengkap
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
