<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilaisiswa');
    }
};
