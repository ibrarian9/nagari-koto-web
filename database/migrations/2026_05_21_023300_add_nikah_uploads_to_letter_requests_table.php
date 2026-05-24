<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('letter_requests', function (Blueprint $table) {
            $table->string('ktp_image_2')->nullable()->after('ktp_image');
            $table->string('nikah_form_image')->nullable()->after('ktp_image_2');
        });
    }

    public function down(): void
    {
        Schema::table('letter_requests', function (Blueprint $table) {
            $table->dropColumn(['ktp_image_2', 'nikah_form_image']);
        });
    }
};
