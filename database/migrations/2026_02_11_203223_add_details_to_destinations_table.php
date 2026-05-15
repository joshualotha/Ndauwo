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
            $table->json('highlights')->nullable()->after('description');
            $table->json('wildlife')->nullable()->after('highlights'); // Array of species
            $table->string('best_time_to_visit')->nullable()->after('wildlife');
            $table->string('map_embed_url')->nullable()->after('best_time_to_visit');
            $table->json('accommodation_details')->nullable()->after('map_embed_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn([
                'highlights',
                'wildlife',
                'best_time_to_visit',
                'map_embed_url',
                'accommodation_details'
            ]);
        });
    }
};
