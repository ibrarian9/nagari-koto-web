<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Alter ENUM column to string/VARCHAR(50) so 'pembina' and future roles can be saved safely in MariaDB/MySQL
        DB::statement("ALTER TABLE bumnag_members MODIFY COLUMN role_type VARCHAR(50) NOT NULL DEFAULT 'pengurus'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE bumnag_members MODIFY COLUMN role_type ENUM('pengurus', 'pengawas') NOT NULL DEFAULT 'pengurus'");
    }
};
