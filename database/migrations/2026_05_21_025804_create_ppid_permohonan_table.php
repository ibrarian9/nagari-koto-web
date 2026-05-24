<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppid_permohonan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_permohonan')->unique();
            $table->string('nama_pemohon');
            $table->string('nik', 16);
            $table->string('no_telepon');
            $table->string('email')->nullable();
            $table->text('alamat');
            $table->text('informasi_diminta');
            $table->text('tujuan_penggunaan');
            $table->enum('format_informasi', ['softcopy', 'hardcopy', 'keduanya'])->default('softcopy');
            $table->enum('cara_mendapatkan', ['mengambil_langsung', 'email', 'pos'])->default('mengambil_langsung');
            $table->string('lampiran')->nullable(); // KTP scan
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
            $table->text('catatan_petugas')->nullable();
            $table->string('dokumen_balasan')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('nomor_permohonan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppid_permohonan');
    }
};
