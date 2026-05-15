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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('rating'); // 1-5
            $table->text('content');
            $table->string('image')->nullable();
            $table->string('video_url')->nullable();
            $table->string('source')->default('Website'); // Website, TripAdvisor, Google, SafariBookings
            $table->string('safari_type')->nullable(); // Wildlife, Kilimanjaro, etc.
            $table->boolean('active')->default(false); // Moderation required
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
