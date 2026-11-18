<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Categories
        $this->call(CategorySeeder::class);

        // 2. Seed Site Contents (Banners & Education)
        $this->call(SiteContentSeeder::class);

        // 3. Seed Default Administrator
        User::updateOrCreate(
            ['email' => 'admin@afterwear.test'],
            [
                'name' => 'Admin After Wear',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081234567890',
            ]
        );

        // 4. Seed Regular Member/User
        User::updateOrCreate(
            ['email' => 'user@afterwear.test'],
            [
                'name' => 'Pengguna After Wear',
                'password' => Hash::make('password'),
                'role' => 'buyer',
                'phone' => '089876543210',
            ]
        );
    }
}
