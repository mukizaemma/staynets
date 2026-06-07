<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE cars MODIFY COLUMN status ENUM('available', 'rented', 'maintenance', 'unavailable') NOT NULL DEFAULT 'available'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE cars MODIFY COLUMN status ENUM('available', 'rented', 'maintenance') NOT NULL DEFAULT 'available'");
    }
};
