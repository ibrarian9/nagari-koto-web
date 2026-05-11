<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pbb_records', function (Blueprint $table) {
            $table->id();
            $table->string('nop')->index();
            $table->string('taxpayer_name');
            $table->text('address')->nullable();
            $table->decimal('land_area', 10, 2)->default(0);
            $table->decimal('building_area', 10, 2)->default(0);
            $table->unsignedBigInteger('njop')->default(0);
            $table->unsignedBigInteger('tax_amount')->default(0);
            $table->unsignedSmallInteger('tax_year');
            $table->string('status')->default('unpaid'); // unpaid, paid
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['tax_year', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pbb_records');
    }
};
