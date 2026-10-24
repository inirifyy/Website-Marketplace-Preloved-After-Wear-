<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Simpan ulasan pembeli untuk satu produk.
     * Route: POST /products/{product}/reviews  (name: products.reviews.store)
     */
    public function store(Request $request, Product $product): RedirectResponse
    {
        $user = $request->user();

        // 1. Hanya pembeli yang boleh menulis ulasan.
        //    (Pengaman tambahan; nanti juga dijaga middleware role:buyer.)
        abort_unless($user->isBuyer(), 403, 'Hanya pembeli yang dapat menulis ulasan.');

        // 2. Hanya produk yang sudah disetujui admin yang bisa diulas.
        abort_unless($product->approval_status === 'approved', 404);

        // 3. Validasi input. reviewer_id dan product_id TIDAK diambil dari form.
        $data = $request->validate([
            'rating'  => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ], [
            'rating.required' => 'Pilih rating 1 sampai 5.',
            'rating.integer'  => 'Rating harus berupa angka.',
            'rating.between'  => 'Rating harus antara 1 sampai 5.',
            'comment.max'     => 'Ulasan maksimal 1000 karakter.',
        ]);

        $backToProduct = route('products.show', $product) . '#ulasan';

        // 4. Satu pembeli = satu ulasan per produk.
        if ($product->reviews()->where('reviewer_id', $user->id)->exists()) {
            return redirect($backToProduct)->with('error', 'Anda sudah mengulas produk ini.');
        }

        try {
            $product->reviews()->create([
                'reviewer_id' => $user->id,
                'rating'      => $data['rating'],
                'comment'     => $data['comment'] ?? null,
            ]);
        } catch (UniqueConstraintViolationException) {
            // Terjadi kalau dua permintaan masuk bersamaan; unique index di database menahannya.
            return redirect($backToProduct)->with('error', 'Anda sudah mengulas produk ini.');
        }

        return redirect($backToProduct)->with('success', 'Terima kasih, ulasan Anda sudah tersimpan.');
    }
}