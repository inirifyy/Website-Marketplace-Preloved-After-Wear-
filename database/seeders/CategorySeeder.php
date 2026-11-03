<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Atasan',
                'slug' => 'atasan',
                'description' => 'Koleksi atasan preloved pilihan: kaos branded, kemeja santai & formal, blus, hingga sweater hangat.',
                'icon' => 'fa-tshirt',
                'image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=600&auto=format&fit=crop&q=80',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Bawahan',
                'slug' => 'bawahan',
                'description' => 'Celana jeans denim, celana panjang bahan, celana pendek, hingga rok stylish layak pakai.',
                'icon' => 'fa-vest',
                'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=600&auto=format&fit=crop&q=80',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Outerwear',
                'slug' => 'outerwear',
                'description' => 'Jaket kulit, denim jacket, trench coat, hoodie, cardigan, dan blazer berkualitas tinggi.',
                'icon' => 'fa-vest-patches',
                'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600&auto=format&fit=crop&q=80',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Dress & Terusan',
                'slug' => 'dress-terusan',
                'description' => 'Gaun santai, midi dress floral, dress pesta elegan, hingga jumpsuit modis.',
                'icon' => 'fa-person-dress',
                'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=600&auto=format&fit=crop&q=80',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Sepatu & Alas Kaki',
                'slug' => 'sepatu-alas-kaki',
                'description' => 'Sneakers vintage, boots kulit, loafers, dan sandal kasual terawat prima.',
                'icon' => 'fa-shoe-prints',
                'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=600&auto=format&fit=crop&q=80',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'Tas & Aksesoris',
                'slug' => 'tas-aksesoris',
                'description' => 'Sling bag, tote bag kanvas, ransel vintage, ikat pinggang kulit, topi, dan perhiasan preloved.',
                'icon' => 'fa-bag-shopping',
                'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600&auto=format&fit=crop&q=80',
                'is_active' => true,
                'order' => 6,
            ],
            [
                'name' => 'Vintage & Retro',
                'slug' => 'vintage-retro',
                'description' => 'Koleksi langka era 70s, 80s, 90s, dan Y2K bagi penggemar thrifting sejati.',
                'icon' => 'fa-record-vinyl',
                'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=600&auto=format&fit=crop&q=80',
                'is_active' => true,
                'order' => 7,
            ],
            [
                'name' => 'Streetwear',
                'slug' => 'streetwear',
                'description' => 'Oversized graphic tee, cargo pants, flannel shirt, dan gaya urban masa kini.',
                'icon' => 'fa-fire',
                'image' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=600&auto=format&fit=crop&q=80',
                'is_active' => true,
                'order' => 8,
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }
    }
}

