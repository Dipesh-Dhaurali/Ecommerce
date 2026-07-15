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
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('refund_requested')->default(false);
            $table->text('refund_reason')->nullable();
            $table->timestamp('refund_requested_at')->nullable();
            $table->string('refund_status')->default('pending')->comment('pending, approved, rejected');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['refund_requested', 'refund_reason', 'refund_requested_at', 'refund_status']);
        });
    }
};
