<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@e-mart.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Customer user
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@e-mart.test',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Settings
        Setting::create([
            'site_name' => 'e-mart',
            'email' => 'hello@e-mart.test',
            'currency' => 'Rs.',
            'phone' => '9800000000',
        ]);

        // Brands
        $brands = ['Apple', 'Samsung', 'Nestle', 'Unilever', 'Local'];
        foreach ($brands as $brand) {
            Brand::create(['name' => $brand]);
        }

        // Categories
        $categories = [
            'Groceries' => [
                'children' => ['Rice', 'Dal', 'Spices'],
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=400&h=400&fit=crop'
            ],
            'Electronics' => [
                'children' => ['Phones', 'Accessories'],
                'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=400&h=400&fit=crop'
            ],
            'Snacks' => [
                'children' => ['Chips', 'Biscuits'],
                'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400&h=400&fit=crop'
            ]
        ];

        foreach ($categories as $parentName => $data) {
            $parent = Category::create([
                'name' => $parentName,
                'slug' => Str::slug($parentName),
                'image' => $data['image'],
            ]);

            foreach ($data['children'] as $childName) {
                Category::create([
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'parent_id' => $parent->id,
                ]);
            }
        }

        // Products (Inventories)
        $products = [
            // Groceries - Rice
            ['name' => 'Premium Basmati Rice 5kg', 'price' => 1200, 'cost_price' => 1000, 'cat' => 'rice', 'brand' => 'local', 'image' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=400&h=400&fit=crop'],
            ['name' => 'Sona Masoori Rice 10kg', 'price' => 1500, 'cost_price' => 1300, 'cat' => 'rice', 'brand' => 'local', 'image' => 'https://images.unsplash.com/photo-1596423014370-26104a0d0c0d?w=400&h=400&fit=crop'],
            ['name' => 'Brown Rice 2kg', 'price' => 450, 'cost_price' => 380, 'cat' => 'rice', 'brand' => 'local', 'image' => 'https://images.unsplash.com/photo-1536304993880-7717b4d5b5f3?w=400&h=400&fit=crop'],
            
            // Groceries - Dal
            ['name' => 'Masoor Dal 1kg', 'price' => 150, 'cost_price' => 120, 'cat' => 'dal', 'brand' => 'local', 'image' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=400&h=400&fit=crop'],
            ['name' => 'Toor Dal 1kg', 'price' => 180, 'cost_price' => 150, 'cat' => 'dal', 'brand' => 'local', 'image' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=400&h=400&fit=crop'],
            ['name' => 'Chana Dal 1kg', 'price' => 120, 'cost_price' => 100, 'cat' => 'dal', 'brand' => 'local', 'image' => 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=400&h=400&fit=crop'],
            
            // Spices
            ['name' => 'Turmeric Powder 100g', 'price' => 80, 'cost_price' => 60, 'cat' => 'spices', 'brand' => 'local', 'image' => 'https://images.unsplash.com/photo-1615485360850-8e1b9e7c2734?w=400&h=400&fit=crop'],
            ['name' => 'Red Chili Powder 100g', 'price' => 90, 'cost_price' => 70, 'cat' => 'spices', 'brand' => 'local', 'image' => 'https://images.unsplash.com/photo-1599909533681-74084efc63f9?w=400&h=400&fit=crop'],
            ['name' => 'Cumin Seeds 100g', 'price' => 70, 'cost_price' => 50, 'cat' => 'spices', 'brand' => 'local', 'image' => 'https://images.unsplash.com/photo-1599940824399-b87987ce9a7b?w=400&h=400&fit=crop'],
            
            // Snacks - Chips
            ['name' => 'Lays Potato Chips - Magic Masala', 'price' => 50, 'cost_price' => 40, 'cat' => 'chips', 'brand' => 'unilever', 'image' => 'https://images.unsplash.com/photo-1566478989037-eec170784d0b?w=400&h=400&fit=crop'],
            ['name' => 'Kurkure - Green Chutney', 'price' => 35, 'cost_price' => 25, 'cat' => 'chips', 'brand' => 'unilever', 'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400&h=400&fit=crop'],
            ['name' => 'Bingo! Mad Angle - Spicy', 'price' => 40, 'cost_price' => 30, 'cat' => 'chips', 'brand' => 'local', 'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400&h=400&fit=crop'],
            
            // Biscuits
            ['name' => 'Parle-G Original Biscuits', 'price' => 20, 'cost_price' => 15, 'cat' => 'biscuits', 'brand' => 'local', 'image' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=400&h=400&fit=crop'],
            ['name' => 'Hide & Seek Choco Chip', 'price' => 60, 'cost_price' => 50, 'cat' => 'biscuits', 'brand' => 'unilever', 'image' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=400&h=400&fit=crop'],
            ['name' => 'Good Day Butter Cookies', 'price' => 55, 'cost_price' => 45, 'cat' => 'biscuits', 'brand' => 'unilever', 'image' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=400&h=400&fit=crop'],
            
            // Electronics - Phones
            ['name' => 'Samsung Galaxy S23', 'price' => 120000, 'cost_price' => 110000, 'cat' => 'phones', 'brand' => 'samsung', 'image' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=400&h=400&fit=crop'],
            ['name' => 'Samsung Galaxy A54', 'price' => 45000, 'cost_price' => 40000, 'cat' => 'phones', 'brand' => 'samsung', 'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=400&fit=crop'],
            ['name' => 'Apple iPhone 15', 'price' => 150000, 'cost_price' => 140000, 'cat' => 'phones', 'brand' => 'apple', 'image' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=400&h=400&fit=crop'],
            
            // Electronics - Accessories
            ['name' => 'Samsung Galaxy Buds 2', 'price' => 12000, 'cost_price' => 10000, 'cat' => 'accessories', 'brand' => 'samsung', 'image' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=400&h=400&fit=crop'],
            ['name' => 'Apple AirPods Pro', 'price' => 25000, 'cost_price' => 22000, 'cat' => 'accessories', 'brand' => 'apple', 'image' => 'https://images.unsplash.com/photo-1606220588913-b3aacb4d2f46?w=400&h=400&fit=crop'],
            
            // Other Groceries
            ['name' => 'Nescafe Classic 50g', 'price' => 200, 'cost_price' => 180, 'cat' => 'groceries', 'brand' => 'nestle', 'image' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=400&h=400&fit=crop'],
            ['name' => 'Lipton Green Tea 100 Bags', 'price' => 350, 'cost_price' => 300, 'cat' => 'groceries', 'brand' => 'unilever', 'image' => 'https://images.unsplash.com/photo-1556881286-fc6915169721?w=400&h=400&fit=crop'],
        ];

        foreach ($products as $p) {
            $cat = Category::where('slug', $p['cat'])->first() ?? Category::first();
            $brand = Brand::where('name', 'like', '%'.$p['brand'].'%')->first() ?? Brand::first();
            
            Inventory::create([
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'description' => 'High-quality ' . strtolower($p['name']) . ' available at best price!',
                'sku' => strtoupper(Str::random(6)),
                'price' => $p['price'],
                'cost_price' => $p['cost_price'],
                'stock' => rand(10, 100),
                'category_id' => $cat->id,
                'brand_id' => $brand->id,
                'has_vat' => false,
                'is_popular' => rand(0, 1),
                'image' => $p['image'],
            ]);
        }
    }
}
