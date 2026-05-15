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
        Schema::table('packages', function (Blueprint $table) {
            $table->string('difficulty')->default('Moderate')->after('type'); // Easy, Moderate, Hard
            $table->integer('min_people')->default(2)->after('price');
            $table->integer('max_people')->default(12)->after('min_people');
            $table->json('highlights')->nullable()->after('description'); // Array of strings
            $table->string('best_time_to_visit')->nullable()->after('highlights');
            $table->json('accommodation_details')->nullable()->after('best_time_to_visit'); // JSON for flexibility
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn([
                'difficulty',
                'min_people',
                'max_people',
                'highlights',
                'best_time_to_visit',
                'accommodation_details'
            ]);
        });
    }
};
