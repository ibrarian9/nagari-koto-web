<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bumnag_profiles', function (Blueprint $table) {
            $table->string('badan_hukum_file')->nullable()->after('npwp');
        });
    }

    public function down(): void
    {
        Schema::table('bumnag_profiles', function (Blueprint $table) {
            $table->dropColumn('badan_hukum_file');
        });
    }
};
