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

        // Seed existing program names from bansos_recipients
        $existing = \App\Models\BansosRecipient::distinct()->pluck('program_name')->filter();
        foreach ($existing as $name) {
            \App\Models\BansosProgram::create(['name' => $name]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('bansos_programs');
    }
};
