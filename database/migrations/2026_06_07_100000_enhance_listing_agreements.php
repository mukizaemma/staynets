<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('listing_agreement_templates', function (Blueprint $table) {
            $table->string('platform_email')->nullable()->after('platform_name');
            $table->string('platform_website')->nullable()->after('platform_email');
            $table->string('platform_phone')->nullable()->after('platform_website');
            $table->string('platform_tagline')->nullable()->after('platform_phone');
            $table->unsignedSmallInteger('damage_report_hours')->default(24)->after('intro_text');
            $table->unsignedSmallInteger('termination_notice_days')->default(30)->after('damage_report_hours');
            $table->string('commission_rate')->default('5%')->after('termination_notice_days');
            $table->string('payment_method')->nullable()->after('commission_rate');
            $table->string('payment_timeline')->nullable()->after('payment_method');
            $table->string('footer_services_text')->nullable()->after('payment_timeline');
        });

        Schema::table('listing_agreement_signatures', function (Blueprint $table) {
            $table->string('status')->default('draft')->after('signable_type');
            $table->string('host_printed_name')->nullable()->after('owner_signature_path');
            $table->date('start_date')->nullable()->after('host_printed_name');
            $table->string('admin_signature_path')->nullable()->after('start_date');
            $table->timestamp('admin_approved_at')->nullable()->after('admin_signature_path');
            $table->unsignedBigInteger('admin_approved_by')->nullable()->after('admin_approved_at');
            $table->text('admin_notes')->nullable()->after('admin_approved_by');
        });

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'signature_path')) {
                $table->string('signature_path')->nullable()->after('status');
            }
        });

        \Illuminate\Support\Facades\DB::table('listing_agreement_signatures')
            ->whereNotNull('signed_at')
            ->whereNotNull('owner_signature_path')
            ->update(['status' => 'signed']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'signature_path')) {
                $table->dropColumn('signature_path');
            }
        });

        Schema::table('listing_agreement_signatures', function (Blueprint $table) {
            $table->dropColumn([
                'status', 'host_printed_name', 'start_date', 'admin_signature_path',
                'admin_approved_at', 'admin_approved_by', 'admin_notes',
            ]);
        });

        Schema::table('listing_agreement_templates', function (Blueprint $table) {
            $table->dropColumn([
                'platform_email', 'platform_website', 'platform_phone', 'platform_tagline',
                'damage_report_hours', 'termination_notice_days', 'commission_rate',
                'payment_method', 'payment_timeline', 'footer_services_text',
            ]);
        });
    }
};
