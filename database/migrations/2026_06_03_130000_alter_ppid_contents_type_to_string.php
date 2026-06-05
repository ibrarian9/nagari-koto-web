<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change enum to string for flexible type expansion
        Schema::table('ppid_contents', function (Blueprint $table) {
            $table->string('type', 50)->change();
        });
    }

    public function down(): void
    {
        // Revert to enum (only original types)
        DB::statement("ALTER TABLE ppid_contents MODIFY type ENUM('profil','visi_misi','tugas_fungsi','struktur')");
    }
};
