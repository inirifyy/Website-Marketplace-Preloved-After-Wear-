<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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

        // 3. Akun demo. Aman dijalankan berulang (db:seed) -- akun yang sudah ada diperbarui.
        //
        // PENTING: 'role' sengaja TIDAK ada di $fillable model User (agar tidak bisa
        // diubah lewat form). Karena itu User::updateOrCreate([... 'role' => 'admin'])
        // DIAM-DIAM membuang role dan akun admin berakhir sebagai 'buyer'.
        // forceFill() dipakai agar role benar-benar tersimpan.
        $accounts = [
            ['email' => 'admin@afterwear.test',  'name' => 'Admin After Wear',      'role' => User::ROLE_ADMIN,  'phone' => '6281234567890'],
            ['email' => 'seller@afterwear.test', 'name' => 'Penjual After Wear',    'role' => User::ROLE_SELLER, 'phone' => '6281234567891'],
            ['email' => 'user@afterwear.test',   'name' => 'Pengguna After Wear',   'role' => User::ROLE_BUYER,  'phone' => '6289876543210'],
        ];

        foreach ($accounts as $account) {
            $user = User::firstOrNew(['email' => $account['email']]);

            $user->forceFill($account + [
                'password'          => 'password',  // di-hash otomatis oleh cast 'hashed'
                'phone_verified_at' => now(),       // akun demo dianggap sudah terverifikasi
            ])->save();
        }
    }
}
