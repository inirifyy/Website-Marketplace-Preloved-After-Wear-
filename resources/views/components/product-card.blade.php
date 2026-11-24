@props(['product'])
@php
    $sold = $product->status === 'sold_out';
    $cond = $product->item_condition;
    $ratingAvg = $product->reviews->avg('rating');
    $ratingCount = $product->reviews->count();
@endphp

<a href="{{ route('products.show', $product) }}" class="pc">
    <div class="pc-img {{ $sold ? 'is-sold' : '' }}">
        <img src="{{ $product->cover_url }}" alt="{{ $product->name }}" loading="lazy" onerror="this.remove()">
        @if ($sold)
            <span class="pc-sold">Telah Terjual</span>
        @elseif ($cond)
            <span class="pc-badge {{ \Illuminate\Support\Str::slug($cond) === 'seperti-baru' ? 'is-new' : '' }}">{{ $cond }}</span>
        @endif
    </div>
    <div class="pc-body">
        <div class="pc-meta">
            <span>{{ $product->category->name ?? 'Preloved' }}</span>
            @if ($ratingCount)
                <span>★ {{ number_format($ratingAvg, 1) }} ({{ $ratingCount }})</span>
            @endif
        </div>
        <div class="pc-name">{{ $product->name }}</div>
        <div class="pc-price {{ $sold ? 'is-sold' : '' }}">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</div>
        @if ($product->location)
            <div class="pc-loc">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                {{ $product->location }}
            </div>
        @endif
    </div>
</a>