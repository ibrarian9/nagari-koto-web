<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bumnag_profiles', function (Blueprint $table) {
            $table->dropColumn(['sk_file', 'akte_notaris', 'akte_file', 'npwp']);
        });
    }

    public function down(): void
    {
        Schema::table('bumnag_profiles', function (Blueprint $table) {
            $table->string('sk_file')->nullable();
            $table->string('akte_notaris')->nullable();
            $table->string('akte_file')->nullable();
            $table->string('npwp', 50)->nullable();
        });
    }
};
