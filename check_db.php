<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Existing Categories ===\n";
$categories = App\Models\Category::all(['id', 'name']);
foreach ($categories as $cat) {
    echo $cat->id . ': ' . $cat->name . "\n";
}

echo "\n=== Existing Brands ===\n";
$brands = App\Models\Brand::all(['id', 'name']);
foreach ($brands as $brand) {
    echo $brand->id . ': ' . $brand->name . "\n";
}

echo "\n=== Product Count ===\n";
echo "Total products: " . App\Models\Inventory::count() . "\n";
