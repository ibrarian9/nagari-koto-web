<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppid_contents', function (Blueprint $table) {
            $table->json('members_data')->nullable()->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('ppid_contents', function (Blueprint $table) {
            $table->dropColumn('members_data');
        });
    }
};
