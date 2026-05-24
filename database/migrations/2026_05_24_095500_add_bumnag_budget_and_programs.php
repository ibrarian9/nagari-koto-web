<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom sejarah ke profil BUMNag
        Schema::table('bumnag_profiles', function (Blueprint $table) {
            $table->text('sejarah')->nullable()->after('description');
        });

        // Anggaran BUMNag (mirip budget_stats + keterangan)
        Schema::create('bumnag_budgets', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->bigInteger('total_income')->default(0);
            $table->bigInteger('total_expenditure')->default(0);
            $table->decimal('realization_pct', 5, 2)->default(0);
            $table->json('apbdes_data')->nullable();       // {label: value}
            $table->text('keterangan')->nullable();         // Narasi penggunaan anggaran
            $table->timestamps();

            $table->index('year');
        });

        // Program Kerja BUMNag
        Schema::create('bumnag_programs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->string('kepala_unit_usaha')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('output_program')->nullable();
            $table->text('kendala')->nullable();
            $table->string('penerima_manfaat')->nullable();
            $table->year('tahun')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bumnag_programs');
        Schema::dropIfExists('bumnag_budgets');
        Schema::table('bumnag_profiles', function (Blueprint $table) {
            $table->dropColumn('sejarah');
        });
    }
};
