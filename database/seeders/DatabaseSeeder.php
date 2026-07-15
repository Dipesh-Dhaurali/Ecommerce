<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

    }
}
