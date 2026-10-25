@extends('layouts.app')

@section('title', 'After Wear')

@section('content')
<div class="aw-container aw-section">

    {{-- Banner bergantian --}}
    <section class="aw-hero" data-hero>
        @forelse (($slides ?? []) as $slide)
            <article class="aw-hero__slide {{ $loop->first ? 'is-active' : '' }}"
                @if ($slide->image_path ?? null)
                    style="background-image:url('{{ \Illuminate\Support\Facades\Storage::url($slide->image_path) }}')"
                @endif>
                <div class="aw-hero__text">
                    <h2>{{ $slide->title }}</h2>
                    @if ($slide->body ?? null)<p>{{ \Illuminate\Support\Str::limit($slide->body, 120) }}</p>@endif
                    <a href="{{ route('products.index') }}" class="aw-btn">Lihat katalog</a>
                </div>
            </article>
        @empty
            <article class="aw-hero__slide is-active">
                <div class="aw-hero__text"> 
                    <h2>Pakaian preloved layak pakai, cerita baru untuk gayamu</h2>
                    <p>Temukan atasan, bawahan, dress, dan aksesori pilihan dengan harga bersahabat.</p>
                    <a href="{{ route('products.index') }}" class="aw-btn">Lihat katalog</a>
                </div>
            </article>
        @endforelse
        <div class="aw-hero__dots"></div>
    </section>

    {{-- Kategori --}}
    <section class="aw-section">
        <div class="aw-section__head"><h2 class="aw-section__title">Kategori</h2></div>
        <div class="aw-cats">
            <a href="{{ route('products.index') }}" class="aw-cat">Semua</a>
            @foreach (($categories ?? []) as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="aw-cat">{{ $category->name }}</a>
            @endforeach
        </div>
    </section>

    {{-- Produk terbaru --}}
    <section class="aw-section">
        <div class="aw-section__head">
            <h2 class="aw-section__title">Produk terbaru</h2>
            <a href="{{ route('products.index') }}" class="aw-link">Lihat semua</a>
        </div>
        @if (count($products ?? []))
            <div class="aw-grid">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @else
            <div class="aw-empty">Belum ada produk yang tampil. Segera hadir!</div>
        @endif
    </section>

</div>
@endsection