<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSiswa extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database MySQL
     *
     * @var string
     */
    protected $table = 'nilaisiswa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nisn',
        'nis',
        'nama',
        'kelas',
        'tingkat',
        'jenis_kelamin',
        'semester',
        'wali_kelas',
        'mapel',
        'guru',
        'kkm',
        'tugas',
        'uts',
        'uas',
        'akhir',
        'predikat',
        'status',
        'catatan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'kkm' => 'float',
            'tugas' => 'float',
            'uts' => 'float',
            'uas' => 'float',
            'akhir' => 'float',
        ];
    }
}
