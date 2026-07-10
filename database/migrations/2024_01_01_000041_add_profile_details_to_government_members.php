<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('government_members', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('position');
            $table->string('place_of_birth')->nullable()->after('nip');
            $table->date('date_of_birth')->nullable()->after('place_of_birth');
            $table->json('education_history')->nullable()->after('date_of_birth');
            $table->json('position_history')->nullable()->after('education_history');
        });
    }

    public function down(): void
    {
        Schema::table('government_members', function (Blueprint $table) {
            $table->dropColumn(['nip', 'place_of_birth', 'date_of_birth', 'education_history', 'position_history']);
        });
    }
};
