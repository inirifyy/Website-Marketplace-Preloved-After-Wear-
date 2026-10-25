@extends('layouts.app')

@section('title', $product->name)

@section('content')
@php
    $items = $product->media->map(fn ($m) => [
        'type' => $m->media_type,
        'src'  => \Illuminate\Support\Facades\Storage::url($m->file_path),
    ])->values();
    if ($items->isEmpty()) {
        $items = collect([['type' => 'image', 'src' => $product->cover_url]]);
    }
    $first = $items->first();

    $reviews = $product->reviews;
    $reviewCount = $reviews->count();
    $avg = $reviewCount ? round($reviews->avg('rating'), 1) : null;
    $stars = $avg ? str_repeat('★', (int) round($avg)) . str_repeat('☆', 5 - (int) round($avg)) : null;

    // Nomor WhatsApp penjual: 08xx -> 628xx
    $phone = preg_replace('/\D+/', '', (string) ($product->seller->phone ?? ''));
    if ($phone !== '' && str_starts_with($phone, '0')) {
        $phone = '62' . substr($phone, 1);
    }
    $waText = "Halo, saya tertarik dengan \"{$product->name}\" di After Wear. Apakah masih tersedia?";
    $waUrl = $phone ? 'https://wa.me/' . $phone . '?text=' . rawurlencode($waText) : null;
@endphp

<div class="aw-container aw-section">
    <nav class="aw-crumb">
        <a href="{{ route('home') }}">Beranda</a> /
        <a href="{{ route('products.index') }}">Katalog</a> /
        {{ $product->name }}
    </nav>

    <div class="aw-detail">
        {{-- Galeri --}}
        <div data-gallery>
            <div class="aw-gallery__main" data-gallery-main>
                @if ($first['type'] === 'video')
                    <video src="{{ $first['src'] }}" controls></video>
                @else
                    <img src="{{ $first['src'] }}" alt="{{ $product->name }}" onerror="this.remove()">
                @endif
            </div>

            @if ($items->count() > 1)
                <div class="aw-gallery__thumbs">
                    @foreach ($items as $item)
                        <button type="button" class="aw-thumb {{ $loop->first ? 'is-active' : '' }}"
                                data-type="{{ $item['type'] }}" data-src="{{ $item['src'] }}"
                                data-alt="{{ $product->name }}" aria-label="Lihat media {{ $loop->iteration }}">
                            @if ($item['type'] === 'video')
                                <span class="aw-thumb__video">&#9654;</span>
                            @else
                                <img src="{{ $item['src'] }}" alt="">
                            @endif
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Informasi --}}
        <div>
            <div class="aw-detail__cat">{{ $product->category->name ?? 'Preloved' }}</div>
            <h1 class="aw-detail__name">{{ $product->name }}</h1>
            <div class="aw-detail__price">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</div>

            <div class="aw-rating">
                @if ($avg)
                    {{ $stars }} <small>{{ $avg }} dari 5 ({{ $reviewCount }} ulasan)</small>
                @else
                    <small>Belum ada ulasan</small>
                @endif
            </div>

            <dl class="aw-specs">
                <dt>Kondisi</dt><dd>{{ $product->item_condition ?: '-' }}</dd>
                <dt>Bahan</dt><dd>{{ $product->material ?: '-' }}</dd>
                <dt>Lama pemakaian</dt><dd>{{ $product->usage_duration ?: '-' }}</dd>
                <dt>Kekurangan</dt><dd>{{ $product->flaws ?: 'Tidak ada yang dicatat' }}</dd>
                <dt>Lokasi</dt><dd>{{ $product->location ?: '-' }}</dd>
                <dt>Status</dt><dd>{{ $product->status === 'sold_out' ? 'Habis' : 'Tersedia' }}</dd>
            </dl>

            <p class="aw-desc">{{ $product->description }}</p>

            @if ($product->status === 'sold_out')
                <span class="aw-sold">Stok habis</span>
            @elseif ($waUrl)
                <a href="{{ $waUrl }}" class="aw-btn aw-btn--wa" target="_blank" rel="noopener noreferrer">
                    Hubungi penjual via WhatsApp
                </a>
            @else
                <span class="aw-sold">Kontak penjual belum tersedia</span>
            @endif

            @if ($product->seller)
                <div class="aw-seller">Dijual oleh {{ $product->seller->name }}</div>
            @endif
        </div>
    </div>

    {{-- Ulasan --}}
    <section class="aw-reviews">
        <h2 class="aw-section__title">Ulasan pembeli</h2>

        @forelse ($reviews as $review)
            <article class="aw-review">
                <div class="aw-review__head">
                    <span class="aw-review__who">
                        {{ $review->reviewer->name ?? 'Pembeli' }}
                        <span class="aw-rating">{{ str_repeat('★', (int) $review->rating) }}{{ str_repeat('☆', 5 - (int) $review->rating) }}</span>
                    </span>
                    <span class="aw-review__date">{{ optional($review->created_at)->format('d M Y') }}</span>
                </div>
                @if ($review->comment)
                    <p class="aw-review__text">{{ $review->comment }}</p>
                @endif
            </article>
        @empty
            <div class="aw-empty">Belum ada ulasan untuk produk ini.</div>
        @endforelse

        @auth
            <form method="POST" action="{{ route('products.reviews.store', $product) }}" class="aw-review-form">
                @csrf
                <h3>Tulis ulasan</h3>
                <div class="aw-rate">
                    @for ($i = 5; $i >= 1; $i--)
                        <input type="radio" id="rate{{ $i }}" name="rating" value="{{ $i }}"
                               {{ (int) old('rating') === $i ? 'checked' : '' }} required>
                        <label for="rate{{ $i }}" title="{{ $i }} bintang">&#9733;</label>
                    @endfor
                </div>
                <textarea name="comment" class="aw-textarea" placeholder="Ceritakan pengalamanmu (opsional)">{{ old('comment') }}</textarea>
                <button type="submit" class="aw-btn">Kirim ulasan</button>
            </form>
        @else
            <p class="aw-result-info"><a href="{{ route('login') }}" class="aw-link">Masuk</a> untuk menulis ulasan.</p>
        @endauth
    </section>
</div>
@endsection