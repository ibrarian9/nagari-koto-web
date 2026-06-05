<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppid_keberatan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_registrasi')->unique();
            $table->string('no_registrasi_permohonan')->nullable();
            $table->string('nama');
            $table->string('no_hp');
            $table->string('email')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->text('alamat');
            $table->text('informasi_dimohon')->nullable();
            $table->string('alasan_keberatan');
            $table->enum('status', ['diterima', 'diproses', 'selesai', 'ditolak'])->default('diterima');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppid_keberatan');
    }
};
