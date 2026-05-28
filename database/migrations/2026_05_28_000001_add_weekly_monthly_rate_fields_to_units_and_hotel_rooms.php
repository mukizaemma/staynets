<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {
            if (!Schema::hasColumn('units', 'base_price_per_week')) {
                $table->decimal('base_price_per_week', 10, 2)->nullable()->after('base_price_per_night');
            }
            if (!Schema::hasColumn('units', 'enable_weekly_rate')) {
                $table->boolean('enable_weekly_rate')->default(false)->after('base_price_per_week');
            }
            if (!Schema::hasColumn('units', 'enable_monthly_rate')) {
                $table->boolean('enable_monthly_rate')->default(false)->after('enable_weekly_rate');
            }
        });

        Schema::table('hotel_rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('hotel_rooms', 'price_per_week')) {
                $table->decimal('price_per_week', 10, 2)->nullable()->after('price_per_night');
            }
            if (!Schema::hasColumn('hotel_rooms', 'enable_weekly_rate')) {
                $table->boolean('enable_weekly_rate')->default(false)->after('price_per_week');
            }
            if (!Schema::hasColumn('hotel_rooms', 'enable_monthly_rate')) {
                $table->boolean('enable_monthly_rate')->default(false)->after('enable_weekly_rate');
            }
            if (!Schema::hasColumn('hotel_rooms', 'price_per_month')) {
                // Some databases might have this via earlier patches; keep safe.
                $table->decimal('price_per_month', 10, 2)->nullable()->after('enable_monthly_rate');
            }
        });
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            if (Schema::hasColumn('units', 'enable_monthly_rate')) {
                $table->dropColumn('enable_monthly_rate');
            }
            if (Schema::hasColumn('units', 'enable_weekly_rate')) {
                $table->dropColumn('enable_weekly_rate');
            }
            if (Schema::hasColumn('units', 'base_price_per_week')) {
                $table->dropColumn('base_price_per_week');
            }
        });

        Schema::table('hotel_rooms', function (Blueprint $table) {
            if (Schema::hasColumn('hotel_rooms', 'enable_monthly_rate')) {
                $table->dropColumn('enable_monthly_rate');
            }
            if (Schema::hasColumn('hotel_rooms', 'enable_weekly_rate')) {
                $table->dropColumn('enable_weekly_rate');
            }
            if (Schema::hasColumn('hotel_rooms', 'price_per_week')) {
                $table->dropColumn('price_per_week');
            }
            // Do not drop price_per_month here (pre-existing in the app).
        });
    }
};

