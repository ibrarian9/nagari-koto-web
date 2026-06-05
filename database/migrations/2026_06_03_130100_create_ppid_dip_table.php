<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppid_dip', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->year('tahun_dokumen')->nullable();
            $table->enum('kategori', ['berkala', 'serta_merta', 'setiap_saat']);
            $table->string('file_path')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppid_dip');
    }
};
