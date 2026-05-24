<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Profil BUMNag (single-row pattern)
        Schema::create('bumnag_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('BUMNag');
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();

            // Badan Hukum
            $table->string('sk_pendirian')->nullable();       // Nomor SK
            $table->date('tanggal_pendirian')->nullable();
            $table->string('sk_file')->nullable();            // Path file PDF
            $table->string('akte_notaris')->nullable();       // Nomor Akte
            $table->string('akte_file')->nullable();          // Path file PDF
            $table->string('npwp')->nullable();

            $table->json('unit_usaha')->nullable();           // [{nama, deskripsi}]
            $table->timestamps();
        });

        // Struktur Organisasi BUMNag
        Schema::create('bumnag_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->string('photo')->nullable();
            $table->enum('role_type', ['pengurus', 'pengawas'])->default('pengurus');
            $table->string('period')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'order']);
            $table->index('role_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bumnag_members');
        Schema::dropIfExists('bumnag_profiles');
    }
};
