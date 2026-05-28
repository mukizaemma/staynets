<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('amenities')) {
            return;
        }

        if (Schema::hasTable('unit_facilities') && Schema::hasColumn('unit_facilities', 'facility_id')) {
            try {
                Schema::table('unit_facilities', function (Blueprint $table) {
                    $table->foreign('facility_id')
                        ->references('id')
                        ->on('amenities')
                        ->onDelete('cascade');
                });
            } catch (\Throwable $e) {
                // Ignore if FK already exists or cannot be added (db-specific state)
            }
        }

        if (Schema::hasTable('property_facilities') && Schema::hasColumn('property_facilities', 'facility_id')) {
            try {
                Schema::table('property_facilities', function (Blueprint $table) {
                    $table->foreign('facility_id')
                        ->references('id')
                        ->on('amenities')
                        ->onDelete('cascade');
                });
            } catch (\Throwable $e) {
                // Ignore if FK already exists or cannot be added (db-specific state)
            }
        }
    }

    public function down(): void
    {
        // Best-effort rollback (names may differ if previously created outside migrations)
        if (Schema::hasTable('unit_facilities')) {
            try {
                Schema::table('unit_facilities', function (Blueprint $table) {
                    $table->dropForeign(['facility_id']);
                });
            } catch (\Throwable $e) {
            }
        }

        if (Schema::hasTable('property_facilities')) {
            try {
                Schema::table('property_facilities', function (Blueprint $table) {
                    $table->dropForeign(['facility_id']);
                });
            } catch (\Throwable $e) {
            }
        }
    }
};

