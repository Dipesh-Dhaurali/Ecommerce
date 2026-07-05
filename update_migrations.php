<?php
$dir = __DIR__ . '/database/migrations/';
$files = scandir($dir);

$updates = [
    'create_users_table.php' => "\$table->string('role')->default('customer');\n            \$table->string('name');",
    'create_brands_table.php' => "\$table->string('name');\n            \$table->timestamps();",
    'create_categories_table.php' => "\$table->string('name');\n            \$table->string('slug')->unique();\n            \$table->string('image')->nullable();\n            \$table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();\n            \$table->timestamps();",
    'create_inventories_table.php' => "\$table->string('name');\n            \$table->string('slug')->unique();\n            \$table->string('sku')->nullable();\n            \$table->decimal('price', 10, 2);\n            \$table->decimal('cost_price', 10, 2)->nullable();\n            \$table->integer('stock')->default(0);\n            \$table->string('image')->nullable();\n            \$table->text('description')->nullable();\n            \$table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();\n            \$table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();\n            \$table->boolean('has_vat')->default(false);\n            \$table->boolean('is_popular')->default(false);\n            \$table->string('barcode')->nullable();\n            \$table->timestamps();",
    'create_orders_table.php' => "\$table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();\n            \$table->string('customer_name')->nullable();\n            \$table->string('customer_phone')->nullable();\n            \$table->text('customer_address')->nullable();\n            \$table->string('order_type')->default('online');\n            \$table->string('status')->default('pending');\n            \$table->decimal('subtotal', 12, 2)->default(0);\n            \$table->decimal('discount', 12, 2)->default(0);\n            \$table->decimal('shipping', 12, 2)->default(0);\n            \$table->decimal('total', 12, 2)->default(0);\n            \$table->string('payment_status')->default('pending');\n            \$table->string('payment_method')->nullable();\n            \$table->text('notes')->nullable();\n            \$table->timestamps();",
    'create_order_items_table.php' => "\$table->foreignId('order_id')->constrained()->cascadeOnDelete();\n            \$table->foreignId('inventory_id')->constrained()->cascadeOnDelete();\n            \$table->integer('quantity');\n            \$table->decimal('price', 10, 2);\n            \$table->decimal('total', 12, 2);\n            \$table->timestamps();",
    'create_register_logs_table.php' => "\$table->foreignId('user_id')->constrained()->cascadeOnDelete();\n            \$table->timestamp('opened_at')->nullable();\n            \$table->timestamp('closed_at')->nullable();\n            \$table->string('status')->default('open');\n            \$table->decimal('opening_balance', 12, 2)->default(0);\n            \$table->decimal('closing_balance', 12, 2)->nullable();\n            \$table->text('notes')->nullable();\n            \$table->timestamps();",
    'create_wishlists_table.php' => "\$table->foreignId('user_id')->constrained()->cascadeOnDelete();\n            \$table->foreignId('inventory_id')->constrained()->cascadeOnDelete();\n            \$table->timestamps();",
    'create_settings_table.php' => "\$table->string('site_name')->nullable();\n            \$table->string('logo')->nullable();\n            \$table->text('address')->nullable();\n            \$table->string('phone')->nullable();\n            \$table->string('email')->nullable();\n            \$table->string('currency')->default('Rs.');\n            \$table->timestamps();",
];

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    
    foreach ($updates as $key => $replaceWith) {
        if (str_ends_with($file, $key)) {
            $content = file_get_contents($dir . $file);
            if ($key === 'create_users_table.php') {
                $content = str_replace("\$table->string('name');", $replaceWith, $content);
            } else {
                $content = str_replace("\$table->timestamps();", $replaceWith, $content);
            }
            file_put_contents($dir . $file, $content);
            echo "Updated $file\n";
        }
    }
}
