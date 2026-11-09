<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * CRUD konten website: banner beranda, edukasi, statistik, dll.
 * Datanya dibaca halaman publik lewat HomeController (SiteContent::getSection).
 */
class SiteContentController extends Controller
{
    /** Bagian (section) konten yang dikenali website. */
    public const SECTIONS = [
        'hero_banner'  => 'Banner Beranda',
        'education'    => 'Edukasi',
        'stat'         => 'Statistik',
        'announcement' => 'Pengumuman',
        'about'        => 'Tentang Kami',
    ];

    public function index(Request $request): View
    {
        $contents = SiteContent::query()
            ->when($request->query('section'), fn ($q, $s) => $q->where('section', $s))
            ->when($request->query('q'), fn ($q, $term) => $q->where('title', 'like', "%{$term}%"))
            ->orderBy('section')
            ->orderBy('order')
            ->paginate(10)
            ->withQueryString();

        return view('admin.contents.index', [
            'contents' => $contents,
            'sections' => self::SECTIONS,
        ]);
    }

    public function create(): View
    {
        return view('admin.contents.create', ['sections' => self::SECTIONS]);
    }

    public function store(Request $request): RedirectResponse
    {
        SiteContent::create($this->validated($request));

        return redirect()->route('admin.contents.index')->with('success', 'Konten ditambahkan.');
    }

    public function edit(SiteContent $content): View
    {
        return view('admin.contents.edit', [
            'content'  => $content,
            'sections' => self::SECTIONS,
        ]);
    }

    public function update(Request $request, SiteContent $content): RedirectResponse
    {
        $content->update($this->validated($request, $content));

        return redirect()->route('admin.contents.index')->with('success', 'Konten diperbarui.');
    }

    public function destroy(SiteContent $content): RedirectResponse
    {
        $content->delete();

        return redirect()->route('admin.contents.index')->with('success', 'Konten dihapus.');
    }

    // ------------------------------------------------------------------

    private function validated(Request $request, ?SiteContent $content = null): array
    {
        $data = $request->validate([
            'section'     => ['required', Rule::in(array_keys(self::SECTIONS))],
            // "key" dipakai SiteContent::getByKey() dan seeder, jadi harus unik.
            'key'         => ['nullable', 'string', 'max:255', Rule::unique('site_contents', 'key')->ignore($content?->id)],
            'title'       => ['required', 'string', 'max:255'],
            'subtitle'    => ['nullable', 'string', 'max:255'],
            'content'     => ['nullable', 'string'],
            'image'       => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_url'  => ['nullable', 'string', 'max:255'],
            'order'       => ['nullable', 'integer', 'min:0'],
            'metadata'    => ['nullable', 'json'], // contoh: {"icon":"fa-leaf"}
        ], [
            'key.unique'    => 'Key sudah dipakai konten lain.',
            'metadata.json' => 'Metadata harus berupa JSON yang valid.',
        ]);

        // Checkbox yang tidak dicentang tidak ikut terkirim, jadi dibaca lewat has().
        $data['is_active'] = $request->boolean('is_active');
        $data['order']     = $data['order'] ?? 0;
        $data['metadata']  = filled($data['metadata'] ?? null)
            ? json_decode($data['metadata'], true)
            : null;

        return $data;
    }
}
