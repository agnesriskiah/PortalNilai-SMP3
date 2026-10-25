@extends('layouts.app')

@section('title', 'Jadwal Ujian - PortalNilai-SMP3')

@section('content')
<!-- Header Banner -->
<section class="bg-primary text-white py-4" style="background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%) !important;">
    <div class="container text-center py-2">
        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold mb-2">Agenda Evaluasi</span>
        <h1 class="fw-bold mb-1">Jadwal Ujian & Penilaian Siswa</h1>
        <p class="text-white-50 lead mx-auto mb-0" style="max-width: 650px; font-size: 1.05rem;">
            Jadwal Penilaian Akhir Semester (PAS) & Ujian Berbasis Komputer (CBT) SMP Negeri 3.
        </p>
    </div>
</section>

<div class="container py-4">
    <!-- Filter Tabs by Tingkat Kelas -->
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <!-- Filter Pills -->
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('jadwal', ['tingkat' => 'Semua']) }}"
                   class="btn btn-sm rounded-pill px-3 {{ $tingkat === 'Semua' ? 'btn-primary' : 'btn-light border' }}">
                    <i class="bi bi-grid-fill me-1"></i> Semua Tingkat
                </a>
                <a href="{{ route('jadwal', ['tingkat' => '7']) }}"
                   class="btn btn-sm rounded-pill px-3 {{ $tingkat === '7' ? 'btn-primary' : 'btn-light border' }}">
                    Kelas 7 (Tingkat VII)
                </a>
                <a href="{{ route('jadwal', ['tingkat' => '8']) }}"
                   class="btn btn-sm rounded-pill px-3 {{ $tingkat === '8' ? 'btn-primary' : 'btn-light border' }}">
                    Kelas 8 (Tingkat VIII)
                </a>
                <a href="{{ route('jadwal', ['tingkat' => '9']) }}"
                   class="btn btn-sm rounded-pill px-3 {{ $tingkat === '9' ? 'btn-primary' : 'btn-light border' }}">
                    Kelas 9 (Tingkat IX)
                </a>
            </div>

            <!-- Print / Download schedule button -->
            <button onclick="window.print()" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                <i class="bi bi-printer me-1"></i> Cetak Jadwal
            </button>
        </div>
    </div>

    <!-- Alert Tata Tertib Ujian -->
    <div class="alert alert-info border-0 rounded-4 shadow-sm p-4 mb-4 d-flex align-items-start gap-3">
        <i class="bi bi-info-circle-fill fs-3 text-info mt-1"></i>
        <div>
            <h6 class="fw-bold text-dark mb-1">Tata Tertib Peserta Ujian Semester:</h6>
            <ul class="mb-0 small text-secondary ps-3">
                <li>Siswa wajib hadir di ruang ujian 15 menit sebelum bel tanda ujian dibunyikan.</li>
                <li>Membawa kartu tanda peserta ujian resmi dan seragam lengkap sesuai hari pelaksanaan.</li>
                <li>Dilarang keras membawa gawai/HP dan alat komunikasi ke dalam ruang ujian kecuali pada ujian CBT di lab komputer.</li>
            </ul>
        </div>
    </div>

    <!-- Jadwal Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-5">
        <div class="card-header bg-white p-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark mb-0">
                <i class="bi bi-calendar3 text-primary me-2"></i>
                Daftar Pelaksanaan Ujian
                @if($tingkat !== 'Semua')
                    <span class="badge bg-primary ms-1">Tingkat {{ $tingkat }}</span>
                @endif
            </h5>
            <small class="text-muted">Total: {{ count($jadwal) }} Sesi Ujian</small>
        </div>

        <div class="table-responsive">
            <table class="table table-portal mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>Hari & Tanggal</th>
                        <th>Waktu Pelaksanaan</th>
                        <th>Tingkat Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Ruangan</th>
                        <th>Pengawas Ujian</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal as $index => $item)
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item['hari'] }}</div>
                                <small class="text-muted">{{ $item['tanggal'] }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="bi bi-clock me-1 text-primary"></i> {{ $item['waktu'] }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-primary">{{ $item['kelas'] }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark fs-6">{{ $item['mapel'] }}</div>
                                <small class="text-muted">{{ $item['tipe'] }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary-subtle text-dark border">
                                    <i class="bi bi-door-open me-1"></i> {{ $item['ruang'] }}
                                </span>
                            </td>
                            <td>
                                <small class="text-secondary fw-semibold">{{ $item['pengawas'] }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info-subtle text-info fw-bold px-3 py-2 rounded-pill">
                                    {{ $item['status'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                Tidak ada jadwal ujian untuk kriteria yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
