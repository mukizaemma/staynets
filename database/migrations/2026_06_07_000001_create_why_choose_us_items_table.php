<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('why_choose_us_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon', 32)->nullable()->default('★');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        DB::table('why_choose_us_items')->insert([
            ['title' => 'Tailor-Made Tours', 'description' => 'Tailor-made tours across Rwanda & East Africa.', 'icon' => '★', 'sort_order' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Local Expert Guides', 'description' => 'Professional, local guides who know the region deeply.', 'icon' => '★', 'sort_order' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Rich Experiences', 'description' => 'Wildlife, primates, culture & scenic adventures.', 'icon' => '★', 'sort_order' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'For Every Budget', 'description' => 'Options for both luxury and budget-friendly travel.', 'icon' => '★', 'sort_order' => 4, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Hassle-Free Support', 'description' => 'Hassle-free booking and complete travel support.', 'icon' => '★', 'sort_order' => 5, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('why_choose_us_items');
    }
};
