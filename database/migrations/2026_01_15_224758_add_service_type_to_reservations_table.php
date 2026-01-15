<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Add service type: 'enquiry', 'hotel_booking', 'tour_booking', 'question'
            $table->enum('service_type', ['enquiry', 'hotel_booking', 'tour_booking', 'question'])->default('enquiry')->after('id');
            
            // Add fields for hotel booking
            $table->date('checkin_date')->nullable()->after('guests');
            $table->date('checkout_date')->nullable()->after('checkin_date');
            
            // Add fields for tour booking
            $table->unsignedBigInteger('tour_id')->nullable()->after('room_id');
            $table->date('tour_date')->nullable()->after('tour_id');
            $table->integer('tour_people')->nullable()->after('tour_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['service_type', 'checkin_date', 'checkout_date', 'tour_id', 'tour_date', 'tour_people']);
        });
    }
};
