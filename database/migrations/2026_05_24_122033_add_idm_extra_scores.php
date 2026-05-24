<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('idm_stats', function (Blueprint $table) {
            $table->decimal('accessibility_score', 5, 3)->default(0)->after('environment_score');
            $table->decimal('basic_service_score', 5, 3)->default(0)->after('accessibility_score');
            $table->decimal('governance_score', 5, 3)->default(0)->after('basic_service_score');
        });
    }

    public function down(): void
    {
        Schema::table('idm_stats', function (Blueprint $table) {
            $table->dropColumn(['accessibility_score', 'basic_service_score', 'governance_score']);
        });
    }
};
