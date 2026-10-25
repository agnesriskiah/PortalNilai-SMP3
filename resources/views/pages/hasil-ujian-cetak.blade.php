<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transkrip Nilai - {{ $siswa['nama'] }} ({{ $siswa['nisn'] }})</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #f8fafc;
        }
        .page-sheet {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 30px 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .kop-surat {
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .table-cetak th, .table-cetak td {
            border: 1px solid #000 !important;
            padding: 5px 8px;
            font-size: 11pt;
        }
        .table-cetak th {
            background-color: #f2f2f2 !important;
            text-align: center;
        }
        @media print {
            body {
                background: #fff;
            }
            .page-sheet {
                box-shadow: none;
                margin: 0;
                padding: 0;
                max-width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- Floating Top Bar for Print Action -->
    <div class="no-print bg-dark text-white py-2 px-3 sticky-top shadow-sm">
        <div class="container d-flex justify-content-between align-items-center" style="max-width: 800px;">
            <div>
                <a href="{{ route('nilai') }}" class="btn btn-sm btn-outline-light me-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <span class="small text-white-50">Pratinjau Lembar Hasil Ujian Siswa</span>
            </div>
            <button onclick="window.print()" class="btn btn-sm btn-primary fw-bold">
                <i class="bi bi-printer-fill me-1"></i> Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Official Paper Sheet -->
    <div class="page-sheet">
        <!-- Kop Surat Sekolah -->
        <div class="kop-surat d-flex align-items-center gap-3">
            <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo" width="75" height="75">
            <div class="text-center flex-grow-1">
                <h6 class="mb-0 text-uppercase fw-bold" style="font-size: 13pt;">Pemerintah Kota Pelajar • Dinas Pendidikan</h6>
                <h4 class="mb-0 text-uppercase fw-bold" style="font-size: 16pt;">{{ $profil['nama'] }}</h4>
                <p class="mb-0 small" style="font-size: 9pt;">{{ $profil['alamat'] }}</p>
                <p class="mb-0 small" style="font-size: 9pt;">Telp: {{ $profil['telepon'] }} • Email: {{ $profil['email'] }} • Web: {{ $profil['website'] }}</p>
            </div>
        </div>

        <!-- Judul Dokumen -->
        <div class="text-center mb-4">
            <h5 class="fw-bold text-uppercase mb-1" style="text-decoration: underline;">Laporan Hasil Ujian & Evaluasi Belajar</h5>
            <div class="small fw-bold">Semester: {{ $siswa['semester'] }}</div>
        </div>

        <!-- Identitas Siswa -->
        <div class="row g-2 mb-3" style="font-size: 11pt;">
            <div class="col-6">
                <table class="w-100">
                    <tr>
                        <td style="width: 120px;">Nama Siswa</td>
                        <td style="width: 10px;">:</td>
                        <td class="fw-bold">{{ $siswa['nama'] }}</td>
                    </tr>
                    <tr>
                        <td>NISN / NIS</td>
                        <td>:</td>
                        <td>{{ $siswa['nisn'] }} / {{ $siswa['nis'] }}</td>
                    </tr>
                    <tr>
                        <td>Kelas / Rombel</td>
                        <td>:</td>
                        <td>{{ $siswa['kelas'] }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-6">
                <table class="w-100">
                    <tr>
                        <td style="width: 120px;">Jenis Kelamin</td>
                        <td style="width: 10px;">:</td>
                        <td>{{ $siswa['jenis_kelamin'] }}</td>
                    </tr>
                    <tr>
                        <td>Wali Kelas</td>
                        <td>:</td>
                        <td>{{ $siswa['wali_kelas'] }}</td>
                    </tr>
                    <tr>
                        <td>Peringkat Kelas</td>
                        <td>:</td>
                        <td class="fw-bold">Peringkat {{ $siswa['peringkat'] }} dari {{ $siswa['total_siswa_kelas'] }} siswa</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Tabel Nilai -->
        <table class="table table-cetak mb-3">
            <thead>
                <tr>
                    <th style="width: 35px;">No</th>
                    <th>Mata Pelajaran</th>
                    <th style="width: 55px;">KKM</th>
                    <th style="width: 65px;">Tugas</th>
                    <th style="width: 65px;">UTS</th>
                    <th style="width: 65px;">UAS</th>
                    <th style="width: 75px;">Nilai Akhir</th>
                    <th style="width: 65px;">Predikat</th>
                    <th style="width: 85px;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa['nilai'] as $idx => $n)
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td>{{ $n['mapel'] }}</td>
                        <td class="text-center">{{ $n['kkm'] }}</td>
                        <td class="text-center">{{ $n['tugas'] }}</td>
                        <td class="text-center">{{ $n['uts'] }}</td>
                        <td class="text-center">{{ $n['uas'] }}</td>
                        <td class="text-center fw-bold">{{ $n['akhir'] }}</td>
                        <td class="text-center fw-bold">{{ $n['predikat'] }}</td>
                        <td class="text-center">{{ $n['status'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" class="text-end">Rata-Rata Nilai Keseluruhan:</th>
                    <th class="text-center">{{ $siswa['ringkasan']['rata_rata'] }}</th>
                    <th colspan="2" class="text-center">{{ $siswa['ringkasan']['status_kelulusan'] }}</th>
                </tr>
            </tfoot>
        </table>

        <!-- Catatan & Tanda Tangan -->
        <div class="p-2 border border-dark rounded mb-4 small">
            <strong>Catatan Wali Kelas:</strong> {{ $siswa['ringkasan']['keterangan'] }}
        </div>

        <div class="row text-center mt-4 signature-box">
            <div class="col-4">
                <p class="mb-5">Mengetahui,<br>Orang Tua / Wali Siswa</p>
                <p class="fw-bold text-decoration-underline mb-0">( ........................................ )</p>
            </div>
            <div class="col-4">
                <p class="mb-5">Wali Kelas,</p>
                <p class="fw-bold text-decoration-underline mb-0">{{ $siswa['wali_kelas'] }}</p>
                <small class="text-muted">NIP. Guru Pengampu</small>
            </div>
            <div class="col-4">
                <p class="mb-5">Kota Pelajar, {{ date('d F Y') }}<br>Kepala Sekolah,</p>
                <p class="fw-bold text-decoration-underline mb-0">{{ $profil['kepala_sekolah']['nama'] }}</p>
                <small class="text-muted">NIP. {{ $profil['kepala_sekolah']['nip'] }}</small>
            </div>
        </div>
    </div>

</body>
</html>
