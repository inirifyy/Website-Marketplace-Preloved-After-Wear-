<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MyProductController extends Controller
{
    /** Daftar produk milik penjual yang login. */
    public function index(Request $request): View
    {
        $products = Product::with(['category', 'media'])
            ->where('seller_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    /** Ubah status ready <-> sold_out. */
    public function updateStatus(Request $request, Product $product): RedirectResponse
    {
        // Penjual hanya boleh mengubah produk miliknya sendiri.
        abort_unless($product->seller_id === $request->user()->id, 403);

        $data = $request->validate([
            'status' => ['required', Rule::in(['ready', 'sold_out'])],
        ]);

        $product->update($data);

        return back()->with('success', 'Status produk diperbarui.');
    }
}
