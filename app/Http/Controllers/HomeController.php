<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama (homepage) After Wear.
     */
    public function index()
    {
        // 1. Ambil kategori aktif untuk navigasi & katalog
        $categories = Category::active()->ordered()->get();

        // 2. Ambil konten situs: Banner hero & materi edukasi
        $heroBanner = SiteContent::active()->where('section', 'hero_banner')->first();
        $educationContents = SiteContent::getSection('education');
        $stats = SiteContent::getSection('stat');

        // 3. Ambil produk preloved terbaru & featured secara aman
        $featuredProducts = collect();
        if (Schema::hasTable('products')) {
            $featuredProducts = Product::with(['category'])
                ->latest()
                ->take(8)
                ->get();
        }

        return view('home', compact(
            'categories',
            'heroBanner',
            'educationContents',
            'stats',
            'featuredProducts'
        ));
    }

    /**
     * Tampilkan halaman edukasi thrifting & circular fashion.
     */
    public function education()
    {
        $educationContents = SiteContent::getSection('education');
        $stats = SiteContent::getSection('stat');
        return view('pages.testimonials', compact('educationContents', 'stats'));
    }

    /**
     * Tampilkan halaman testimoni pembeli & komunitas.
     */
    public function testimonials()
    {
        $testimonials = [
            [
                'name' => 'Adinda Putri',
                'role' => 'Pembeli Terverifikasi',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&auto=format&fit=crop&q=80',
                'item' => 'Vintage Corduroy Jacket & Zara Mom Jeans',
                'rating' => 5,
                'comment' => 'Kondisi barangnya bener-bener seperti baru! Wangi dan siap pakai. Senang banget bisa dapet outfit vintage idaman dengan harga seperempat dari harga toko!',
                'date' => '3 hari yang lalu',
            ],
            [
                'name' => 'Dimas Pratama',
                'role' => 'Pembeli Terverifikasi',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
                'item' => 'Uniqlo Oversized Flannel & Chino Pants',
                'rating' => 5,
                'comment' => 'Awalnya ragu beli preloved online, tapi After Wear punya deskripsi detail dan foto asli tanpa editan berlebihan. Sangat puas dan pasti repeat order!',
                'date' => '1 minggu yang lalu',
            ],
            [
                'name' => 'Siti Rahmawati',
                'role' => 'Seller & Thrifter',
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&auto=format&fit=crop&q=80',
                'item' => 'Floral Midi Dress Korea',
                'rating' => 5,
                'comment' => 'Menyenangkan bisa declutter lemari pakaian dan menghasilkan uang, sekaligus tau kalau baju kesayangan kita dipakai lagi oleh orang yang menghargainya.',
                'date' => '2 minggu yang lalu',
            ],
        ];

        $educationContents = SiteContent::getSection('education');
        $stats = SiteContent::getSection('stat');

        return view('pages.testimonials', compact('testimonials', 'educationContents', 'stats'));
    }

    /**
     * Tampilkan halaman tentang kami (About Us).
     */
    public function about()
    {
        return view('pages.about');
    }
}