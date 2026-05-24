<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppid_setiap_saat', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category'); // dip, statistik_desa, prosedur, perjanjian, lainnya
            $table->year('year');
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->string('file_name');
            $table->unsignedBigInteger('file_size')->default(0);
            $table->unsignedInteger('download_count')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index('category');
            $table->index('year');
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppid_setiap_saat');
    }
};
