<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Global donation settings (bank accounts, instructions)
        Schema::create('donation_settings', function (Blueprint $table) {
            $table->id();
            $table->json('bank_accounts')->nullable(); // [{bank, account_number, account_name}]
            $table->text('transfer_instructions')->nullable();
            $table->timestamps();
        });

        // Add payment_proof, remove Midtrans columns
        Schema::table('donations', function (Blueprint $table) {
            $table->string('payment_proof')->nullable()->after('payment_type');
            $table->dropColumn(['snap_token', 'midtrans_response']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_settings');

        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn('payment_proof');
            $table->string('snap_token')->nullable();
            $table->json('midtrans_response')->nullable();
        });
    }
};
