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
            'Groceries' => ['Rice', 'Dal', 'Spices'],
            'Electronics' => ['Phones', 'Accessories'],
            'Snacks' => ['Chips', 'Biscuits']
        ];

        foreach ($categories as $parentName => $children) {
            $parent = Category::create([
                'name' => $parentName,
                'slug' => Str::slug($parentName),
            ]);

            foreach ($children as $childName) {
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
            ['name' => 'Premium Basmati Rice 5kg', 'price' => 1200, 'cost_price' => 1000, 'cat' => 'rice', 'brand' => 'local', 'img_seed' => 'basmati-rice-grain'],
            ['name' => 'Sona Masoori Rice 10kg', 'price' => 1500, 'cost_price' => 1300, 'cat' => 'rice', 'brand' => 'local', 'img_seed' => 'sona-masoori-rice'],
            ['name' => 'Brown Rice 2kg', 'price' => 450, 'cost_price' => 380, 'cat' => 'rice', 'brand' => 'local', 'img_seed' => 'brown-rice-grain'],
            
            // Groceries - Dal
            ['name' => 'Masoor Dal 1kg', 'price' => 150, 'cost_price' => 120, 'cat' => 'dal', 'brand' => 'local', 'img_seed' => 'red-lentils-masoor-dal'],
            ['name' => 'Toor Dal 1kg', 'price' => 180, 'cost_price' => 150, 'cat' => 'dal', 'brand' => 'local', 'img_seed' => 'pigeon-peas-toor-dal'],
            ['name' => 'Chana Dal 1kg', 'price' => 120, 'cost_price' => 100, 'cat' => 'dal', 'brand' => 'local', 'img_seed' => 'split-chickpeas-chana-dal'],
            
            // Spices
            ['name' => 'Turmeric Powder 100g', 'price' => 80, 'cost_price' => 60, 'cat' => 'spices', 'brand' => 'local', 'img_seed' => 'turmeric-powder-haldi'],
            ['name' => 'Red Chili Powder 100g', 'price' => 90, 'cost_price' => 70, 'cat' => 'spices', 'brand' => 'local', 'img_seed' => 'red-chili-powder'],
            ['name' => 'Cumin Seeds 100g', 'price' => 70, 'cost_price' => 50, 'cat' => 'spices', 'brand' => 'local', 'img_seed' => 'cumin-seeds-jeera'],
            
            // Snacks - Chips
            ['name' => 'Lays Potato Chips - Magic Masala', 'price' => 50, 'cost_price' => 40, 'cat' => 'chips', 'brand' => 'unilever', 'img_seed' => 'potato-chips-packet'],
            ['name' => 'Kurkure - Green Chutney', 'price' => 35, 'cost_price' => 25, 'cat' => 'chips', 'brand' => 'unilever', 'img_seed' => 'spicy-snacks-crisps'],
            ['name' => 'Bingo! Mad Angle - Spicy', 'price' => 40, 'cost_price' => 30, 'cat' => 'chips', 'brand' => 'local', 'img_seed' => 'corn-chips-snack'],
            
            // Biscuits
            ['name' => 'Parle-G Original Biscuits', 'price' => 20, 'cost_price' => 15, 'cat' => 'biscuits', 'brand' => 'local', 'img_seed' => 'glucose-biscuits-packet'],
            ['name' => 'Hide & Seek Choco Chip', 'price' => 60, 'cost_price' => 50, 'cat' => 'biscuits', 'brand' => 'unilever', 'img_seed' => 'chocolate-chip-cookies'],
            ['name' => 'Good Day Butter Cookies', 'price' => 55, 'cost_price' => 45, 'cat' => 'biscuits', 'brand' => 'unilever', 'img_seed' => 'butter-cookies'],
            
            // Electronics - Phones
            ['name' => 'Samsung Galaxy S23', 'price' => 120000, 'cost_price' => 110000, 'cat' => 'phones', 'brand' => 'samsung', 'img_seed' => 'samsung-galaxy-smartphone'],
            ['name' => 'Samsung Galaxy A54', 'price' => 45000, 'cost_price' => 40000, 'cat' => 'phones', 'brand' => 'samsung', 'img_seed' => 'android-smartphone-device'],
            ['name' => 'Apple iPhone 15', 'price' => 150000, 'cost_price' => 140000, 'cat' => 'phones', 'brand' => 'apple', 'img_seed' => 'apple-iphone-smartphone'],
            
            // Electronics - Accessories
            ['name' => 'Samsung Galaxy Buds 2', 'price' => 12000, 'cost_price' => 10000, 'cat' => 'accessories', 'brand' => 'samsung', 'img_seed' => 'wireless-earbuds-bluetooth'],
            ['name' => 'Apple AirPods Pro', 'price' => 25000, 'cost_price' => 22000, 'cat' => 'accessories', 'brand' => 'apple', 'img_seed' => 'airpods-wireless-earphones'],
            
            // Other Groceries
            ['name' => 'Nescafe Classic 50g', 'price' => 200, 'cost_price' => 180, 'cat' => 'groceries', 'brand' => 'nestle', 'img_seed' => 'coffee-powder-jar'],
            ['name' => 'Lipton Green Tea 100 Bags', 'price' => 350, 'cost_price' => 300, 'cat' => 'groceries', 'brand' => 'unilever', 'img_seed' => 'green-tea-bags-cup'],
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
                'image' => 'https://picsum.photos/seed/' . $p['img_seed'] . '/400/400',
            ]);
        }
    }
}
