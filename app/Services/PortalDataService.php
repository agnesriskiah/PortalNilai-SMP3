<?php

namespace App\Services;

class PortalDataService
{
    /**
     * Profil Sekolah SMP Negeri 3
     */
    public function getProfilSekolah(): array
    {
        return [
            'nama' => 'SMP Negeri 3 Unggulan',
            'singkatan' => 'SMPN 3',
            'npsn' => '20103456',
            'akreditasi' => 'A (Amat Baik - BAN-S/M)',
            'motto' => 'Cerdas, Berkarakter, Berprestasi, dan Berwawasan Lingkungan',
            'alamat' => 'Jl. Pendidikan No. 45, Kompleks Pendidikan, Kota Pelajar',
            'telepon' => '(021) 7890-1234',
            'email' => 'info@smpn3-unggulan.sch.id',
            'website' => 'portalnilai.smpn3.sch.id',
            'kepala_sekolah' => [
                'nama' => 'Drs. H. Bambang Sudarmono, M.Pd.',
                'nip' => '19680512 199303 1 004',
                'sambutan' => 'Selamat datang di Portal Nilai Resmi SMP Negeri 3. Platform digital ini dibangun untuk mewujudkan transparansi, akuntabilitas, dan kemudahan akses informasi hasil belajar bagi seluruh peserta didik dan orang tua/wali siswa.',
            ],
            'visi' => 'Terwujudnya peserta didik yang religius, unggul dalam prestasi akademik dan non-akademik, berkarakter profil pelajar Pancasila, serta peduli lingkungan.',
            'misi' => [
                'Menyelenggarakan proses pembelajaran yang inovatif, berdiferensiasi, dan berbasis teknologi informasi.',
                'Menumbuhkembangkan keimanan, ketaqwaan, budi pekerti luhur, dan disiplin tinggi.',
                'Meningkatkan kompetensi dan daya saing akademik serta non-akademik di tingkat daerah dan nasional.',
                'Mewujudkan sistem evaluasi dan pelaporan hasil belajar yang transparan, akuntabel, dan real-time.',
                'Menciptakan lingkungan sekolah yang asri, aman, nyaman, dan ramah anak.'
            ],
            'statistik' => [
                'siswa_aktif' => 864,
                'guru_staff' => 48,
                'rombongan_belajar' => 24,
                'tingkat_kelulusan' => '100%',
                'rata_rata_sekolah' => 86.4
            ]
        ];
    }

    /**
     * Data Pengumuman Terbaru
     */
    public function getPengumuman(): array
    {
        return [
            [
                'id' => 1,
                'judul' => 'Pengumuman Hasil Penilaian Akhir Semester (PAS) Ganjil TA 2024/2025',
                'tanggal' => '20 Oktober 2026',
                'kategori' => 'Akademik',
                'ringkasan' => 'Hasil Penilaian Akhir Semester (PAS) Ganjil sudah dapat diakses online melalui portal ini dengan memasukkan NISN siswa.',
                'is_urgent' => true,
            ],
            [
                'id' => 2,
                'judul' => 'Jadwal Remedial & Pengayaan Mata Pelajaran Ujian',
                'tanggal' => '18 Oktober 2026',
                'kategori' => 'Jadwal',
                'ringkasan' => 'Bagi siswa dengan capaian nilai di bawah KKM (75), pelaksanaan remedial dijadwalkan mulai 28 Oktober 2026.',
                'is_urgent' => false,
            ],
            [
                'id' => 3,
                'judul' => 'Pembagian Rapor Resmi & Pertemuan Orang Tua Siswa',
                'tanggal' => '15 Oktober 2026',
                'kategori' => 'Informasi',
                'ringkasan' => 'Penerimaan Buku Rapor fisik semester ganjil akan diadakan pada Sabtu, 2 November 2026 di aula sekolah.',
                'is_urgent' => false,
            ]
        ];
    }

    /**
     * Ambil Seluruh Data Nilai Siswa dari Database MySQL (Tabel nilaisiswa)
     */
    public function getAllSiswaNilai(): array
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('nilaisiswa')) {
                $rows = \App\Models\NilaiSiswa::orderBy('kelas')->orderBy('nama')->get();
                if ($rows->count() > 0) {
                    $grouped = $rows->groupBy('nisn');
                    $result = [];
                    $counter = 1;
                    foreach ($grouped as $nisn => $items) {
                        $first = $items->first();
                        $nilaiList = [];
                        foreach ($items as $item) {
                            $nilaiList[] = [
                                'mapel' => $item->mapel,
                                'guru' => $item->guru,
                                'kkm' => (float) $item->kkm,
                                'tugas' => (float) $item->tugas,
                                'uts' => (float) $item->uts,
                                'uas' => (float) $item->uas,
                                'akhir' => (float) $item->akhir,
                                'predikat' => $item->predikat,
                                'status' => $item->status,
                                'catatan' => $item->catatan,
                            ];
                        }
                        $result[] = [
                            'nisn' => $first->nisn,
                            'nis' => $first->nis ?? '24250700' . $counter,
                            'nama' => $first->nama,
                            'kelas' => $first->kelas,
                            'tingkat' => $first->tingkat ?? substr($first->kelas, 0, 1),
                            'jenis_kelamin' => $first->jenis_kelamin ?? 'Laki-laki',
                            'semester' => $first->semester ?? 'Ganjil 2024/2025',
                            'wali_kelas' => $first->wali_kelas ?? 'Wali Kelas ' . $first->kelas,
                            'peringkat' => $counter,
                            'total_siswa_kelas' => 32,
                            'nilai' => $nilaiList,
                        ];
                        $counter++;
                    }
                    return $result;
                }
            }
        } catch (\Exception $e) {
            // Fallback ke mock jika database offline
        }

        return $this->getDefaultMockSiswaNilai();
    }

    /**
     * Database Mock Nilai Siswa (Data Awal / Fallback)
     */
    public function getDefaultMockSiswaNilai(): array
    {
        return [
            [
                'nisn' => '0089123451',
                'nis' => '242507001',
                'nama' => 'Aditya Pratama Putra',
                'kelas' => '7-A',
                'tingkat' => '7',
                'jenis_kelamin' => 'Laki-laki',
                'semester' => 'Ganjil 2024/2025',
                'wali_kelas' => 'Siti Rahmawati, S.Pd.',
                'peringkat' => 2,
                'total_siswa_kelas' => 32,
                'nilai' => [
                    ['mapel' => 'Pendidikan Agama & Budi Pekerti', 'guru' => 'Ust. Fauzan, S.Pd.I', 'kkm' => 75, 'tugas' => 90, 'uts' => 88, 'uas' => 92, 'akhir' => 90, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Pendidikan Pancasila & Kewarganegaraan', 'guru' => 'Dra. Endang Sulistyowati', 'kkm' => 75, 'tugas' => 85, 'uts' => 86, 'uas' => 88, 'akhir' => 87, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Bahasa Indonesia', 'guru' => 'Siti Rahmawati, S.Pd.', 'kkm' => 75, 'tugas' => 88, 'uts' => 85, 'uas' => 90, 'akhir' => 88, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Matematika', 'guru' => 'Hendro Prasetyo, M.Pd.', 'kkm' => 75, 'tugas' => 82, 'uts' => 80, 'uas' => 85, 'akhir' => 83, 'predikat' => 'B', 'status' => 'Lulus'],
                    ['mapel' => 'Ilmu Pengetahuan Alam (IPA)', 'guru' => 'Nurul Hidayah, S.Si.', 'kkm' => 75, 'tugas' => 86, 'uts' => 84, 'uas' => 88, 'akhir' => 86, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Ilmu Pengetahuan Sosial (IPS)', 'guru' => 'Drs. Ahmad Zaini', 'kkm' => 75, 'tugas' => 84, 'uts' => 82, 'uas' => 86, 'akhir' => 84, 'predikat' => 'B', 'status' => 'Lulus'],
                    ['mapel' => 'Bahasa Inggris', 'guru' => 'Ratna Sari, M.Pd.', 'kkm' => 75, 'tugas' => 92, 'uts' => 90, 'uas' => 94, 'akhir' => 92, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Informatika', 'guru' => 'Budi Santoso, S.Kom.', 'kkm' => 75, 'tugas' => 95, 'uts' => 92, 'uas' => 96, 'akhir' => 95, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Pendidikan Jasmani & Olahraga', 'guru' => 'Aris Munandar, S.Pd.', 'kkm' => 75, 'tugas' => 88, 'uts' => 86, 'uas' => 88, 'akhir' => 87, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Seni Budaya & Prakarya', 'guru' => 'Dewi Lestari, S.Sn.', 'kkm' => 75, 'tugas' => 85, 'uts' => 84, 'uas' => 86, 'akhir' => 85, 'predikat' => 'B', 'status' => 'Lulus'],
                ]
            ],
            [
                'nisn' => '0089123452',
                'nis' => '242507002',
                'nama' => 'Annisa Putri Ramadhani',
                'kelas' => '7-A',
                'tingkat' => '7',
                'jenis_kelamin' => 'Perempuan',
                'semester' => 'Ganjil 2024/2025',
                'wali_kelas' => 'Siti Rahmawati, S.Pd.',
                'peringkat' => 1,
                'total_siswa_kelas' => 32,
                'nilai' => [
                    ['mapel' => 'Pendidikan Agama & Budi Pekerti', 'guru' => 'Ust. Fauzan, S.Pd.I', 'kkm' => 75, 'tugas' => 95, 'uts' => 94, 'uas' => 96, 'akhir' => 95, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Pendidikan Pancasila & Kewarganegaraan', 'guru' => 'Dra. Endang Sulistyowati', 'kkm' => 75, 'tugas' => 92, 'uts' => 90, 'uas' => 93, 'akhir' => 92, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Bahasa Indonesia', 'guru' => 'Siti Rahmawati, S.Pd.', 'kkm' => 75, 'tugas' => 94, 'uts' => 92, 'uas' => 95, 'akhir' => 94, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Matematika', 'guru' => 'Hendro Prasetyo, M.Pd.', 'kkm' => 75, 'tugas' => 90, 'uts' => 92, 'uas' => 95, 'akhir' => 93, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Ilmu Pengetahuan Alam (IPA)', 'guru' => 'Nurul Hidayah, S.Si.', 'kkm' => 75, 'tugas' => 92, 'uts' => 90, 'uas' => 94, 'akhir' => 92, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Ilmu Pengetahuan Sosial (IPS)', 'guru' => 'Drs. Ahmad Zaini', 'kkm' => 75, 'tugas' => 88, 'uts' => 89, 'uas' => 91, 'akhir' => 90, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Bahasa Inggris', 'guru' => 'Ratna Sari, M.Pd.', 'kkm' => 75, 'tugas' => 96, 'uts' => 95, 'uas' => 98, 'akhir' => 96, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Informatika', 'guru' => 'Budi Santoso, S.Kom.', 'kkm' => 75, 'tugas' => 94, 'uts' => 92, 'uas' => 96, 'akhir' => 94, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Pendidikan Jasmani & Olahraga', 'guru' => 'Aris Munandar, S.Pd.', 'kkm' => 75, 'tugas' => 88, 'uts' => 85, 'uas' => 89, 'akhir' => 87, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Seni Budaya & Prakarya', 'guru' => 'Dewi Lestari, S.Sn.', 'kkm' => 75, 'tugas' => 92, 'uts' => 90, 'uas' => 93, 'akhir' => 92, 'predikat' => 'A', 'status' => 'Lulus'],
                ]
            ],
            [
                'nisn' => '0078123488',
                'nis' => '232408015',
                'nama' => 'Bagas Maulana Wijaya',
                'kelas' => '8-B',
                'tingkat' => '8',
                'jenis_kelamin' => 'Laki-laki',
                'semester' => 'Ganjil 2024/2025',
                'wali_kelas' => 'Hendro Prasetyo, M.Pd.',
                'peringkat' => 5,
                'total_siswa_kelas' => 34,
                'nilai' => [
                    ['mapel' => 'Pendidikan Agama & Budi Pekerti', 'guru' => 'Ust. Fauzan, S.Pd.I', 'kkm' => 75, 'tugas' => 85, 'uts' => 84, 'uas' => 86, 'akhir' => 85, 'predikat' => 'B', 'status' => 'Lulus'],
                    ['mapel' => 'Pendidikan Pancasila & Kewarganegaraan', 'guru' => 'Dra. Endang Sulistyowati', 'kkm' => 75, 'tugas' => 82, 'uts' => 80, 'uas' => 83, 'akhir' => 82, 'predikat' => 'B', 'status' => 'Lulus'],
                    ['mapel' => 'Bahasa Indonesia', 'guru' => 'Siti Rahmawati, S.Pd.', 'kkm' => 75, 'tugas' => 86, 'uts' => 84, 'uas' => 85, 'akhir' => 85, 'predikat' => 'B', 'status' => 'Lulus'],
                    ['mapel' => 'Matematika', 'guru' => 'Hendro Prasetyo, M.Pd.', 'kkm' => 75, 'tugas' => 74, 'uts' => 72, 'uas' => 73, 'akhir' => 73, 'predikat' => 'C', 'status' => 'Remedial'],
                    ['mapel' => 'Ilmu Pengetahuan Alam (IPA)', 'guru' => 'Nurul Hidayah, S.Si.', 'kkm' => 75, 'tugas' => 80, 'uts' => 78, 'uas' => 82, 'akhir' => 80, 'predikat' => 'B', 'status' => 'Lulus'],
                    ['mapel' => 'Ilmu Pengetahuan Sosial (IPS)', 'guru' => 'Drs. Ahmad Zaini', 'kkm' => 75, 'tugas' => 82, 'uts' => 80, 'uas' => 82, 'akhir' => 81, 'predikat' => 'B', 'status' => 'Lulus'],
                    ['mapel' => 'Bahasa Inggris', 'guru' => 'Ratna Sari, M.Pd.', 'kkm' => 75, 'tugas' => 84, 'uts' => 80, 'uas' => 82, 'akhir' => 82, 'predikat' => 'B', 'status' => 'Lulus'],
                    ['mapel' => 'Informatika', 'guru' => 'Budi Santoso, S.Kom.', 'kkm' => 75, 'tugas' => 90, 'uts' => 88, 'uas' => 92, 'akhir' => 90, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Pendidikan Jasmani & Olahraga', 'guru' => 'Aris Munandar, S.Pd.', 'kkm' => 75, 'tugas' => 92, 'uts' => 90, 'uas' => 92, 'akhir' => 91, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Seni Budaya & Prakarya', 'guru' => 'Dewi Lestari, S.Sn.', 'kkm' => 75, 'tugas' => 80, 'uts' => 79, 'uas' => 81, 'akhir' => 80, 'predikat' => 'B', 'status' => 'Lulus'],
                ]
            ],
            [
                'nisn' => '0067123990',
                'nis' => '222309005',
                'nama' => 'Cantika Zahra Aurelia',
                'kelas' => '9-C',
                'tingkat' => '9',
                'jenis_kelamin' => 'Perempuan',
                'semester' => 'Ganjil 2024/2025',
                'wali_kelas' => 'Nurul Hidayah, S.Si.',
                'peringkat' => 3,
                'total_siswa_kelas' => 32,
                'nilai' => [
                    ['mapel' => 'Pendidikan Agama & Budi Pekerti', 'guru' => 'Ust. Fauzan, S.Pd.I', 'kkm' => 75, 'tugas' => 92, 'uts' => 90, 'uas' => 92, 'akhir' => 91, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Pendidikan Pancasila & Kewarganegaraan', 'guru' => 'Dra. Endang Sulistyowati', 'kkm' => 75, 'tugas' => 88, 'uts' => 87, 'uas' => 89, 'akhir' => 88, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Bahasa Indonesia', 'guru' => 'Siti Rahmawati, S.Pd.', 'kkm' => 75, 'tugas' => 90, 'uts' => 88, 'uas' => 92, 'akhir' => 90, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Matematika', 'guru' => 'Hendro Prasetyo, M.Pd.', 'kkm' => 75, 'tugas' => 88, 'uts' => 86, 'uas' => 89, 'akhir' => 88, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Ilmu Pengetahuan Alam (IPA)', 'guru' => 'Nurul Hidayah, S.Si.', 'kkm' => 75, 'tugas' => 92, 'uts' => 90, 'uas' => 94, 'akhir' => 92, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Ilmu Pengetahuan Sosial (IPS)', 'guru' => 'Drs. Ahmad Zaini', 'kkm' => 75, 'tugas' => 87, 'uts' => 85, 'uas' => 88, 'akhir' => 87, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Bahasa Inggris', 'guru' => 'Ratna Sari, M.Pd.', 'kkm' => 75, 'tugas' => 94, 'uts' => 92, 'uas' => 95, 'akhir' => 94, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Informatika', 'guru' => 'Budi Santoso, S.Kom.', 'kkm' => 75, 'tugas' => 90, 'uts' => 89, 'uas' => 92, 'akhir' => 90, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Pendidikan Jasmani & Olahraga', 'guru' => 'Aris Munandar, S.Pd.', 'kkm' => 75, 'tugas' => 86, 'uts' => 85, 'uas' => 87, 'akhir' => 86, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Seni Budaya & Prakarya', 'guru' => 'Dewi Lestari, S.Sn.', 'kkm' => 75, 'tugas' => 90, 'uts' => 88, 'uas' => 91, 'akhir' => 90, 'predikat' => 'A', 'status' => 'Lulus'],
                ]
            ],
            [
                'nisn' => '0067123991',
                'nis' => '222309006',
                'nama' => 'Dimas Arya Yudhistira',
                'kelas' => '9-A',
                'tingkat' => '9',
                'jenis_kelamin' => 'Laki-laki',
                'semester' => 'Ganjil 2024/2025',
                'wali_kelas' => 'Ratna Sari, M.Pd.',
                'peringkat' => 8,
                'total_siswa_kelas' => 32,
                'nilai' => [
                    ['mapel' => 'Pendidikan Agama & Budi Pekerti', 'guru' => 'Ust. Fauzan, S.Pd.I', 'kkm' => 75, 'tugas' => 84, 'uts' => 82, 'uas' => 85, 'akhir' => 84, 'predikat' => 'B', 'status' => 'Lulus'],
                    ['mapel' => 'Pendidikan Pancasila & Kewarganegaraan', 'guru' => 'Dra. Endang Sulistyowati', 'kkm' => 75, 'tugas' => 82, 'uts' => 80, 'uas' => 84, 'akhir' => 82, 'predikat' => 'B', 'status' => 'Lulus'],
                    ['mapel' => 'Bahasa Indonesia', 'guru' => 'Siti Rahmawati, S.Pd.', 'kkm' => 75, 'tugas' => 83, 'uts' => 81, 'uas' => 84, 'akhir' => 83, 'predikat' => 'B', 'status' => 'Lulus'],
                    ['mapel' => 'Matematika', 'guru' => 'Hendro Prasetyo, M.Pd.', 'kkm' => 75, 'tugas' => 80, 'uts' => 78, 'uas' => 82, 'akhir' => 80, 'predikat' => 'B', 'status' => 'Lulus'],
                    ['mapel' => 'Ilmu Pengetahuan Alam (IPA)', 'guru' => 'Nurul Hidayah, S.Si.', 'kkm' => 75, 'tugas' => 82, 'uts' => 80, 'uas' => 83, 'akhir' => 82, 'predikat' => 'B', 'status' => 'Lulus'],
                    ['mapel' => 'Ilmu Pengetahuan Sosial (IPS)', 'guru' => 'Drs. Ahmad Zaini', 'kkm' => 75, 'tugas' => 80, 'uts' => 79, 'uas' => 82, 'akhir' => 80, 'predikat' => 'B', 'status' => 'Lulus'],
                    ['mapel' => 'Bahasa Inggris', 'guru' => 'Ratna Sari, M.Pd.', 'kkm' => 75, 'tugas' => 85, 'uts' => 83, 'uas' => 86, 'akhir' => 85, 'predikat' => 'B', 'status' => 'Lulus'],
                    ['mapel' => 'Informatika', 'guru' => 'Budi Santoso, S.Kom.', 'kkm' => 75, 'tugas' => 88, 'uts' => 86, 'uas' => 89, 'akhir' => 88, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Pendidikan Jasmani & Olahraga', 'guru' => 'Aris Munandar, S.Pd.', 'kkm' => 75, 'tugas' => 90, 'uts' => 88, 'uas' => 91, 'akhir' => 90, 'predikat' => 'A', 'status' => 'Lulus'],
                    ['mapel' => 'Seni Budaya & Prakarya', 'guru' => 'Dewi Lestari, S.Sn.', 'kkm' => 75, 'tugas' => 82, 'uts' => 80, 'uas' => 83, 'akhir' => 82, 'predikat' => 'B', 'status' => 'Lulus'],
                ]
            ]
        ];
    }

    /**
     * Hitung ringkasan nilai siswa
     */
    public function formatSiswaNilai(array $siswa): array
    {
        $totalNilai = 0;
        $count = count($siswa['nilai']);
        $remedialCount = 0;

        foreach ($siswa['nilai'] as $n) {
            $totalNilai += $n['akhir'];
            if ($n['status'] === 'Remedial' || $n['akhir'] < $n['kkm']) {
                $remedialCount++;
            }
        }

        $rataRata = $count > 0 ? round($totalNilai / $count, 1) : 0;
        $statusUmum = $remedialCount === 0 ? 'Lulus Sempurna' : ($remedialCount <= 2 ? 'Lulus Bersyarat (Ada Remedial)' : 'Perlu Bimbingan Khusus');

        $siswa['ringkasan'] = [
            'total_nilai' => $totalNilai,
            'rata_rata' => $rataRata,
            'jumlah_mapel' => $count,
            'jumlah_remedial' => $remedialCount,
            'status_kelulusan' => $statusUmum,
            'keterangan' => $remedialCount === 0 ? 'Selamat! Seluruh mata pelajaran telah mencapai dan melampaui KKM.' : "Terdapat {$remedialCount} mata pelajaran dengan nilai di bawah KKM. Harap menghubungi guru pengampu."
        ];

        return $siswa;
    }

    /**
     * Cari Siswa Berdasarkan NISN atau Nama
     */
    public function cariSiswa(?string $keyword, ?string $kelas = null): array
    {
        $all = $this->getAllSiswaNilai();
        $results = [];

        foreach ($all as $item) {
            $matchKeyword = true;
            $matchKelas = true;

            if ($keyword) {
                $keywordLower = strtolower(trim($keyword));
                $matchKeyword = str_contains(strtolower($item['nisn']), $keywordLower) ||
                                str_contains(strtolower($item['nis']), $keywordLower) ||
                                str_contains(strtolower($item['nama']), $keywordLower);
            }

            if ($kelas && $kelas !== 'Semua') {
                $matchKelas = ($item['kelas'] === $kelas || $item['tingkat'] === $kelas);
            }

            if ($matchKeyword && $matchKelas) {
                $results[] = $this->formatSiswaNilai($item);
            }
        }

        return $results;
    }

    /**
     * Ambil data satu siswa berdasarkan NISN
     */
    public function getSiswaByNisn(string $nisn): ?array
    {
        foreach ($this->getAllSiswaNilai() as $item) {
            if ($item['nisn'] === $nisn) {
                return $this->formatSiswaNilai($item);
            }
        }
        return null;
    }

    /**
     * Data Jadwal Ujian
     */
    public function getJadwalUjian(?string $tingkat = null): array
    {
        $jadwal = [
            [
                'id' => 1,
                'hari' => 'Senin',
                'tanggal' => '04 November 2026',
                'waktu' => '07.30 - 09.30 WIB',
                'tingkat' => '7',
                'kelas' => 'Kelas 7 (A, B, C, D)',
                'mapel' => 'Bahasa Indonesia',
                'ruang' => 'Ruang 01 - 04',
                'pengawas' => 'Drs. Ahmad Zaini & Ratna Sari, M.Pd.',
                'tipe' => 'Penilaian Akhir Semester (PAS)',
                'status' => 'Mendatang'
            ],
            [
                'id' => 2,
                'hari' => 'Senin',
                'tanggal' => '04 November 2026',
                'waktu' => '10.00 - 11.30 WIB',
                'tingkat' => '7',
                'kelas' => 'Kelas 7 (A, B, C, D)',
                'mapel' => 'Pendidikan Agama & Budi Pekerti',
                'ruang' => 'Ruang 01 - 04',
                'pengawas' => 'Siti Rahmawati, S.Pd. & Ust. Fauzan',
                'tipe' => 'Penilaian Akhir Semester (PAS)',
                'status' => 'Mendatang'
            ],
            [
                'id' => 3,
                'hari' => 'Selasa',
                'tanggal' => '05 November 2026',
                'waktu' => '07.30 - 09.30 WIB',
                'tingkat' => '7',
                'kelas' => 'Kelas 7 (A, B, C, D)',
                'mapel' => 'Matematika',
                'ruang' => 'Ruang 01 - 04',
                'pengawas' => 'Nurul Hidayah, S.Si. & Aris Munandar',
                'tipe' => 'Penilaian Akhir Semester (PAS)',
                'status' => 'Mendatang'
            ],
            [
                'id' => 4,
                'hari' => 'Selasa',
                'tanggal' => '05 November 2026',
                'waktu' => '10.00 - 11.30 WIB',
                'tingkat' => '7',
                'kelas' => 'Kelas 7 (A, B, C, D)',
                'mapel' => 'PPKn',
                'ruang' => 'Ruang 01 - 04',
                'pengawas' => 'Budi Santoso, S.Kom. & Dewi Lestari',
                'tipe' => 'Penilaian Akhir Semester (PAS)',
                'status' => 'Mendatang'
            ],
            [
                'id' => 5,
                'hari' => 'Senin',
                'tanggal' => '04 November 2026',
                'waktu' => '07.30 - 09.30 WIB',
                'tingkat' => '8',
                'kelas' => 'Kelas 8 (A, B, C, D)',
                'mapel' => 'Ilmu Pengetahuan Alam (IPA)',
                'ruang' => 'Ruang 05 - 08',
                'pengawas' => 'Hendro Prasetyo, M.Pd. & Ratna Sari',
                'tipe' => 'Penilaian Akhir Semester (PAS)',
                'status' => 'Mendatang'
            ],
            [
                'id' => 6,
                'hari' => 'Senin',
                'tanggal' => '04 November 2026',
                'waktu' => '10.00 - 11.30 WIB',
                'tingkat' => '8',
                'kelas' => 'Kelas 8 (A, B, C, D)',
                'mapel' => 'Bahasa Inggris',
                'ruang' => 'Ruang 05 - 08',
                'pengawas' => 'Dra. Endang Sulistyowati',
                'tipe' => 'Penilaian Akhir Semester (PAS)',
                'status' => 'Mendatang'
            ],
            [
                'id' => 7,
                'hari' => 'Selasa',
                'tanggal' => '05 November 2026',
                'waktu' => '07.30 - 09.30 WIB',
                'tingkat' => '8',
                'kelas' => 'Kelas 8 (A, B, C, D)',
                'mapel' => 'Ilmu Pengetahuan Sosial (IPS)',
                'ruang' => 'Ruang 05 - 08',
                'pengawas' => 'Ust. Fauzan, S.Pd.I',
                'tipe' => 'Penilaian Akhir Semester (PAS)',
                'status' => 'Mendatang'
            ],
            [
                'id' => 8,
                'hari' => 'Senin',
                'tanggal' => '04 November 2026',
                'waktu' => '07.30 - 09.30 WIB',
                'tingkat' => '9',
                'kelas' => 'Kelas 9 (A, B, C, D)',
                'mapel' => 'Matematika Terapan',
                'ruang' => 'Ruang 09 - 12',
                'pengawas' => 'Nurul Hidayah, S.Si.',
                'tipe' => 'Simulasi Ujian Sekolah (Try Out 1)',
                'status' => 'Mendatang'
            ],
            [
                'id' => 9,
                'hari' => 'Senin',
                'tanggal' => '04 November 2026',
                'waktu' => '10.00 - 11.30 WIB',
                'tingkat' => '9',
                'kelas' => 'Kelas 9 (A, B, C, D)',
                'mapel' => 'Bahasa Indonesia',
                'ruang' => 'Ruang 09 - 12',
                'pengawas' => 'Hendro Prasetyo, M.Pd.',
                'tipe' => 'Simulasi Ujian Sekolah (Try Out 1)',
                'status' => 'Mendatang'
            ],
            [
                'id' => 10,
                'hari' => 'Selasa',
                'tanggal' => '05 November 2026',
                'waktu' => '07.30 - 09.30 WIB',
                'tingkat' => '9',
                'kelas' => 'Kelas 9 (A, B, C, D)',
                'mapel' => 'Informatika & Literasi Digital',
                'ruang' => 'Laboratorium Komputer 1 & 2',
                'pengawas' => 'Budi Santoso, S.Kom.',
                'tipe' => 'Ujian Berbasis Komputer (CBT)',
                'status' => 'Mendatang'
            ]
        ];

        if ($tingkat && $tingkat !== 'Semua') {
            return array_values(array_filter($jadwal, fn($j) => $j['tingkat'] === $tingkat));
        }

        return $jadwal;
    }

    /**
     * Data Dewan Guru & Tenaga Pendidik
     */
    public function getDaftarGuru(?string $mapel = null, ?string $search = null): array
    {
        $guru = [
            [
                'id' => 1,
                'nama' => 'Drs. H. Bambang Sudarmono, M.Pd.',
                'nip' => '19680512 199303 1 004',
                'jabatan' => 'Kepala Sekolah',
                'mapel' => 'Manajemen Pendidikan',
                'pendidikan' => 'S2 Manajemen Pendidikan - Universitas Negeri',
                'pengalaman' => '31 Tahun',
                'email' => 'bambang.sudarmono@smpn3.sch.id',
                'avatar_color' => 'bg-primary'
            ],
            [
                'id' => 2,
                'nama' => 'Dra. Endang Sulistyowati',
                'nip' => '19710315 199601 2 002',
                'jabatan' => 'Wakil Kepala Sekolah Bidang Kurikulum',
                'mapel' => 'Pendidikan Pancasila & Kewarganegaraan',
                'pendidikan' => 'S1 PPKn - IKIP',
                'pengalaman' => '28 Tahun',
                'email' => 'endang.s@smpn3.sch.id',
                'avatar_color' => 'bg-indigo'
            ],
            [
                'id' => 3,
                'nama' => 'Hendro Prasetyo, M.Pd.',
                'nip' => '19800820 200501 1 008',
                'jabatan' => 'Wakil Kepala Sekolah Bidang Kesiswaan / Guru Matematika',
                'mapel' => 'Matematika',
                'pendidikan' => 'S2 Pendidikan Matematika - ITB',
                'pengalaman' => '19 Tahun',
                'email' => 'hendro.prasetyo@smpn3.sch.id',
                'avatar_color' => 'bg-info'
            ],
            [
                'id' => 4,
                'nama' => 'Siti Rahmawati, S.Pd.',
                'nip' => '19850410 200902 2 005',
                'jabatan' => 'Guru Pengampu / Wali Kelas 7-A',
                'mapel' => 'Bahasa Indonesia',
                'pendidikan' => 'S1 Pendidikan Bahasa & Sastra Indonesia',
                'pengalaman' => '15 Tahun',
                'email' => 'siti.rahmawati@smpn3.sch.id',
                'avatar_color' => 'bg-success'
            ],
            [
                'id' => 5,
                'nama' => 'Nurul Hidayah, S.Si.',
                'nip' => '19870914 201101 2 009',
                'jabatan' => 'Guru Pengampu / Kepala Lab IPA / Wali Kelas 9-C',
                'mapel' => 'Ilmu Pengetahuan Alam (IPA)',
                'pendidikan' => 'S1 Biologi Murni - UGM',
                'pengalaman' => '13 Tahun',
                'email' => 'nurul.hidayah@smpn3.sch.id',
                'avatar_color' => 'bg-teal'
            ],
            [
                'id' => 6,
                'nama' => 'Ratna Sari, M.Pd.',
                'nip' => '19890224 201403 2 003',
                'jabatan' => 'Guru Pengampu / Pembina OSIS / Wali Kelas 9-A',
                'mapel' => 'Bahasa Inggris',
                'pendidikan' => 'S2 Pendidikan Bahasa Inggris - UI',
                'pengalaman' => '10 Tahun',
                'email' => 'ratna.sari@smpn3.sch.id',
                'avatar_color' => 'bg-purple'
            ],
            [
                'id' => 7,
                'nama' => 'Budi Santoso, S.Kom.',
                'nip' => '19910618 201801 1 006',
                'jabatan' => 'Guru Informatika / Koordinator Lab Komputer & CBT',
                'mapel' => 'Informatika',
                'pendidikan' => 'S1 Teknik Informatika - ITS',
                'pengalaman' => '8 Tahun',
                'email' => 'budi.santoso@smpn3.sch.id',
                'avatar_color' => 'bg-dark'
            ],
            [
                'id' => 8,
                'nama' => 'Drs. Ahmad Zaini',
                'nip' => '19731205 199903 1 005',
                'jabatan' => 'Guru Pengampu / Pembina Pramuka',
                'mapel' => 'Ilmu Pengetahuan Sosial (IPS)',
                'pendidikan' => 'S1 Pendidikan Sejarah',
                'pengalaman' => '25 Tahun',
                'email' => 'ahmad.zaini@smpn3.sch.id',
                'avatar_color' => 'bg-warning'
            ],
            [
                'id' => 9,
                'nama' => 'Ust. Fauzan, S.Pd.I',
                'nip' => '19860111 201001 1 012',
                'jabatan' => 'Guru Agama / Pembina Rohis',
                'mapel' => 'Pendidikan Agama Islam',
                'pendidikan' => 'S1 Pendidikan Agama Islam - UIN',
                'pengalaman' => '14 Tahun',
                'email' => 'fauzan@smpn3.sch.id',
                'avatar_color' => 'bg-emerald'
            ],
            [
                'id' => 10,
                'nama' => 'Aris Munandar, S.Pd.',
                'nip' => '19921103 201902 1 007',
                'jabatan' => 'Guru PJOK / Pembina Ekstrakurikuler Olahraga',
                'mapel' => 'Pendidikan Jasmani & Olahraga',
                'pendidikan' => 'S1 Pendidikan Kepelatihan Olahraga',
                'pengalaman' => '7 Tahun',
                'email' => 'aris.munandar@smpn3.sch.id',
                'avatar_color' => 'bg-danger'
            ],
            [
                'id' => 11,
                'nama' => 'Dewi Lestari, S.Sn.',
                'nip' => '19900722 201503 2 008',
                'jabatan' => 'Guru Seni Budaya / Pembina Tari & Karawitan',
                'mapel' => 'Seni Budaya & Prakarya',
                'pendidikan' => 'S1 Seni Rupa & Desain - ISI',
                'pengalaman' => '9 Tahun',
                'email' => 'dewi.lestari@smpn3.sch.id',
                'avatar_color' => 'bg-pink'
            ],
            [
                'id' => 12,
                'nama' => 'Rina Kusumawati, S.Psi.',
                'nip' => '19881008 201202 2 004',
                'jabatan' => 'Guru Bimbingan Konseling (BK)',
                'mapel' => 'Bimbingan & Konseling',
                'pendidikan' => 'S1 Psikologi Pendidikan',
                'pengalaman' => '12 Tahun',
                'email' => 'rina.bk@smpn3.sch.id',
                'avatar_color' => 'bg-secondary'
            ]
        ];

        if ($mapel && $mapel !== 'Semua') {
            $guru = array_filter($guru, fn($g) => str_contains(strtolower($g['mapel']), strtolower($mapel)));
        }

        if ($search) {
            $sLower = strtolower(trim($search));
            $guru = array_filter($guru, function($g) use ($sLower) {
                return str_contains(strtolower($g['nama']), $sLower) ||
                       str_contains(strtolower($g['mapel']), $sLower) ||
                       str_contains(strtolower($g['nip']), $sLower);
            });
        }

        return array_values($guru);
    }

    /**
     * Cari satu data guru berdasarkan NIP, Nama, atau Email
     */
    public function getGuruByNip(string $identifier): ?array
    {
        $cleanId = preg_replace('/[^0-9a-zA-Z]/', '', strtolower($identifier));
        foreach ($this->getDaftarGuru() as $g) {
            $cleanNip = preg_replace('/[^0-9a-zA-Z]/', '', strtolower($g['nip']));
            if ($cleanNip === $cleanId || str_contains(strtolower($g['email']), strtolower($identifier)) || str_contains(strtolower($g['nama']), strtolower($identifier))) {
                return $g;
            }
        }
        return null;
    }

    /**
     * Ambil seluruh rekap nilai siswa terformat
     */
    public function getSemuaNilai(): array
    {
        $all = $this->getAllSiswaNilai();
        return array_map(function($s) {
            $formatted = $this->formatSiswaNilai($s);
            $mapelMap = [];
            foreach ($s['nilai'] as $n) {
                if (stripos($n['mapel'], 'Matematika') !== false) {
                    $mapelMap['matematika'] = $n['akhir'];
                } elseif (stripos($n['mapel'], 'Indonesia') !== false) {
                    $mapelMap['bahasa_indonesia'] = $n['akhir'];
                } elseif (stripos($n['mapel'], 'Inggris') !== false) {
                    $mapelMap['bahasa_inggris'] = $n['akhir'];
                } elseif (stripos($n['mapel'], 'Alam') !== false || stripos($n['mapel'], 'IPA') !== false) {
                    $mapelMap['ipa'] = $n['akhir'];
                }
            }
            $formatted['nilai_mapel'] = $mapelMap;
            $formatted['rata_rata'] = $formatted['ringkasan']['rata_rata'] ?? 85.0;
            return $formatted;
        }, $all);
    }

    /**
     * Ambil seluruh jadwal ujian
     */
    public function getSemuaJadwal(): array
    {
        return array_map(function($j) {
            $j['ruangan'] = $j['ruang'] ?? '-';
            return $j;
        }, $this->getJadwalUjian());
    }
}
