@extends('layouts.app')
@section('title', 'Katalog Preloved — After Wear')
@section('content')
@php
  // Chip "Filter Aktif": tiap filter yang terisi, lengkap dengan teks yang rapi.
  $filterKeys = ['category' => 'Kategori', 'condition' => 'Kondisi', 'location' => 'Lokasi', 'min' => 'Harga min', 'max' => 'Harga maks'];
  $activeChips = [];
  foreach ($filterKeys as $k => $label) {
      if (filled(request($k))) {
          $value = request($k);
          if ($k === 'category')  { $value = $categories->firstWhere('slug', $value)?->name ?? $value; }
          if ($k === 'condition') { $value = $conditions[$value] ?? $value; }
          if (in_array($k, ['min', 'max'])) { $value = 'Rp ' . number_format((int) $value, 0, ',', '.'); }
          $activeChips[] = ['key' => $k, 'text' => $label . ': ' . $value];
      }
  }

  $selectedCount = 0;
  foreach (['category', 'condition', 'location'] as $k) {
      if (filled(request($k))) { $selectedCount++; }
  }
  if (filled(request('min')) || filled(request('max'))) { $selectedCount++; }

  $sort = request('sort', 'terbaru');

  // Warna titik dan keterangan tiap kondisi (dicocokkan dari kata kunci pada label).
  $conditionInfo = function ($label) {
      $l = mb_strtolower($label);
      if (str_contains($l, 'seperti')) { return ['#1F9D61', 'Tanpa cacat, serat kain utuh, warna 98%+']; }
      if (str_contains($l, 'baik'))    { return ['#F59E0B', 'Tanda pemakaian minor wajar, kancing lengkap']; }
      if (str_contains($l, 'layak'))   { return ['#9A9A98', 'Faded alami bergaya retro autentik']; }
      return ['#9A9A98', null];
  };

  $current = $products->currentPage();
  $last = $products->lastPage();
@endphp

<div class="wrap kt-top">
  <nav class="kt-crumb" aria-label="Breadcrumb">
    <a href="{{ route('home') }}">Beranda</a><span>/</span>
    @if (request('q'))
      <a href="{{ route('products.index') }}">Katalog Preloved</a><span>/</span><b>Hasil Pencarian</b>
    @else
      <b>Katalog Preloved</b>
    @endif
  </nav>

  <h1 class="kt-title">
    @if (request('q')) Hasil untuk “{{ request('q') }}” @else Katalog Preloved @endif
    <small>({{ $products->total() }} kurasi ditemukan)</small>
  </h1>

  {{-- Bar filter aktif + urutan --}}
  <div class="kt-bar">
    <div class="kt-bar-left">
      @if (count($activeChips))
        <span class="kt-bar-label">Filter Aktif:</span>
        @foreach ($activeChips as $chip)
          <a class="kt-chip" href="{{ route('products.index', request()->except([$chip['key'], 'page'])) }}" title="Hapus filter ini">
            {{ $chip['text'] }}
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
          </a>
        @endforeach
        <a class="kt-clear" href="{{ route('products.index', array_filter(['q' => request('q')])) }}">Hapus semua</a>
      @else
        <span class="kt-bar-label">Belum ada filter aktif. Gunakan panel di samping untuk mempersempit pilihan.</span>
      @endif
    </div>

    <form class="kt-sort" method="GET" action="{{ route('products.index') }}">
      @foreach (request()->except(['sort', 'page']) as $k => $v)
        @if (is_scalar($v)) <input type="hidden" name="{{ $k }}" value="{{ $v }}"> @endif
      @endforeach
      <label for="sort">Urutkan:</label>
      <select id="sort" name="sort" onchange="this.form.submit()">
        <option value="terbaru" @selected($sort === 'terbaru')>Terbaru Ditambahkan</option>
        <option value="termurah" @selected($sort === 'termurah')>Harga Terendah</option>
        <option value="termahal" @selected($sort === 'termahal')>Harga Tertinggi</option>
      </select>
    </form>
  </div>

  <div class="kt-layout">
    {{-- Sidebar --}}
    <form class="kt-side" method="GET" action="{{ route('products.index') }}">
      <input type="hidden" name="q" value="{{ request('q') }}">
      @if (request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

      <div class="kt-side-head">
        <h2>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M7 12h10M10 18h4"/></svg>
          Filter Kurasi
        </h2>
        @if ($selectedCount > 0)<span class="kt-count">{{ $selectedCount }} dipilih</span>@endif
      </div>

      <div class="kt-group">
        <div class="kt-group-title"><b>Kategori Pakaian</b><span>Pilih salah satu</span></div>
        @foreach ($categories as $c)
          <label class="kt-opt">
            <span><input type="radio" name="category" value="{{ $c->slug }}" @checked(request('category') === $c->slug) onchange="this.form.submit()"> {{ $c->name }}</span>
            <em>{{ $counts[$c->slug] ?? 0 }}</em>
          </label>
        @endforeach
      </div>

      <div class="kt-group">
        <div class="kt-group-title"><b>Lokasi Pelapak (UMKM)</b></div>
        <div class="kt-field">
          <input type="text" name="location" value="{{ request('location') }}" placeholder="Makassar &amp; Sekitarnya">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
      </div>

      <div class="kt-group">
        <div class="kt-group-title"><b>Rentang Harga</b><span>IDR</span></div>
        <div class="kt-price">
          <label><span>MIN</span><input type="number" name="min" value="{{ request('min') }}" placeholder="50.000" min="0"></label>
          <label><span>MAKS</span><input type="number" name="max" value="{{ request('max') }}" placeholder="250.000" min="0"></label>
        </div>
        <button type="submit" class="btn dark block kt-apply">Terapkan Rentang
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 5 5L20 7"/></svg>
        </button>
      </div>

      <div class="kt-group">
        <div class="kt-group-title"><b>Kondisi Pakaian</b></div>
        @foreach ($conditions as $value => $label)
          @php $info = $conditionInfo($label); @endphp
          <label class="kt-cond">
            <input type="radio" name="condition" value="{{ $value }}" @checked((string) request('condition') === (string) $value) onchange="this.form.submit()">
            <span>
              <b><i style="background:{{ $info[0] }}"></i>{{ $label }}</b>
              @if ($info[1])<small>{{ $info[1] }}</small>@endif
            </span>
          </label>
        @endforeach
      </div>

      <div class="kt-impact">
        <b>
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
          Dampak Sirkularitas
        </b>
        <p>Membeli kemeja preloved menghemat sekitar 2.700 liter air dan mencegah limbah tekstil.</p>
      </div>
    </form>

    {{-- Daftar produk --}}
    <div>
      <div class="grid g3">
        @forelse ($products as $product)
          <x-product-card :product="$product" />
        @empty
          <p class="mute kt-empty">Tidak ada produk yang cocok. Coba ubah atau hapus filter.</p>
        @endforelse
      </div>

      @if ($last > 1)
        @php
          $pages = collect([1, $current - 1, $current, $current + 1, $last])
              ->filter(function ($p) use ($last) { return $p >= 1 && $p <= $last; })
              ->unique()->sort()->values();
          $prev = 0;
        @endphp
        <nav class="kt-pager" aria-label="Halaman katalog">
          @if ($products->onFirstPage())
            <span class="kt-pg-nav is-off">← Sebelumnya</span>
          @else
            <a class="kt-pg-nav" href="{{ $products->withQueryString()->previousPageUrl() }}">← Sebelumnya</a>
          @endif

          <div class="kt-pages">
            @foreach ($pages as $p)
              @if ($p - $prev > 1)<span class="kt-dots">…</span>@endif
              @if ($p === $current)
                <span class="kt-pg is-on">{{ $p }}</span>
              @else
                <a class="kt-pg" href="{{ $products->withQueryString()->url($p) }}">{{ $p }}</a>
              @endif
              @php $prev = $p; @endphp
            @endforeach
          </div>

          @if ($products->hasMorePages())
            <a class="kt-pg-nav" href="{{ $products->withQueryString()->nextPageUrl() }}">Berikutnya →</a>
          @else
            <span class="kt-pg-nav is-off">Berikutnya →</span>
          @endif
        </nav>
      @endif
    </div>
  </div>
</div>
@endsection
