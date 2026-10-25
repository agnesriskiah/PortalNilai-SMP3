<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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

        // Buat view alias `pegelola` agar kedua nama (pengelola & pegelola) valid di MySQL
        try {
            DB::statement("CREATE OR REPLACE VIEW `pegelola` AS SELECT * FROM `pengelola`");
        } catch (\Exception $e) {
            // Ignore if view creation not supported
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement("DROP VIEW IF EXISTS `pegelola`");
        } catch (\Exception $e) {
            // Ignore
        }
        Schema::dropIfExists('pengelola');
    }
};
