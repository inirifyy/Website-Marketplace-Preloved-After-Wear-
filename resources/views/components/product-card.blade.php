@props(['product'])

<a href="{{ route('products.show', $product) }}" class="aw-card">
    <div class="aw-card__img">
        <img src="{{ $product->cover_url }}" alt="{{ $product->name }}" loading="lazy"
             onerror="this.remove()">
        @if ($product->status === 'sold_out')
            <span class="aw-card__badge aw-card__badge--sold">Habis</span>
        @elseif ($product->item_condition)
            <span class="aw-card__badge">{{ $product->item_condition }}</span>
        @endif
    </div>
    <div class="aw-card__body">
        <div class="aw-card__cat">{{ $product->category->name ?? 'Preloved' }}</div>
        <div class="aw-card__name">{{ $product->name }}</div>
        <div class="aw-card__price">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</div>
    </div>
</a>