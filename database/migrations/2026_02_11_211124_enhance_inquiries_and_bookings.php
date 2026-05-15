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
        Schema::table('inquiries', function (Blueprint $table) {
            $table->string('priority')->default('medium'); // low, medium, high
            $table->unsignedBigInteger('assigned_to')->nullable(); // user_id
            $table->text('notes')->nullable(); // Internal notes log
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->json('traveler_info')->nullable(); // Array of travelers (name, passport, etc.)
            $table->string('payment_status')->default('unpaid'); // unpaid, partial, paid, refunded
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->date('payment_due_date')->nullable();
            $table->text('internal_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn(['status', 'priority', 'assigned_to', 'notes']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->dropColumn(['package_id', 'traveler_info', 'payment_status', 'paid_amount', 'payment_due_date', 'internal_notes']);
        });
    }
};
