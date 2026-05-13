<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Performance indexes for frequently queried columns.
 * Covers: sorting, filtering, searching, and foreign key lookups.
 */
return new class extends Migration
{
    public function up(): void
    {
        // users: role-based queries, active status
        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
            $table->index('is_active');
            $table->index(['role', 'is_active']);
        });

        // posts: category filter, user lookup
        Schema::table('posts', function (Blueprint $table) {
            $table->index('category_id');
            $table->index('user_id');
        });

        // government_members: active + ordered list
        Schema::table('government_members', function (Blueprint $table) {
            $table->index(['is_active', 'order']);
        });

        // agendas: public events filtering
        Schema::table('agendas', function (Blueprint $table) {
            $table->index(['is_public', 'start_date']);
        });

        // letter_requests: user's letters, status+date filtering
        Schema::table('letter_requests', function (Blueprint $table) {
            $table->index('user_id');
            $table->index(['status', 'created_at']);
        });

        // bansos_recipients: program filter, active status, search
        Schema::table('bansos_recipients', function (Blueprint $table) {
            $table->index('program_name');
            $table->index('is_active');
            $table->index('full_name');
        });

        // pbb_records: name search, year filter
        Schema::table('pbb_records', function (Blueprint $table) {
            $table->index('taxpayer_name');
        });

        // population_stats: year-based lookup
        Schema::table('population_stats', function (Blueprint $table) {
            $table->index('year');
        });

        // budget_stats: year-based lookup
        Schema::table('budget_stats', function (Blueprint $table) {
            $table->index('year');
        });

        // products (UMKM): active/featured
        if (Schema::hasColumn('products', 'is_active')) {
            Schema::table('products', function (Blueprint $table) {
                $table->index('is_active');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['role', 'is_active']);
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['user_id']);
        });
        Schema::table('government_members', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'order']);
        });
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropIndex(['is_public', 'start_date']);
        });
        Schema::table('letter_requests', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status', 'created_at']);
        });
        Schema::table('bansos_recipients', function (Blueprint $table) {
            $table->dropIndex(['program_name']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['full_name']);
        });
        Schema::table('pbb_records', function (Blueprint $table) {
            $table->dropIndex(['taxpayer_name']);
        });
        Schema::table('population_stats', function (Blueprint $table) {
            $table->dropIndex(['year']);
        });
        Schema::table('budget_stats', function (Blueprint $table) {
            $table->dropIndex(['year']);
        });
        if (Schema::hasColumn('products', 'is_active')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropIndex(['is_active']);
            });
        }
    }
};
