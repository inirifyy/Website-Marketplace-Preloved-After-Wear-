@extends('layouts.app')

@section('title', 'Testimoni Pembeli & Dampak Thrifting')

@section('content')
<div class="aw-container" style="padding-block: 2.5rem 4rem;">
    <header style="text-align: center; max-width: 700px; margin: 0 auto 2.5rem;">
        <span style="display: inline-block; padding: .3rem .8rem; background: rgba(125, 146, 120, .2); color: #30332F; border-radius: 999px; font-size: .85rem; font-weight: 600; margin-bottom: .75rem;">
            Cerita & Pengalaman
        </span>
        <h1 style="font-size: 2.2rem; margin: 0 0 .75rem; color: var(--aw-charcoal);">Apa Kata Mereka tentang After Wear?</h1>
        <p style="color: rgba(48, 51, 47, .8); font-size: 1.05rem; line-height: 1.6;">
            Pengalaman nyata dari pembeli dan penjual preloved yang turut mendukung gerakan circular fashion dan pengurangan limbah tekstil di Indonesia.
        </p>
    </header>

    @if (isset($reviews) && $reviews->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
            @foreach ($reviews as $review)
                <div style="background: var(--aw-white); border: 1px solid rgba(48, 51, 47, .12); border-radius: .75rem; padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: .75rem;">
                            <div style="display: flex; gap: .25rem; color: #f59e0b; font-size: 1.1rem;">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= ($review->rating ?? 5) ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                            <span style="font-size: .8rem; color: rgba(48, 51, 47, .6);">
                                {{ $review->created_at ? $review->created_at->diffForHumans() : 'Baru saja' }}
                            </span>
                        </div>
                        <p style="margin: 0 0 1rem; font-style: italic; color: var(--aw-charcoal); line-height: 1.5;">
                            "{{ $review->comment ?? 'Barang sesuai deskripsi dan kondisinya masih sangat bagus. Pengiriman cepat dan ramah lingkungan!' }}"
                        </p>
                    </div>
                    <div style="border-top: 1px solid rgba(48, 51, 47, .08); padding-top: .75rem; display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-weight: 600; font-size: .92rem;">
                            {{ $review->user->name ?? 'Pengguna After Wear' }}
                        </span>
                        @if ($review->product)
                            <a href="{{ route('products.show', $review->product) }}" style="font-size: .8rem; color: #566B52; text-decoration: underline;">
                                {{ \Illuminate\Support\Str::limit($review->product->title ?? $review->product->name, 20) }}
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="background: var(--aw-white); border: 1px dashed rgba(48, 51, 47, .2); border-radius: .75rem; padding: 3rem 1.5rem; text-align: center; max-width: 600px; margin: 0 auto;">
            <p style="font-size: 1.1rem; margin: 0 0 1rem; color: rgba(48, 51, 47, .8);">
                Belum ada ulasan publik yang diposting. Jadilah orang pertama yang berbelanja dan membagikan testimoni pengalaman belanja preloved di After Wear!
            </p>
            <a href="{{ route('products.index') }}" class="aw-btn aw-btn--primary">Jelajahi Katalog Pakaian</a>
        </div>
    @endif

    {{-- Banner CTA --}}
    <section style="margin-top: 3.5rem; background: #30332F; color: #FFFFFF; border-radius: 1rem; padding: 2.5rem; text-align: center;">
        <h2 style="font-size: 1.75rem; margin: 0 0 .75rem; color: #FFFFFF;">Punya Pakaian Menumpuk di Lemari?</h2>
        <p style="max-width: 600px; margin: 0 auto 1.5rem; color: rgba(255, 255, 255, .8); line-height: 1.6;">
            Jangan biarkan jadi limbah tekstil. Daftarkan dirimu sebagai penjual dan beri pakaian layak pakaimu kesempatan hidup kedua.
        </p>
        <a href="{{ route('register') }}" style="display: inline-block; padding: .75rem 1.75rem; background: #7D9278; color: #FFFFFF; border-radius: .5rem; font-weight: 600; text-decoration: none;">
            Mulai Jual Sekarang
        </a>
    </section>
</div>
@endsection
