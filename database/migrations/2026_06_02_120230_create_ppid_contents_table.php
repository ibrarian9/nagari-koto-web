<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppid_contents', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['profil', 'visi_misi', 'tugas_fungsi', 'struktur'])->unique();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('attachment')->nullable(); // PDF for tugas_fungsi
            $table->string('image')->nullable();      // Image for struktur
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppid_contents');
    }
};
