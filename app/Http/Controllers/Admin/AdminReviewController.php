<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminReviewController extends Controller
{
    /** Daftar semua ulasan, bisa dicari dan difilter rating. */
    public function index(Request $request): View
    {
        $this->ensureAdmin($request);

        $q = trim((string) $request->query('q', ''));
        $rating = $request->integer('rating'); // 0 jika tidak diisi / bukan angka

        $reviews = Review::with(['product:id,name,slug', 'reviewer:id,name,email'])
            ->when($rating >= 1 && $rating <= 5, fn ($query) => $query->where('rating', $rating))
            ->when($q !== '', function ($query) use ($q) {
                $like = '%' . addcslashes($q, '%_\\') . '%';

                $query->where(function ($inner) use ($like) {
                    $inner->where('comment', 'like', $like)
                        ->orWhereHas('reviewer', fn ($r) => $r->where('name', 'like', $like))
                        ->orWhereHas('product', fn ($p) => $p->where('name', 'like', $like));
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews', 'q', 'rating'));
    }

    /** Hapus ulasan yang melanggar aturan (moderasi). */
    public function destroy(Request $request, Review $review): RedirectResponse
    {
        $this->ensureAdmin($request);

        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }

    /*
     * Pengaman sementara: selama route admin baru memakai middleware 'auth',
     * pembeli yang login masih bisa menembus URL admin. Pengecekan ini menutup
     * celah itu khusus untuk moderasi ulasan. Setelah middleware 'role:admin'
     * aktif di routes/web.php, method ini boleh dihapus.
     */
    private function ensureAdmin(Request $request): void
    {
        abort_unless($request->user()?->isAdmin(), 403);
    }
}