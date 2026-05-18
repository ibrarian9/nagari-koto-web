<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forestry_records', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('category', ['hutan_lindung', 'hutan_produksi', 'hutan_rakyat', 'lahan_kritis', 'rehabilitasi']);
            $table->decimal('area_ha', 10, 2)->default(0);
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['aktif', 'dalam_pemulihan', 'kritis'])->default('aktif');
            $table->year('year')->nullable();
            $table->string('thumbnail')->nullable();
            $table->timestamps();

            $table->index('category');
            $table->index('status');
            $table->index('year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forestry_records');
    }
};
