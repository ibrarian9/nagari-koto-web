<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppid_serta_merta', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->enum('urgency', ['rendah', 'sedang', 'tinggi', 'kritis'])->default('rendah');
            $table->boolean('is_active')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index('urgency');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppid_serta_merta');
    }
};
