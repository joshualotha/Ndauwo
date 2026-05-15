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
        Schema::table('destinations', function (Blueprint $table) {
            if (!Schema::hasColumn('destinations', 'intro')) {
                $table->text('intro')->nullable()->after('description');
            }
        });

        Schema::table('packages', function (Blueprint $table) {
            if (!Schema::hasColumn('packages', 'daily_itinerary')) {
                $table->json('daily_itinerary')->nullable()->after('itinerary');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['intro']);
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['daily_itinerary']);
        });
    }
};
