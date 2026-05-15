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
            $table->string('label')->nullable()->after('name');
            $table->string('area')->nullable()->after('best_time_to_visit');
            $table->string('signature_experience')->nullable()->after('area');
            $table->string('pull_quote')->nullable()->after('signature_experience');
            $table->text('geography')->nullable()->after('pull_quote');
            $table->text('ecology')->nullable()->after('geography');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn([
                'label',
                'area',
                'signature_experience',
                'pull_quote',
                'geography',
                'ecology',
            ]);
        });
    }
};
