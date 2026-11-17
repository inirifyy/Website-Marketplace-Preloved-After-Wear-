<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /** Katalog publik: /products?q=kemeja&category=atasan */
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

        return view('products.index', compact('products', 'categories'));
    }

    /** Detail produk: hanya yang sudah disetujui admin, selain itu 404. */
    public function show(Product $product): View
    {
        abort_unless($product->approval_status === 'approved', 404);

        $product->load(['category', 'media', 'seller', 'reviews.reviewer']);

        return view('products.show', compact('product'));
    }
}