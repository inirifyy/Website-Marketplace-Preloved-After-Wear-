<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Support\MediaUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * CRUD produk oleh admin (tanpa show; detail produk ada di sisi publik).
 * Verifikasi pengajuan seller ada di ProductSubmissionController.
 */
class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with(['seller', 'category', 'media'])
            ->when($request->query('approval_status'), fn ($q, $s) => $q->where('approval_status', $s))
            ->when($request->query('q'), fn ($q, $term) => $q->where('name', 'like', "%{$term}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules(photosRequired: true));

        DB::transaction(function () use ($request, $data) {
            $product = Product::create(
                Arr::except($data, ['photos', 'video']) + [
                    'slug'      => Product::makeUniqueSlug($data['name']),
                    'seller_id' => $request->user()->id, // produk dibuat langsung oleh admin
                ]
            );

            $this->attachMedia($request, $product);
        });

        return redirect()->route('admin.products.index')->with('success', 'Produk ditambahkan.');
    }

    public function edit(Product $product): View
    {
        $product->load('media');
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate($this->rules(photosRequired: false));

        DB::transaction(function () use ($request, $data, $product) {
            // Slug sengaja tidak diubah supaya link produk lama tetap berlaku.
            $product->update(Arr::except($data, ['photos', 'video']));

            $this->attachMedia($request, $product);
        });

        return redirect()->route('admin.products.index')->with('success', 'Produk diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $paths = $product->media()->pluck('file_path')->all();

        $product->delete(); // baris product_media ikut terhapus (ON DELETE CASCADE)

        MediaUploader::deleteUnused($paths);

        return redirect()->route('admin.products.index')->with('success', 'Produk dihapus.');
    }

    // ------------------------------------------------------------------

    private function rules(bool $photosRequired): array
    {
        return [
            'category_id'     => ['required', 'exists:categories,id'],
            'name'            => ['required', 'string', 'max:200'],
            'description'     => ['required', 'string'],
            'price'           => ['required', 'numeric', 'min:0', 'max:9999999999'],
            'item_condition'  => ['nullable', 'string', 'max:100'],
            'material'        => ['nullable', 'string', 'max:100'],
            'usage_duration'  => ['nullable', 'string', 'max:100'],
            'flaws'           => ['nullable', 'string'],
            'location'        => ['nullable', 'string', 'max:255'],
            'status'          => ['required', Rule::in(['ready', 'sold_out'])],
            'approval_status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
            'photos'          => [$photosRequired ? 'required' : 'nullable', 'array', 'max:5'],
            'photos.*'        => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'video'           => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/quicktime', 'max:20480'],
        ];
    }

    private function attachMedia(Request $request, Product $product): void
    {
        $stored = MediaUploader::store(
            $request->file('photos', []),
            $request->file('video'),
            'products/' . $product->id
        );

        if ($stored) {
            $product->media()->createMany($stored);
        }
    }
}
