<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['media', 'category'])
            ->approved()
            ->when($request->q, fn ($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->when($request->category, fn ($q, $slug) => $q->whereHas(
                'category', fn ($c) => $c->where('slug', $slug)
            ))
            ->latest()
            ->paginate(12);

        return view('products.index', [
            'products' => $products,
            'categories' => DB::table('categories')->orderBy('name')->get(),
        ]);
    }

    public function show(Product $product)
    {
        // Hanya produk yang sudah disetujui admin yang boleh dilihat publik.
        abort_unless($product->approval_status === 'approved', 404);

        $product->load(['media', 'category', 'seller', 'reviews']);

        return view('products.show', ['product' => $product]);
    }
}