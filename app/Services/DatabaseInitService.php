<?php

namespace App\Services;

use App\Models\NilaiSiswa;
use App\Models\Pengelola;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use PDO;
use Exception;

class DatabaseInitService
{
    /**
     * Memastikan database MySQL 'portalnilai' tersedia,
     * tabel 'pengelola' & 'nilaisiswa' sudah dibuat, dan data awal tersimpan.
     */
    public static function ensureDatabaseReady(): void
    {
        try {
            // 1. Cek / Buat Database MySQL jika belum ada
            $host = config('database.connections.mysql.host', '127.0.0.1');
            $port = config('database.connections.mysql.port', '3306');
            $dbName = config('database.connections.mysql.database', 'portalnilai');
            $user = config('database.connections.mysql.username', 'root');
            $pass = config('database.connections.mysql.password', '');

            $pdo = new PDO("mysql:host={$host};port={$port}", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            // 2. Reconnect Laravel DB
            DB::purge('mysql');

            // 3. Cek tabel users & sessions jika belum ada jalankan migrasi
            if (!Schema::hasTable('users')) {
                Artisan::call('migrate', ['--force' => true]);
            }

            // 4. Pastikan tabel 'pengelola' tersedia terpisah
            if (!Schema::hasTable('pengelola')) {
                Schema::create('pengelola', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('username')->unique();
                    $table->string('email')->unique();
                    $table->timestamp('email_verified_at')->nullable();
                    $table->string('password');
                    $table->enum('role', ['admin', 'guru'])->default('guru');
                    $table->string('nip')->nullable();
                    $table->string('mapel')->nullable();
                    $table->string('jabatan')->nullable();
                    $table->string('pendidikan')->nullable();
                    $table->string('pengalaman')->nullable();
                    $table->string('foto')->nullable();
                    $table->string('no_hp')->nullable();
                    $table->rememberToken();
                    $table->timestamps();
                });
            } else {
                // Pastikan kolom pendidikan & pengalaman tersedia jika tabel sudah ada sebelumnya
                Schema::table('pengelola', function (Blueprint $table) {
                    if (!Schema::hasColumn('pengelola', 'pendidikan')) {
                        $table->string('pendidikan')->nullable()->after('jabatan');
                    }
                    if (!Schema::hasColumn('pengelola', 'pengalaman')) {
                        $table->string('pengalaman')->nullable()->after('pendidikan');
                    }
                });
            }

            // 5. Buat view alias `pegelola` agar kedua nama (pengelola & pegelola) valid
            try {
                DB::statement("CREATE OR REPLACE VIEW `pegelola` AS SELECT * FROM `pengelola`");
            } catch (Exception $viewEx) {
                // Ignore view creation error if already exists
            }

            // 6. Simpan 2 akun dummy (Admin & Guru) ke tabel pengelola
            self::seedDummyPengelola();

            // 7. Pastikan tabel 'nilaisiswa' tersedia di database
            if (!Schema::hasTable('nilaisiswa')) {
                Schema::create('nilaisiswa', function (Blueprint $table) {
                    $table->id();
                    $table->string('nisn', 20)->index();
                    $table->string('nis', 20)->nullable();
                    $table->string('nama', 150);
                    $table->string('kelas', 20);
                    $table->string('tingkat', 10)->nullable();
                    $table->string('jenis_kelamin', 20)->nullable();
                    $table->string('semester', 50)->default('Ganjil 2024/2025');
                    $table->string('wali_kelas', 150)->nullable();
                    $table->string('mapel', 100)->index();
                    $table->string('guru', 150)->nullable();
                    $table->decimal('kkm', 5, 1)->default(75.0);
                    $table->decimal('tugas', 5, 1)->default(0.0);
                    $table->decimal('uts', 5, 1)->default(0.0);
                    $table->decimal('uas', 5, 1)->default(0.0);
                    $table->decimal('akhir', 5, 1)->default(0.0);
                    $table->string('predikat', 5)->default('C');
                    $table->string('status', 30)->default('Lulus');
                    $table->text('catatan')->nullable();
                    $table->timestamps();
                });
            }

            // 8. Simpan seluruh data awal nilai siswa ke tabel 'nilaisiswa' jika belum ada
            self::seedInitialNilaiSiswa();

        } catch (Exception $e) {
            logger()->error('DatabaseInitService error: ' . $e->getMessage());
        }
    }

    /**
     * Simpan data pengelola: Admin dan Dewan Guru lengkap ke tabel pengelola
     */
    public static function seedDummyPengelola(): void
    {
        try {
            // Admin Dummy di tabel pengelola
            Pengelola::updateOrCreate(
                ['username' => 'admin'],
                [
                    'name' => 'Administrator IT Portal',
                    'email' => 'admin@smpn3.sch.id',
                    'password' => Hash::make('admin123'),
                    'role' => 'admin',
                    'nip' => '19850101 201001 1 001',
                    'mapel' => 'Teknologi Informasi & Komputer',
                    'jabatan' => 'Administrator Portal & Koordinator Lab CBT',
                    'foto' => 'assets/img/users/admin.svg',
                    'no_hp' => '0813-9876-5432',
                ]
            );

            // Akun Guru Utama
            Pengelola::updateOrCreate(
                ['username' => 'guru'],
                [
                    'name' => 'Hendro Prasetyo, M.Pd.',
                    'email' => 'guru@smpn3.sch.id',
                    'password' => Hash::make('guru123'),
                    'role' => 'guru',
                    'nip' => '19800820 200501 1 008',
                    'mapel' => 'Matematika',
                    'jabatan' => 'Wakil Kepala Sekolah Bidang Kesiswaan / Guru Matematika',
                    'pendidikan' => 'S2 Pendidikan Matematika - ITB',
                    'pengalaman' => '19 Tahun',
                    'foto' => 'assets/img/users/guru.svg',
                    'no_hp' => '0812-3456-7890',
                ]
            );

            // Daftar Guru & Staf SMPN 3 lainnya
            $daftarGuruAwal = [
                [
                    'username' => 'bambang',
                    'name' => 'Drs. H. Bambang Sudarmono, M.Pd.',
                    'nip' => '19680512 199303 1 004',
                    'jabatan' => 'Kepala Sekolah',
                    'mapel' => 'Manajemen Pendidikan',
                    'pendidikan' => 'S2 Manajemen Pendidikan - Universitas Negeri',
                    'pengalaman' => '31 Tahun',
                    'email' => 'bambang.sudarmono@smpn3.sch.id',
                    'no_hp' => '0812-1111-2222',
                ],
                [
                    'username' => 'endang',
                    'name' => 'Dra. Endang Sulistyowati',
                    'nip' => '19710315 199601 2 002',
                    'jabatan' => 'Wakil Kepala Sekolah Bidang Kurikulum',
                    'mapel' => 'Pendidikan Pancasila & Kewarganegaraan',
                    'pendidikan' => 'S1 PPKn - IKIP',
                    'pengalaman' => '28 Tahun',
                    'email' => 'endang.s@smpn3.sch.id',
                    'no_hp' => '0812-2222-3333',
                ],
                [
                    'username' => 'siti',
                    'name' => 'Siti Rahmawati, S.Pd.',
                    'nip' => '19850410 200902 2 005',
                    'jabatan' => 'Guru Pengampu / Wali Kelas 7-A',
                    'mapel' => 'Bahasa Indonesia',
                    'pendidikan' => 'S1 Pendidikan Bahasa & Sastra Indonesia',
                    'pengalaman' => '15 Tahun',
                    'email' => 'siti.rahmawati@smpn3.sch.id',
                    'no_hp' => '0812-4444-5555',
                ],
                [
                    'username' => 'nurul',
                    'name' => 'Nurul Hidayah, S.Si.',
                    'nip' => '19870914 201101 2 009',
                    'jabatan' => 'Guru Pengampu / Kepala Lab IPA / Wali Kelas 9-C',
                    'mapel' => 'Ilmu Pengetahuan Alam (IPA)',
                    'pendidikan' => 'S1 Biologi Murni - UGM',
                    'pengalaman' => '13 Tahun',
                    'email' => 'nurul.hidayah@smpn3.sch.id',
                    'no_hp' => '0812-5555-6666',
                ],
                [
                    'username' => 'ratna',
                    'name' => 'Ratna Sari, M.Pd.',
                    'nip' => '19890224 201403 2 003',
                    'jabatan' => 'Guru Pengampu / Pembina OSIS / Wali Kelas 9-A',
                    'mapel' => 'Bahasa Inggris',
                    'pendidikan' => 'S2 Pendidikan Bahasa Inggris - UI',
                    'pengalaman' => '10 Tahun',
                    'email' => 'ratna.sari@smpn3.sch.id',
                    'no_hp' => '0812-6666-7777',
                ],
                [
                    'username' => 'budi',
                    'name' => 'Budi Santoso, S.Kom.',
                    'nip' => '19910618 201801 1 006',
                    'jabatan' => 'Guru Informatika / Koordinator Lab Komputer & CBT',
                    'mapel' => 'Informatika',
                    'pendidikan' => 'S1 Teknik Informatika - ITS',
                    'pengalaman' => '8 Tahun',
                    'email' => 'budi.santoso@smpn3.sch.id',
                    'no_hp' => '0812-7777-8888',
                ],
                [
                    'username' => 'ahmad',
                    'name' => 'Drs. Ahmad Zaini',
                    'nip' => '19731205 199903 1 005',
                    'jabatan' => 'Guru Pengampu / Pembina Pramuka',
                    'mapel' => 'Ilmu Pengetahuan Sosial (IPS)',
                    'pendidikan' => 'S1 Pendidikan Sejarah',
                    'pengalaman' => '25 Tahun',
                    'email' => 'ahmad.zaini@smpn3.sch.id',
                    'no_hp' => '0812-8888-9999',
                ],
                [
                    'username' => 'fauzan',
                    'name' => 'Ust. Fauzan, S.Pd.I',
                    'nip' => '19860111 201001 1 012',
                    'jabatan' => 'Guru Agama / Pembina Rohis',
                    'mapel' => 'Pendidikan Agama Islam',
                    'pendidikan' => 'S1 Pendidikan Agama Islam - UIN',
                    'pengalaman' => '14 Tahun',
                    'email' => 'fauzan@smpn3.sch.id',
                    'no_hp' => '0812-9999-0000',
                ],
                [
                    'username' => 'aris',
                    'name' => 'Aris Munandar, S.Pd.',
                    'nip' => '19921103 201902 1 007',
                    'jabatan' => 'Guru PJOK / Pembina Ekstrakurikuler Olahraga',
                    'mapel' => 'Pendidikan Jasmani & Olahraga',
                    'pendidikan' => 'S1 Pendidikan Kepelatihan Olahraga',
                    'pengalaman' => '7 Tahun',
                    'email' => 'aris.munandar@smpn3.sch.id',
                    'no_hp' => '0813-1111-3333',
                ],
                [
                    'username' => 'dewi',
                    'name' => 'Dewi Lestari, S.Sn.',
                    'nip' => '19900722 201503 2 008',
                    'jabatan' => 'Guru Seni Budaya / Pembina Tari & Karawitan',
                    'mapel' => 'Seni Budaya & Prakarya',
                    'pendidikan' => 'S1 Seni Rupa & Desain - ISI',
                    'pengalaman' => '9 Tahun',
                    'email' => 'dewi.lestari@smpn3.sch.id',
                    'no_hp' => '0813-2222-4444',
                ],
                [
                    'username' => 'rina',
                    'name' => 'Rina Kusumawati, S.Psi.',
                    'nip' => '19881008 201202 2 004',
                    'jabatan' => 'Guru Bimbingan Konseling (BK)',
                    'mapel' => 'Bimbingan & Konseling',
                    'pendidikan' => 'S1 Psikologi Pendidikan',
                    'pengalaman' => '12 Tahun',
                    'email' => 'rina.bk@smpn3.sch.id',
                    'no_hp' => '0813-3333-5555',
                ],
            ];

            foreach ($daftarGuruAwal as $g) {
                Pengelola::updateOrCreate(
                    ['username' => $g['username']],
                    [
                        'name' => $g['name'],
                        'email' => $g['email'],
                        'password' => Hash::make('guru123'),
                        'role' => 'guru',
                        'nip' => $g['nip'],
                        'mapel' => $g['mapel'],
                        'jabatan' => $g['jabatan'],
                        'pendidikan' => $g['pendidikan'],
                        'pengalaman' => $g['pengalaman'],
                        'foto' => 'assets/img/users/guru.svg',
                        'no_hp' => $g['no_hp'],
                    ]
                );
            }
        } catch (Exception $e) {
            logger()->error('SeedDummyPengelola error: ' . $e->getMessage());
        }
    }

    /**
     * Simpan seluruh data awal nilai siswa ke tabel 'nilaisiswa'
     */
    public static function seedInitialNilaiSiswa(bool $forceReset = false): void
    {
        try {
            if (!Schema::hasTable('nilaisiswa')) {
                return;
            }

            if ($forceReset) {
                NilaiSiswa::truncate();
            } elseif (NilaiSiswa::count() > 0) {
                return; // Data sudah ada
            }

            $portalData = new PortalDataService();
            $defaultSiswa = $portalData->getDefaultMockSiswaNilai();

            foreach ($defaultSiswa as $siswa) {
                foreach ($siswa['nilai'] as $n) {
                    NilaiSiswa::create([
                        'nisn' => $siswa['nisn'],
                        'nis' => $siswa['nis'] ?? null,
                        'nama' => $siswa['nama'],
                        'kelas' => $siswa['kelas'],
                        'tingkat' => $siswa['tingkat'] ?? substr($siswa['kelas'], 0, 1),
                        'jenis_kelamin' => $siswa['jenis_kelamin'] ?? 'Laki-laki',
                        'semester' => $siswa['semester'] ?? 'Ganjil 2024/2025',
                        'wali_kelas' => $siswa['wali_kelas'] ?? null,
                        'mapel' => $n['mapel'],
                        'guru' => $n['guru'] ?? null,
                        'kkm' => (float) ($n['kkm'] ?? 75),
                        'tugas' => (float) ($n['tugas'] ?? 0),
                        'uts' => (float) ($n['uts'] ?? 0),
                        'uas' => (float) ($n['uas'] ?? 0),
                        'akhir' => (float) ($n['akhir'] ?? 0),
                        'predikat' => $n['predikat'] ?? 'C',
                        'status' => $n['status'] ?? 'Lulus',
                        'catatan' => $n['catatan'] ?? 'Capaian kompetensi tuntas sesuai kriteria ketercapaian tujuan pembelajaran.',
                    ]);
                }
            }
        } catch (Exception $e) {
            logger()->error('seedInitialNilaiSiswa error: ' . $e->getMessage());
        }
    }
}
