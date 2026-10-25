seluruh katalog produk, pencarian, kategori, filter.
@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="aw-container aw-section">
    <div class="aw-section__head">
        <h1 class="aw-section__title">Katalog produk</h1>
    </div>

    {{-- Pencarian --}}
    <form method="GET" action="{{ route('products.index') }}" class="aw-filter">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari barang..." class="aw-input">
        @if (request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        <button type="submit" class="aw-btn">Cari</button>
        @if (request()->filled('q') || request()->filled('category'))
            <a href="{{ route('products.index') }}" class="aw-btn aw-btn--ghost">Reset</a>
        @endif
    </form>

    {{-- Filter kategori --}}
    <div class="aw-cats">
        <a href="{{ route('products.index', array_filter(['q' => request('q')])) }}"
           class="aw-cat {{ request('category') ? '' : 'is-active' }}">Semua</a>
        @foreach (($categories ?? []) as $category)
            <a href="{{ route('products.index', array_filter(['category' => $category->slug, 'q' => request('q')])) }}"
               class="aw-cat {{ request('category') === $category->slug ? 'is-active' : '' }}">{{ $category->name }}</a>
        @endforeach
    </div>

    @php $total = method_exists($products, 'total') ? $products->total() : count($products); @endphp
    <p class="aw-result-info">
        {{ $total }} produk ditemukan
        @if (request('q')) untuk "<strong>{{ request('q') }}</strong>" @endif
    </p>

    @if ($total > 0)
        <div class="aw-grid">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    @else
        <div class="aw-empty">Produk tidak ditemukan. Coba kata kunci atau kategori lain.</div>
    @endif

    {{-- Navigasi halaman --}}
    @if (method_exists($products, 'hasPages') && $products->hasPages())
        @php $pager = $products->withQueryString(); @endphp
        <nav class="aw-pager" aria-label="Halaman katalog">
            @if ($pager->onFirstPage())
                <span class="aw-pager__item is-disabled">&laquo; Sebelumnya</span>
            @else
                <a class="aw-pager__item" href="{{ $pager->previousPageUrl() }}">&laquo; Sebelumnya</a>
            @endif

            <span class="aw-pager__info">Halaman {{ $pager->currentPage() }} dari {{ $pager->lastPage() }}</span>

            @if ($pager->hasMorePages())
                <a class="aw-pager__item" href="{{ $pager->nextPageUrl() }}">Berikutnya &raquo;</a>
            @else
                <span class="aw-pager__item is-disabled">Berikutnya &raquo;</span>
            @endif
        </nav>
    @endif
</div>
@endsection