<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('population_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('year')->unique();
            $table->unsignedInteger('total_population')->default(0);
            $table->unsignedInteger('male')->default(0);
            $table->unsignedInteger('female')->default(0);
            $table->unsignedInteger('total_families')->default(0);
            $table->longText('age_group_data')->nullable(); // JSON-as-text
            $table->longText('education_data')->nullable();  // JSON-as-text
            $table->longText('occupation_data')->nullable(); // JSON-as-text
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('population_stats');
    }
};
