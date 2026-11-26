<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('surel', 180)->unique();
            $table->string('kata_sandi');
            $table->string('peran', 20)->default('seniman')->index();
            $table->boolean('aktif')->default(true)->index();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('kategori_karya', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 120);
            $table->string('slug', 150)->unique();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::create('seniman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->unique()->constrained('pengguna')->cascadeOnDelete();
            $table->string('slug', 180)->unique();
            $table->string('nama_lengkap', 150);
            $table->string('kota', 120)->nullable();
            $table->string('disiplin', 180)->nullable();
            $table->string('foto_profil')->nullable();
            $table->string('biografi_singkat', 500)->nullable();
            $table->text('biografi')->nullable();
            $table->text('latar_belakang')->nullable();
            $table->text('perjalanan_berkesenian')->nullable();
            $table->text('pengalaman')->nullable();
            $table->timestamps();
            $table->index(['kota', 'disiplin']);
        });

        Schema::create('karya_seni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seniman_id')->constrained('seniman')->cascadeOnDelete();
            $table->foreignId('kategori_id')->nullable()->constrained('kategori_karya')->nullOnDelete();
            $table->string('slug', 200)->unique();
            $table->string('judul', 180);
            $table->text('deskripsi');
            $table->unsignedSmallInteger('tahun_pembuatan')->nullable();
            $table->string('media_bahan', 500)->nullable();
            $table->string('dimensi', 150)->nullable();
            $table->text('informasi_tambahan')->nullable();
            $table->decimal('harga_opsional', 15, 2)->nullable();
            $table->string('foto_karya');
            $table->string('status', 30)->default('TERBIT')->index();
            $table->string('catatan_moderasi', 500)->nullable();
            $table->timestamps();
            $table->index(['seniman_id', 'status']);
            $table->index(['kategori_id', 'status']);
        });

        Schema::create('riwayat_pameran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seniman_id')->constrained('seniman')->cascadeOnDelete();
            $table->string('nama_pameran', 180);
            $table->string('lokasi', 180)->nullable();
            $table->unsignedSmallInteger('tahun')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->index(['seniman_id', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pameran');
        Schema::dropIfExists('karya_seni');
        Schema::dropIfExists('seniman');
        Schema::dropIfExists('kategori_karya');
        Schema::dropIfExists('pengguna');
    }
};
