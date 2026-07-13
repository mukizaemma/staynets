<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('listing_agreement_templates')) {
            return;
        }

        Schema::table('listing_agreement_templates', function (Blueprint $table) {
            if (! Schema::hasColumn('listing_agreement_templates', 'page_break_after')) {
                $table->unsignedSmallInteger('page_break_after')->default(6)->after('footer_services_text');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('listing_agreement_templates')) {
            return;
        }

        Schema::table('listing_agreement_templates', function (Blueprint $table) {
            if (Schema::hasColumn('listing_agreement_templates', 'page_break_after')) {
                $table->dropColumn('page_break_after');
            }
        });
    }
};
