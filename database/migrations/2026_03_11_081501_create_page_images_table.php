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
        Schema::create('page_images', function (Blueprint $table) {
            $table->id();
            $table->string('page')->index(); // e.g. 'home', 'about', 'contact'
            $table->string('section')->index(); // e.g. 'hero_bg', 'content_image_1'
            $table->string('image_path');
            $table->string('description')->nullable(); // For admin UI label
            $table->timestamps();
            
            // A page should only have one image per section
            $table->unique(['page', 'section']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_images');
    }
};
