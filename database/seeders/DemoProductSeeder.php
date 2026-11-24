<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Data contoh untuk tampilan lokal: 3 akun uji, kategori (kalau belum ada), dan produk bergambar.
 * Aman dijalankan berulang: produk yang sudah ada dilewati, foto disalin ulang.
 * Hanya kolom yang benar-benar ada di tabel yang diisi.
 */
class DemoProductSeeder extends Seeder
{
    private function row(string $table, array $data): array
    {
        return array_intersect_key($data, array_flip(Schema::getColumnListing($table)));
    }

    private function user(string $email, string $name, string $role, string $phone): int
    {
        $found = DB::table('users')->where('email', $email)->first();
        if ($found) {
            return $found->id;
        }

        $now = now();

        return DB::table('users')->insertGetId($this->row('users', [
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password123'),
            'role' => $role,
            'phone' => $phone,
            'address' => 'Makassar',
            'email_verified_at' => $now,
            'phone_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]));
    }

    private function category(string $keyword, string $name): int
    {
        $found = DB::table('categories')->where('name', 'like', "%{$keyword}%")->first();
        if ($found) {
            return $found->id;
        }

        $now = now();

        return DB::table('categories')->insertGetId($this->row('categories', [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $name,
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]));
    }

    public function run(): void
    {
        $sellerId = $this->user('toko@afterwear.test', 'Toko Arsip Kurasi', 'seller', '081234567890');
        $this->user('admin@afterwear.test', 'Admin After Wear', 'admin', '081200000001');
        $this->user('pembeli@afterwear.test', 'Pembeli Contoh', 'buyer', '081200000002');

        $items = [
            ['produk-1.jpg', 'Kemeja Linen Uniqlo Oversized', ['Atasan', 'Atasan'],            125000, 'Seperti Baru', '100% Linen',        '2–3 kali pemakaian',  null,                                      'Antang',         'ready'],
            ['produk-2.jpg', 'Dress Midi Floral Zara',        ['Dress', 'Dress & Terusan'],     175000, 'Baik',         'Katun rayon',       'Sekitar 1 tahun',     'Bekas lipatan halus di bagian pinggang.', 'Sungai Saddang', 'ready'],
            ['produk-3.jpg', 'Celana Kulot Loose Fit',        ['Bawahan', 'Bawahan'],           140000, 'Seperti Baru', 'Katun twill',       'Beberapa kali pakai', null,                                      'Gowa',           'ready'],
            ['produk-4.jpg', 'Cardigan Wool Blend Chunky',    ['Outer', 'Outerwear'],           190000, 'Baik',         'Campuran wol',      'Sekitar 1 tahun',     null,                                      'Karunrung',      'sold_out'],
            ['produk-5.jpg', 'Rok Plisket A-Line Matte Black', ['Bawahan', 'Bawahan'],          115000, 'Seperti Baru', 'Poliester plisket', 'Beberapa kali pakai', null,                                      'Faisal 9',       'ready'],
            ['produk-6.jpg', 'Kemeja Oxford Monokrom',        ['Atasan', 'Atasan'],             145000, 'Seperti Baru', 'Katun oxford',      '2–3 kali pemakaian',  null,                                      'Jaksel',         'ready'],
            ['produk-7.jpg', 'Kemeja Denim Vintage',          ['Atasan', 'Atasan'],             180000, 'Baik',         'Denim',             'Sekitar 2 tahun',     'Warna sedikit pudar alami.',              'Jaksel',         'ready'],
            ['produk-8.jpg', 'Overshirt Flannel Charcoal',    ['Atasan', 'Atasan'],             155000, 'Seperti Baru', 'Flanel wol',        'Satu musim',          null,                                      'Jaktim',         'ready'],
        ];

        File::ensureDirectoryExists(storage_path('app/public/products'));
        $made = 0;

        foreach ($items as [$file, $name, $cat, $price, $cond, $material, $usage, $flaws, $loc, $status]) {
            $src = public_path('images/demo/' . $file);
            if (! File::exists($src)) {
                continue;
            }

            // Foto selalu disalin ulang supaya versi terbaru ikut terpakai.
            File::copy($src, storage_path('app/public/products/' . $file));

            $slug = Str::slug($name);
            if (DB::table('products')->where('slug', $slug)->exists()) {
                continue;
            }

            $now = now();
            $productId = DB::table('products')->insertGetId($this->row('products', [
                'seller_id' => $sellerId,
                'category_id' => $this->category($cat[0], $cat[1]),
                'name' => $name,
                'slug' => $slug,
                'description' => 'Pakaian preloved terkurasi dalam kondisi terawat. Hubungi penjual via WhatsApp untuk video detail dan konfirmasi ukuran.',
                'price' => $price,
                'item_condition' => $cond,
                'material' => $material,
                'usage_duration' => $usage,
                'flaws' => $flaws,
                'location' => $loc,
                'status' => $status,
                'approval_status' => 'approved',
                'created_at' => $now,
                'updated_at' => $now,
            ]));

            DB::table('product_media')->insert($this->row('product_media', [
                'product_id' => $productId,
                'media_type' => 'image',
                'file_path' => 'products/' . $file,
                'sort_order' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]));

            $made++;
        }

        $this->command?->info("Selesai: {$made} produk baru ditambahkan.");
        $this->command?->info('Akun uji (kata sandi: password123): toko@afterwear.test (penjual), admin@afterwear.test, pembeli@afterwear.test');
    }
}