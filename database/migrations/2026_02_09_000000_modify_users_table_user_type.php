<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Direct SQL to modify the enum type to include 'qc'
        // This syntax works for MySQL/MariaDB
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('user', 'admin', 'qc') NOT NULL DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum
        // WARNING: This fails if there are any 'qc' users remaining
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('user', 'admin') NOT NULL DEFAULT 'user'");
    }
};
