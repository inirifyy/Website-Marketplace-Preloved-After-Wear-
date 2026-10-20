<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductSubmission;
use App\Support\MediaUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class ProductSubmissionController extends Controller
{
    /** Form pengajuan barang. */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('seller.submissions.create', compact('categories'));
    }

    /** Simpan pengajuan + foto/video. Status awal selalu "pending". */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id'      => ['required', 'exists:categories,id'],
            'name'             => ['required', 'string', 'max:200'],
            'description'      => ['required', 'string'],
            'price'            => ['required', 'numeric', 'min:1000', 'max:9999999999'],
            'item_condition'   => ['nullable', 'string', 'max:100'],
            'material'         => ['nullable', 'string', 'max:100'],
            'usage_duration'   => ['nullable', 'string', 'max:100'],
            'flaws'            => ['nullable', 'string'],
            'location'         => ['nullable', 'string', 'max:255'],
            'contact_whatsapp' => ['nullable', 'string', 'regex:/^(\+?62|0)[0-9]{8,13}$/'],
            'photos'           => ['required', 'array', 'min:1', 'max:5'],
            'photos.*'         => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // 2 MB per foto
            'video'            => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/quicktime', 'max:20480'], // 20 MB
        ], [
            'photos.required'         => 'Unggah minimal 1 foto.',
            'contact_whatsapp.regex'  => 'Nomor WhatsApp tidak valid (contoh: 081234567890).',
        ]);

        $stored = [];

        try {
            DB::transaction(function () use ($request, $data, &$stored) {
                $submission = ProductSubmission::create(
                    Arr::except($data, ['photos', 'video']) + [
                        'seller_id'         => $request->user()->id,
                        'submission_status' => 'pending',
                    ]
                );

                $stored = MediaUploader::store(
                    $request->file('photos', []),
                    $request->file('video'),
                    'submissions/' . $submission->id
                );

                $submission->media()->createMany($stored);
            });
        } catch (Throwable $e) {
            // Database gagal -> jangan tinggalkan file yatim di storage.
            MediaUploader::deleteUnused(array_column($stored, 'file_path'));
            throw $e;
        }

        return redirect()
            ->route('seller.dashboard')
            ->with('success', 'Barang berhasil diajukan. Mohon tunggu verifikasi admin.');
    }
}
