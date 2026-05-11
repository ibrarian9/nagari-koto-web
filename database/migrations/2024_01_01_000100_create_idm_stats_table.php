<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('idm_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('year')->unique();
            $table->decimal('score', 5, 3)->default(0);
            $table->string('status'); // sangat_tertinggal, tertinggal, berkembang, maju, mandiri
            $table->decimal('social_score', 5, 3)->default(0);
            $table->decimal('economic_score', 5, 3)->default(0);
            $table->decimal('environment_score', 5, 3)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('idm_stats');
    }
};
