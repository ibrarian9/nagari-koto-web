<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bansos_recipients', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->index();
            $table->string('full_name');
            $table->text('address')->nullable();
            $table->string('program_name');
            $table->string('program_type')->nullable();
            $table->date('start_period')->nullable();
            $table->date('end_period')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bansos_recipients');
    }
};
