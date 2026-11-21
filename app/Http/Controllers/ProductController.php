<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Katalog publik (tanpa login): daftar produk + detail produk.
 * Hanya produk dengan approval_status = approved yang boleh tampil.
 */
class ProductController extends Controller
{
    /** Pilihan kondisi di filter katalog (dicocokkan dengan kolom item_condition). */
    public const CONDITIONS = [
        'Seperti baru' => 'Seperti Baru',
        'Baik'         => 'Baik',
        'Layak pakai'  => 'Layak Pakai',
    ];

    /** Katalog: /products?q=kemeja&category=atasan&condition=Baik&min=50000&max=250000 */
    public function index(Request $request): View
    {
        $term      = trim((string) $request->query('q', ''));
        $category  = trim((string) $request->query('category', ''));
        $condition = trim((string) $request->query('condition', ''));
        $location  = trim((string) $request->query('location', ''));
        $min       = $request->query('min');
        $max       = $request->query('max');

        $like = fn (string $value) => '%' . addcslashes($value, '%_\\') . '%';

        $products = Product::with(['category', 'media'])
            ->approved()
            ->when($term !== '', fn ($q) => $q->where('name', 'like', $like($term)))
            // Filter kategori memakai slug (?category=atasan). Nama kategori lama (?category=Atasan) tetap diterima.
            ->when($category !== '', fn ($q) => $q->whereHas('category', fn ($c) =>
                $c->where('slug', $category)->orWhere('name', $category)))
            ->when($condition !== '', fn ($q) => $q->where('item_condition', 'like', $like($condition)))
            ->when($location !== '', fn ($q) => $q->where('location', 'like', $like($location)))
            ->when(is_numeric($min), fn ($q) => $q->where('price', '>=', (float) $min))
            ->when(is_numeric($max), fn ($q) => $q->where('price', '<=', (float) $max))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        // Kategori aktif + jumlah produk yang sudah disetujui di tiap kategori ($counts dipakai view).
        $categories = Category::active()
            ->ordered()
            ->withCount(['products as approved_products_count' => fn ($q) => $q->approved()])
            ->get();

        $counts = $categories->pluck('approved_products_count', 'slug');

        $conditions = self::CONDITIONS;

        return view('products.index', compact('products', 'categories', 'counts', 'conditions'));
    }

    /** Detail produk. Produk yang belum disetujui admin dianggap tidak ada (404). */
    public function show(Request $request, Product $product): View
    {
        // Hanya produk yang sudah disetujui admin yang boleh dilihat publik.
        abort_unless($product->approval_status === 'approved', 404);

        $product->load(['category', 'media', 'seller', 'reviews.reviewer']);

        // Ringkasan rating dihitung dari ulasan nyata.
        $reviews       = $product->reviews->sortByDesc('created_at')->values();
        $reviewCount   = $reviews->count();
        $averageRating = $reviewCount ? round($reviews->avg('rating'), 1) : 0;

        $distribution = [];
        foreach ([5, 4, 3, 2, 1] as $star) {
            $distribution[$star] = $reviewCount
                ? (int) round($reviews->where('rating', $star)->count() / $reviewCount * 100)
                : 0;
        }

        // Boleh menulis ulasan: pembeli yang nomornya terverifikasi dan belum pernah mengulas produk ini.
        $user     = $request->user();
        $myReview = $user ? $reviews->firstWhere('reviewer_id', $user->id) : null;
        $canReview = $user && $user->isBuyer() && $user->hasVerifiedPhone() && ! $myReview;

        // Produk lain di kategori yang sama.
        $related = Product::with(['category', 'media'])
            ->approved()
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->getKey())
            ->latest()
            ->take(4)
            ->get();

        return view('products.show', compact(
            'product', 'reviews', 'reviewCount', 'averageRating', 'distribution', 'canReview', 'myReview', 'related'
        ));
    }
}
