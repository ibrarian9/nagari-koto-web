<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legal_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category'); // perdes, sk_wali, perbup, perda, uu, pp, inpres, lainnya
            $table->year('year');
            $table->string('number')->nullable(); // Nomor peraturan, cth: 1/2024
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
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
        Schema::dropIfExists('legal_documents');
    }
};
