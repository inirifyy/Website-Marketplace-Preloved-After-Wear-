<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Verifikasi pengajuan barang dari seller:
 * pending -> approved (dibuatkan produk di katalog) atau rejected (+ catatan).
 */
class ProductSubmissionController extends Controller
{
    private const STATUSES = ['pending', 'approved', 'rejected'];

    public function index(Request $request): View
    {
        $status = $request->query('status', 'pending');
        if (! in_array($status, self::STATUSES, true)) {
            $status = 'pending';
        }

        $submissions = ProductSubmission::with(['seller', 'category', 'media'])
            ->where('submission_status', $status)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.submissions.index', compact('submissions', 'status'));
    }

    public function approve(ProductSubmission $submission): RedirectResponse
    {
        DB::transaction(function () use ($submission) {
            // Kunci baris supaya dua admin tidak menyetujui pengajuan yang sama bersamaan.
            $submission = ProductSubmission::with('media')
                ->whereKey($submission->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless($submission->submission_status === 'pending', 409, 'Pengajuan ini sudah diproses.');

            $product = Product::create([
                'seller_id'       => $submission->seller_id,
                'category_id'     => $submission->category_id,
                'name'            => $submission->name,
                'slug'            => Product::makeUniqueSlug($submission->name),
                'description'     => $submission->description,
                'price'           => $submission->price,
                'item_condition'  => $submission->item_condition,
                'material'        => $submission->material,
                'usage_duration'  => $submission->usage_duration,
                'flaws'           => $submission->flaws,
                'location'        => $submission->location,
                'status'          => 'ready',
                'approval_status' => 'approved',
            ]);

            // Salin referensi foto/video ke produk (file fisik tidak digandakan).
            foreach ($submission->media as $media) {
                $product->media()->create([
                    'media_type' => $media->media_type,
                    'file_path'  => $media->file_path,
                ]);
            }

            $submission->update([
                'submission_status' => 'approved',
                'admin_note'        => null,
            ]);
        });

        return back()->with('success', 'Pengajuan disetujui dan produk sudah tayang di katalog.');
    }

    public function reject(Request $request, ProductSubmission $submission): RedirectResponse
    {
        abort_unless($submission->submission_status === 'pending', 409, 'Pengajuan ini sudah diproses.');

        $data = $request->validate([
            'admin_note' => ['required', 'string', 'max:1000'],
        ], [
            'admin_note.required' => 'Tulis alasan penolakan agar seller tahu apa yang perlu diperbaiki.',
        ]);

        $submission->update([
            'submission_status' => 'rejected',
            'admin_note'        => $data['admin_note'],
        ]);

        return back()->with('success', 'Pengajuan ditolak.');
    }
}
