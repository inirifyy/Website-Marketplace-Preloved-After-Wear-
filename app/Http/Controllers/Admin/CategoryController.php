<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

/** CRUD kategori (tanpa show). */
class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
        ]);

        $slug = Str::slug($data['name']);

        if (Category::where('slug', $slug)->exists()) {
            return back()->withInput()->withErrors(['name' => 'Nama ini menghasilkan slug yang sudah dipakai kategori lain.']);
        }

        Category::create($data + ['slug' => $slug]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori ditambahkan.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:categories,name,' . $category->id],
            'description' => ['nullable', 'string'],
        ]);

        $slug = Str::slug($data['name']);

        $slugTaken = Category::where('slug', $slug)->where('id', '!=', $category->id)->exists();
        if ($slugTaken) {
            return back()->withInput()->withErrors(['name' => 'Nama ini menghasilkan slug yang sudah dipakai kategori lain.']);
        }

        $category->update($data + ['slug' => $slug]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists() || $category->submissions()->exists()) {
            return back()->with('error', 'Kategori masih dipakai produk/pengajuan, tidak bisa dihapus.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori dihapus.');
    }
}
