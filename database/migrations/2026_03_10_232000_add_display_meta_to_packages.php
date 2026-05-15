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
            $table->string('hero_label')->nullable()->after('title');
            $table->string('location_summary')->nullable()->after('hero_label');
            $table->string('duration_label')->nullable()->after('duration_days');
            $table->string('group_size')->nullable()->after('duration_label');
            $table->string('badge')->nullable()->after('image');
            $table->string('signature_experience')->nullable()->after('badge');
            $table->text('pull_quote')->nullable()->after('signature_experience');
            $table->json('feature_icons')->nullable()->after('pull_quote');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn([
                'hero_label',
                'location_summary',
                'duration_label',
                'group_size',
                'badge',
                'signature_experience',
                'pull_quote',
                'feature_icons'
            ]);
        });
    }
};
