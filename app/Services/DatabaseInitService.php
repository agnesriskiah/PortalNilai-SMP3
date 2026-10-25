<?php

namespace App\Services;

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
     * tabel 'pengelola' sudah dibuat, dan 2 data user dummy (Admin & Guru) tersimpan.
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
}
