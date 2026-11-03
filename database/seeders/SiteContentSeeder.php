<?php

namespace Database\Seeders;

use App\Models\SiteContent;
use Illuminate\Database\Seeder;

class SiteContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            // Hero Banner
            [
                'section' => 'hero_banner',
                'key' => 'main_hero',
                'title' => 'Gaya Berkelanjutan, Harga Lebih Bersahabat',
                'subtitle' => 'Temukan ribuan pakaian preloved terkurasi dengan kondisi prima. Belanja hemat, tampil modis, dan ikut menjaga bumi bersama After Wear.',
                'content' => 'Setiap pakaian bekas yang kamu beli memberikan nafas baru bagi industri fashion sirkular dan mengurangi limbah pakaian.',
                'image' => 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?w=1200&auto=format&fit=crop&q=80',
                'button_text' => 'Mulai Belanja',
                'button_url' => '#kategori',
                'is_active' => true,
                'order' => 1,
                'metadata' => [
                    'badge' => 'Platform Preloved Pilihan #1',
                    'highlight_text' => 'Diskon hingga 70%',
                ],
            ],

            // Education Section: Mengapa Preloved di After Wear?
            [
                'section' => 'education',
                'key' => 'edu_circular_fashion',
                'title' => 'Dukung Circular Fashion',
                'subtitle' => 'Langkah nyata selamatkan lingkungan',
                'content' => 'Membeli satu potong pakaian preloved dapat menghemat ribuan liter air dan mengurangi jejak karbon dibandingkan memproduksi pakaian baru.',
                'image' => 'https://images.unsplash.com/photo-1532453288672-3a27e9be9efd?w=600&auto=format&fit=crop&q=80',
                'button_text' => 'Pelajari Dampaknya',
                'button_url' => '/testimonials',
                'is_active' => true,
                'order' => 1,
                'metadata' => [
                    'icon' => 'fa-leaf',
                    'stat' => '80% Pengurangan Emisi',
                ],
            ],
            [
                'section' => 'education',
                'key' => 'edu_curated_quality',
                'title' => 'Kualitas Terkurasi & Higienis',
                'subtitle' => 'Kondisi transparan dan siap pakai',
                'content' => 'Semua pakaian melalui tahap kurasi kelayakan pakai, pengecekan noda, dan standar kebersihan sebelum dikirimkan ke pembeli.',
                'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=600&auto=format&fit=crop&q=80',
                'button_text' => 'Lihat Standar Mutu',
                'button_url' => '#kategori',
                'is_active' => true,
                'order' => 2,
                'metadata' => [
                    'icon' => 'fa-check-double',
                    'stat' => 'Grade A & Like New',
                ],
            ],
            [
                'section' => 'education',
                'key' => 'edu_smart_budget',
                'title' => 'Hemat Budget, Tetap Stylish',
                'subtitle' => 'Brand original dengan harga miring',
                'content' => 'Dapatkan brand fashion ternama lokal maupun internasional dengan potongan harga hingga 70% dari harga ritel aslinya.',
                'image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=600&auto=format&fit=crop&q=80',
                'button_text' => 'Cek Koleksi Brand',
                'button_url' => '#kategori',
                'is_active' => true,
                'order' => 3,
                'metadata' => [
                    'icon' => 'fa-wallet',
                    'stat' => 'Hemat s/d 70%',
                ],
            ],

            // Stats Counters
            [
                'section' => 'stat',
                'key' => 'stat_products',
                'title' => '1,500+',
                'subtitle' => 'Pakaian Terkurasi',
                'content' => 'Pilihan pakaian berkualitas yang siap dikirim.',
                'image' => null,
                'button_text' => null,
                'button_url' => null,
                'is_active' => true,
                'order' => 1,
                'metadata' => ['icon' => 'fa-shirt'],
            ],
            [
                'section' => 'stat',
                'key' => 'stat_users',
                'title' => '2,800+',
                'subtitle' => 'Pengguna Aktif',
                'content' => 'Komunitas pecinta fashion thrifting di After Wear.',
                'image' => null,
                'button_text' => null,
                'button_url' => null,
                'is_active' => true,
                'order' => 2,
                'metadata' => ['icon' => 'fa-users'],
            ],
            [
                'section' => 'stat',
                'key' => 'stat_carbon',
                'title' => '3,400+ kg',
                'subtitle' => 'Limbah Tekstil Dicegah',
                'content' => 'Dampak positif lingkungan yang tercipta bersama.',
                'image' => null,
                'button_text' => null,
                'button_url' => null,
                'is_active' => true,
                'order' => 3,
                'metadata' => ['icon' => 'fa-seedling'],
            ],
        ];

        foreach ($contents as $item) {
            SiteContent::updateOrCreate(
                ['key' => $item['key']],
                $item
            );
        }
    }
}

