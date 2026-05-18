<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Badan Musyawarah (BAMUS) Nagari
        Schema::create('bamus_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->string('photo')->nullable();
            $table->string('period')->nullable();       // cth: 2024-2029
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'order']);
        });

        // Lembaga Nagari (KAN, PKK, Karang Taruna, etc.)
        Schema::create('village_institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name');                     // Nama lembaga
            $table->enum('type', ['adat', 'kepemudaan', 'perempuan', 'keagamaan', 'sosial', 'pendidikan', 'lainnya'])->default('lainnya');
            $table->string('head_name')->nullable();    // Nama ketua
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('contact')->nullable();
            $table->year('established_year')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'order']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('village_institutions');
        Schema::dropIfExists('bamus_members');
    }
};
