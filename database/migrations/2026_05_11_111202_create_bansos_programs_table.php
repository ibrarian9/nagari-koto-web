<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bansos_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Data seeding moved to DatabaseSeeder/BansosProgramSeeder
        // to avoid Model dependency issues during fresh migration
    }

    public function down(): void
    {
        Schema::dropIfExists('bansos_programs');
    }
};
