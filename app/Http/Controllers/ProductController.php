<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Katalog publik (tanpa login): daftar produk + detail produk.
 * Hanya produk dengan approval_status = approved yang boleh tampil.
 */
class ProductController extends Controller
{
    /** Katalog: /products?q=kemeja&category=atasan */
    public function index(Request $request): View
    {
        $products = Product::with(['category', 'media'])
            ->approved()
            ->when($request->query('q'), fn ($q, $term) => $q->where('name', 'like', "%{$term}%"))
            ->when($request->query('category'), fn ($q, $slug) =>
                $q->whereHas('category', fn ($c) => $c->where('slug', $slug)))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::active()->ordered()->get();

        // Versi lama (query builder langsung), dinonaktifkan:
        // $categories = DB::table('categories')->orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    /** Detail produk. Produk yang belum disetujui admin dianggap tidak ada (404). */
    public function show(Product $product): View
    {
        // Hanya produk yang sudah disetujui admin yang boleh dilihat publik.
        abort_unless($product->approval_status === 'approved', 404);

        $product->load(['category', 'media', 'seller', 'reviews.reviewer']);

        return view('products.show', compact('product'));
    }
}