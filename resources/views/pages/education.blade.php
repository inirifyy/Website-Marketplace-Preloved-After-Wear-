@extends('layouts.app')

@section('title', 'Edukasi Limbah Tekstil & Circular Fashion')

@section('content')
<div class="aw-container" style="padding-block: 2.5rem 4rem;">
    {{-- Header Edukasi --}}
    <header style="text-align: center; max-width: 750px; margin: 0 auto 3rem;">
        <span style="display: inline-block; padding: .3rem .85rem; background: rgba(125, 146, 120, .2); color: #30332F; border-radius: 999px; font-size: .85rem; font-weight: 600; margin-bottom: .75rem;">
            Circular Fashion & Edukasi Lingkungan
        </span>
        <h1 style="font-size: 2.25rem; margin: 0 0 .85rem; color: var(--aw-charcoal); line-height: 1.25;">
            Mengapa Thrifting & Preloved Penting untuk Bumi Kita?
        </h1>
        <p style="color: rgba(48, 51, 47, .8); font-size: 1.05rem; line-height: 1.6;">
            Industri fashion cepat (fast fashion) menjadi salah satu penghasil limbah dan emisi karbon terbesar di dunia. Dengan membeli dan memakai kembali pakaian preloved, kita memperpanjang siklus hidup busana dan mengurangi jejak karbon.
        </p>
    </header>

    {{-- Statistik Dampak Lingkungan --}}
    @if (isset($stats) && $stats->count() > 0)
        <section style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; margin-bottom: 3.5rem;">
            @foreach ($stats as $stat)
                <div style="background: var(--aw-white); border: 1px solid rgba(48, 51, 47, .12); border-left: 4px solid var(--aw-sage); border-radius: .5rem; padding: 1.25rem;">
                    <span style="display: block; font-size: 1.85rem; font-weight: 700; color: #566B52;">{{ $stat->title }}</span>
                    <span style="display: block; margin-top: .35rem; font-size: .9rem; color: rgba(48, 51, 47, .8); line-height: 1.4;">{{ $stat->content }}</span>
                </div>
            @endforeach
        </section>
    @endif

    {{-- Kartu Materi Edukasi --}}
    <section style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3.5rem;">
        @if (isset($educationContents) && $educationContents->count() > 0)
            @foreach ($educationContents as $edu)
                <article style="background: var(--aw-white); border: 1px solid rgba(48, 51, 47, .12); border-radius: .75rem; overflow: hidden; display: flex; flex-direction: column;">
                    @if ($edu->image_path)
                        <img src="{{ $edu->image_path }}" alt="{{ $edu->title }}" style="width: 100%; height: 200px; object-fit: cover;" />
                    @endif
                    <div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <h3 style="font-size: 1.25rem; margin: 0 0 .5rem; color: var(--aw-charcoal);">{{ $edu->title }}</h3>
                            <p style="color: rgba(48, 51, 47, .75); font-size: .95rem; line-height: 1.55; margin: 0;">{{ $edu->content }}</p>
                        </div>
                    </div>
                </article>
            @endforeach
        @else
            <article style="background: var(--aw-white); border: 1px solid rgba(48, 51, 47, .12); border-radius: .75rem; padding: 1.5rem;">
                <h3 style="font-size: 1.2rem; margin: 0 0 .5rem;">1. Mengurangi Sampah Tekstil</h3>
                <p style="color: rgba(48, 51, 47, .75); line-height: 1.55; margin: 0;">Membeli satu potong pakaian bekas berarti menyelamatkan pakaian tersebut dari tempat pembuangan akhir (TPA) dan membakar sedikit emisi metana.</p>
            </article>
            <article style="background: var(--aw-white); border: 1px solid rgba(48, 51, 47, .12); border-radius: .75rem; padding: 1.5rem;">
                <h3 style="font-size: 1.2rem; margin: 0 0 .5rem;">2. Menghemat Ribuan Liter Air</h3>
                <p style="color: rgba(48, 51, 47, .75); line-height: 1.55; margin: 0;">Produksi sehelai kaos katun baru memerlukan rata-rata 2.700 liter air tawar. Dengan thrifting, kebutuhan air baru dapat ditekan secara nyata.</p>
            </article>
            <article style="background: var(--aw-white); border: 1px solid rgba(48, 51, 47, .12); border-radius: .75rem; padding: 1.5rem;">
                <h3 style="font-size: 1.2rem; margin: 0 0 .5rem;">3. Menekan Polusi Mikroplastik</h3>
                <p style="color: rgba(48, 51, 47, .75); line-height: 1.55; margin: 0;">Bahan sintetis seperti poliester dan nilon melepaskan serat mikroplastik ke lautan saat diproduksi massal. Circular fashion membantu memperlambat rantai ini.</p>
            </article>
        @endif
    </section>

    {{-- Penutup --}}
    <div style="background: #30332F; color: #FFFFFF; border-radius: 1rem; padding: 2.5rem; text-align: center;">
        <h2 style="font-size: 1.75rem; margin: 0 0 .75rem; color: #FFFFFF;">Mari Menjadi Bagian dari Solusi</h2>
        <p style="max-width: 600px; margin: 0 auto 1.5rem; color: rgba(255, 255, 255, .8); line-height: 1.6;">
            Setiap kali kamu memilih pakaian preloved di After Wear, kamu memberikan kontribusi nyata bagi kelestarian lingkungan dan gaya hidup berkelanjutan.
        </p>
        <a href="{{ route('products.index') }}" style="display: inline-block; padding: .75rem 1.75rem; background: #7D9278; color: #FFFFFF; border-radius: .5rem; font-weight: 600; text-decoration: none;">
            Mulai Belanja Sadar Lingkungan
        </a>
    </div>
</div>
@endsection
