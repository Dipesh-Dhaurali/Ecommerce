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
        // Users table indexes
        Schema::table('users', function (Blueprint $table) {
            $table->index('email');
            $table->index('role');
        });

        // Inventories table indexes
        Schema::table('inventories', function (Blueprint $table) {
            $table->index('slug');
            $table->index('sku');
            $table->index('category_id');
            $table->index('brand_id');
            $table->index('is_popular');
        });

        // Categories table indexes
        Schema::table('categories', function (Blueprint $table) {
            $table->index('slug');
            $table->index('parent_id');
        });

        // Orders table indexes
        Schema::table('orders', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('status');
            $table->index('payment_status');
            $table->index('payment_method');
            $table->index('created_at');
        });

        // Reviews table indexes
        Schema::table('reviews', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('inventory_id');
            $table->index('order_id');
            $table->index('approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Users table indexes
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['role']);
        });

        // Inventories table indexes
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropIndex(['sku']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['brand_id']);
            $table->dropIndex(['is_popular']);
        });

        // Categories table indexes
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropIndex(['parent_id']);
        });

        // Orders table indexes
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['payment_status']);
            $table->dropIndex(['payment_method']);
            $table->dropIndex(['created_at']);
        });

        // Reviews table indexes
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['inventory_id']);
            $table->dropIndex(['order_id']);
            $table->dropIndex(['approved']);
        });
    }
};
