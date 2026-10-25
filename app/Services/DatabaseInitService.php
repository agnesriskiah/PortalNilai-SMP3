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
                    $table->string('foto')->nullable();
                    $table->string('no_hp')->nullable();
                    $table->rememberToken();
                    $table->timestamps();
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
     * Simpan 2 data dummy pengelola: Admin dan Guru lengkap dengan gambar
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

            // Guru Dummy di tabel pengelola
            Pengelola::updateOrCreate(
                ['username' => 'guru'],
                [
                    'name' => 'Hendro Prasetyo, M.Pd.',
                    'email' => 'guru@smpn3.sch.id',
                    'password' => Hash::make('guru123'),
                    'role' => 'guru',
                    'nip' => '19800820 200501 1 008',
                    'mapel' => 'Matematika',
                    'jabatan' => 'Wakil Kepala Sekolah / Guru Matematika',
                    'foto' => 'assets/img/users/guru.svg',
                    'no_hp' => '0812-3456-7890',
                ]
            );
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
