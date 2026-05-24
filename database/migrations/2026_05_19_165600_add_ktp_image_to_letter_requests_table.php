<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('letter_requests', function (Blueprint $table) {
            $table->string('ktp_image')->nullable()->after('purpose');
        });
    }

    public function down(): void
    {
        Schema::table('letter_requests', function (Blueprint $table) {
            $table->dropColumn('ktp_image');
        });
    }
};
