<?php

namespace Database\Seeders;

use App\Models\Pengelola;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with 2 Dummy Pengelola: Admin & Guru.
     */
    public function run(): void
    {
        // 1. Data Dummy Admin di tabel pengelola
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

        // 2. Data Dummy Guru di tabel pengelola
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
    }
}
