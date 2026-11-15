@extends('layouts.app')

@section('title', 'Tentang Kami')
@section('meta_description', 'Kenali Prelove After Wear, marketplace pakaian preloved yang mempertemukan penjual dan pembeli sekaligus mengajak peduli pada limbah tekstil.')

{{--
    Gaya halaman About. Semua selector diawali .about-page agar tidak memengaruhi halaman lain.
    Memakai variabel dari layouts/app.blade.php (--aw-charcoal, --aw-gray-*, --aw-font-serif, dst).
--}}
@push('styles')
<style>
    .about-page { color: var(--aw-charcoal); padding-bottom: 4rem; }
    .about-page p { margin: 0; }
    .about-section { padding-block: 3.5rem; }
    .about-section-alt { background: var(--aw-gray-50); border-block: 1px solid var(--aw-gray-200); }

    /* Heading & teks */
    .about-eyebrow { margin-bottom: .9rem; font-size: .75rem; font-weight: 500; letter-spacing: .12em; text-transform: uppercase; color: var(--aw-gray-500); }
    .about-title { margin: 0 0 1rem; font-size: clamp(2.1rem, 4.5vw, 3.1rem); }
    .about-lead { max-width: 38rem; font-size: .95rem; line-height: 1.75; color: var(--aw-gray-500); }
    .about-section-title { margin: 0 0 .75rem; font-size: clamp(1.5rem, 2.6vw, 1.9rem); }
    .about-page .about-body, .about-section p { font-size: .9rem; line-height: 1.8; color: var(--aw-gray-500); }

    /* Hero: kartu terang bergaya editorial */
    .about-hero { padding-block: 1.5rem 0; }
    .about-hero .about-hero-card { padding: clamp(2rem, 6vw, 4.5rem) clamp(1.5rem, 5vw, 4rem); background: var(--aw-gray-50); border: 1px solid var(--aw-gray-200); border-radius: var(--aw-r-md); box-shadow: var(--aw-shadow-soft); }

    /* Tombol */
    .about-actions { display: flex; flex-wrap: wrap; gap: .6rem; margin-top: 1.75rem; }
    .about-button { display: inline-flex; align-items: center; justify-content: center; gap: .4rem; padding: .65rem 1.15rem; border-radius: var(--aw-r-sm); border: 1px solid transparent; font-size: .8125rem; font-weight: 500; line-height: 1.3; text-decoration: none; transition: background .15s, border-color .15s, color .15s; }
    .about-button-primary { background: var(--aw-charcoal); color: var(--aw-white); border-color: var(--aw-charcoal); }
    .about-button-primary:hover { background: #2A2A2A; }
    .about-button-secondary { background: var(--aw-gray-100); color: var(--aw-charcoal); border-color: var(--aw-gray-200); }
    .about-button-secondary:hover { background: var(--aw-gray-200); }

    /* Konsep: judul kiri, isi kanan */
    .about-split { display: grid; gap: 1rem 4rem; grid-template-columns: 1fr; align-items: start; }
    @media (min-width: 900px) { .about-split { grid-template-columns: 5fr 7fr; } .about-split .about-section-title { margin: 0; } }

    /* Kartu */
    .about-grid { display: grid; gap: 1rem; grid-template-columns: 1fr; margin-top: 1.75rem; }
    @media (min-width: 700px) { .about-grid { grid-template-columns: repeat(3, 1fr); } }
    .about-card { display: flex; flex-direction: column; gap: .5rem; padding: 1.4rem; background: var(--aw-white); border: 1px solid var(--aw-gray-200); border-radius: var(--aw-r-md); box-shadow: var(--aw-shadow-soft); }
    .about-card-title { margin: 0; font-size: .95rem; font-weight: 600; color: var(--aw-charcoal); }
    .about-card p { font-size: .85rem; line-height: 1.65; color: var(--aw-gray-500); }
    .about-icon { display: inline-flex; align-items: center; justify-content: center; width: 2.25rem; height: 2.25rem; margin-bottom: .6rem; border-radius: var(--aw-r-sm); background: var(--aw-gray-100); color: var(--aw-charcoal); }
    .about-icon svg { width: 1.05rem; height: 1.05rem; fill: none; stroke: currentColor; stroke-width: 1.6; stroke-linecap: round; stroke-linejoin: round; }
    .about-icon-green { background: var(--aw-success-bg); color: var(--aw-success-ink); }

    /* Daftar manfaat */
    .about-list { display: grid; gap: .75rem; grid-template-columns: 1fr; margin: 1.75rem 0 0; padding: 0; list-style: none; }
    @media (min-width: 700px) { .about-list { grid-template-columns: repeat(2, 1fr); } }
    .about-list li { display: flex; align-items: flex-start; gap: .75rem; padding: 1rem 1.1rem; background: var(--aw-white); border: 1px solid var(--aw-gray-200); border-radius: var(--aw-r-md); font-size: .875rem; line-height: 1.6; color: var(--aw-charcoal); }
    .about-list li::before { content: ""; flex: none; width: 1.15rem; height: 1.15rem; margin-top: .1rem; border-radius: 50%; background: var(--aw-charcoal) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23fff' stroke-width='3.2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 12.5l4 4 8-9'/%3E%3C/svg%3E") center / 70% no-repeat; }

    /* Limbah tekstil */
    .about-waste { display: grid; gap: 1rem 4rem; grid-template-columns: 1fr; align-items: start; }
    @media (min-width: 900px) { .about-waste { grid-template-columns: 5fr 7fr; } }
    .about-waste-body { display: flex; flex-direction: column; gap: 1rem; }
    .about-link { display: inline-flex; align-items: center; gap: .35rem; font-size: .8125rem; font-weight: 500; color: var(--aw-charcoal); text-decoration: none; border-bottom: 1px solid var(--aw-charcoal); padding-bottom: 1px; }
    .about-link:hover { color: var(--aw-gray-500); border-color: var(--aw-gray-500); }

    /* Langkah kerja */
    .about-steps { display: grid; gap: 1rem; grid-template-columns: 1fr; margin: 1.75rem 0 0; padding: 0; list-style: none; counter-reset: about-step; }
    @media (min-width: 700px) { .about-steps { grid-template-columns: repeat(3, 1fr); } }
    .about-step { counter-increment: about-step; display: flex; flex-direction: column; gap: .5rem; padding: 1.4rem; background: var(--aw-white); border: 1px solid var(--aw-gray-200); border-radius: var(--aw-r-md); box-shadow: var(--aw-shadow-soft); }
    .about-step::before { content: "0" counter(about-step); font-family: var(--aw-font-serif); font-size: 1.9rem; line-height: 1; font-weight: 500; color: #B5B5B2; margin-bottom: .6rem; }
    .about-step p { font-size: .85rem; line-height: 1.65; color: var(--aw-gray-500); }

    /* Ajakan: panel hitam seperti kartu sorotan di desain */
    .about-cta { padding-block: 1rem 0; }
    .about-cta .about-cta-card { padding: clamp(2rem, 6vw, 3.5rem) clamp(1.5rem, 5vw, 4rem); background: var(--aw-charcoal); color: var(--aw-white); border-radius: var(--aw-r-md); }
    .about-cta .about-section-title { margin: 0; max-width: 28rem; color: var(--aw-white); }
    .about-cta .about-button-primary { background: var(--aw-white); color: var(--aw-charcoal); border-color: var(--aw-white); }
    .about-cta .about-button-primary:hover { background: var(--aw-gray-100); }
    .about-cta .about-button-secondary { background: transparent; color: var(--aw-white); border-color: rgba(255, 255, 255, .35); }
    .about-cta .about-button-secondary:hover { background: rgba(255, 255, 255, .1); }

    @media (max-width: 480px) {
        .about-section { padding-block: 2.5rem; }
        .about-actions .about-button { flex: 1 1 100%; }
    }
</style>
@endpush

@section('content')
<div class="about-page">

    {{-- 1. Pengantar --}}
    <section class="about-hero" aria-labelledby="about-title">
        <div class="aw-container">
            <div class="about-hero-card">
                <p class="about-eyebrow">Tentang Kami</p>
                <h1 id="about-title" class="about-title">Prelove After Wear</h1>
                <p class="about-lead">
                    Prelove After Wear adalah marketplace pakaian preloved yang mempertemukan penjual
                    dan pembeli. Kami percaya pakaian yang masih layak pakai pantas mendapat kesempatan
                    kedua, bukan berakhir tidak terpakai di dalam lemari.
                </p>
                <div class="about-actions">
                    <a class="about-button about-button-primary" href="{{ route('products.index') }}">Lihat Katalog</a>
                    <a class="about-button about-button-secondary" href="{{ route('education') }}">Pelajari Limbah Tekstil</a>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. Konsep marketplace preloved --}}
    <section class="about-section" aria-labelledby="about-concept-title">
        <div class="aw-container about-split">
            <h2 id="about-concept-title" class="about-section-title">Apa itu marketplace preloved?</h2>
            <p>
                Preloved berarti barang yang sudah pernah dipakai, tetapi kondisinya masih baik dan layak
                dipakai kembali. Di After Wear, penjual menampilkan pakaian yang tidak lagi mereka pakai,
                lengkap dengan foto, harga, kondisi, dan lokasi. Pembeli bisa menemukan pakaian yang
                sesuai kebutuhan dengan cara yang lebih hemat dan bertanggung jawab.
            </p>
        </div>
    </section>

    {{-- 3. Tujuan --}}
    <section class="about-section about-section-alt" aria-labelledby="about-goals-title">
        <div class="aw-container">
            <h2 id="about-goals-title" class="about-section-title">Tujuan kami</h2>
            <div class="about-grid">
                <article class="about-card">
                    <span class="about-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M16 20v-1.5a3.5 3.5 0 0 0-3.5-3.5h-5A3.5 3.5 0 0 0 4 18.5V20"/><circle cx="10" cy="8" r="3.2"/><path d="M20 20v-1.5a3.5 3.5 0 0 0-2.5-3.35M15.5 4.9a3.2 3.2 0 0 1 0 6.2"/></svg>
                    </span>
                    <h3 class="about-card-title">Mempertemukan penjual dan pembeli</h3>
                    <p>Menyediakan tempat yang mudah digunakan untuk menjual dan mencari pakaian preloved.</p>
                </article>
                <article class="about-card">
                    <span class="about-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M20 12a8 8 0 0 1-13.7 5.6M4 12a8 8 0 0 1 13.7-5.6"/><path d="M18 3v4h-4M6 21v-4h4"/></svg>
                    </span>
                    <h3 class="about-card-title">Memperpanjang masa pakai pakaian</h3>
                    <p>Mendorong pakaian yang masih layak untuk dipakai lagi oleh orang lain.</p>
                </article>
                <article class="about-card">
                    <span class="about-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/></svg>
                    </span>
                    <h3 class="about-card-title">Menumbuhkan kepedulian</h3>
                    <p>Mengajak pengunjung memahami dampak limbah tekstil dan memilih kebiasaan berpakaian yang lebih bijak.</p>
                </article>
            </div>
        </div>
    </section>

    {{-- 4. Manfaat memperpanjang masa pakai pakaian --}}
    <section class="about-section" aria-labelledby="about-benefits-title">
        <div class="aw-container">
            <h2 id="about-benefits-title" class="about-section-title">Manfaat memperpanjang masa pakai pakaian</h2>
            <ul class="about-list">
                <li>Pakaian yang masih layak tidak cepat menjadi sampah.</li>
                <li>Pembeli bisa mendapatkan pakaian dengan harga yang lebih terjangkau.</li>
                <li>Penjual bisa memanfaatkan pakaian yang sudah tidak terpakai.</li>
                <li>Kebutuhan akan pakaian baru dapat berkurang jika pakaian lama dipakai kembali.</li>
            </ul>
        </div>
    </section>

    {{-- 5. Kepedulian terhadap limbah tekstil --}}
    <section class="about-section about-section-alt" aria-labelledby="about-waste-title">
        <div class="aw-container about-waste">
            <div>
                <span class="about-icon about-icon-green" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M5 19c0-8 5-13 14-14 0 9-5 14-13 14"/><path d="M5 19c2-4 5-7 9-9"/></svg>
                </span>
                <h2 id="about-waste-title" class="about-section-title">Peduli limbah tekstil</h2>
            </div>
            <div class="about-waste-body">
                <p>
                    Pakaian yang dibuang sebelum waktunya ikut menambah limbah tekstil. Dengan memakai kembali
                    pakaian yang masih baik, kita ikut mengurangi jumlah pakaian yang terbuang. Kami menyediakan
                    halaman edukasi agar pengunjung bisa mengenal masalah ini dan mengetahui langkah kecil yang
                    bisa dilakukan.
                </p>
                <p>
                    <a class="about-link" href="{{ route('education') }}">Baca halaman edukasi limbah tekstil <span aria-hidden="true">&rarr;</span></a>
                </p>
            </div>
        </div>
    </section>

    {{-- 6. Cara kerja singkat.
         Sesuaikan isinya jika alur fitur penjual dan admin berubah. --}}
    <section class="about-section" aria-labelledby="about-how-title">
        <div class="aw-container">
            <h2 id="about-how-title" class="about-section-title">Bagaimana After Wear bekerja?</h2>
            <ol class="about-steps">
                <li class="about-step">
                    <h3 class="about-card-title">Penjual mengajukan produk</h3>
                    <p>Penjual mengisi formulir pengajuan berisi foto, harga, kondisi, dan lokasi pakaian.</p>
                </li>
                <li class="about-step">
                    <h3 class="about-card-title">Admin meninjau pengajuan</h3>
                    <p>Pengajuan ditinjau terlebih dahulu sebelum produk tampil di katalog.</p>
                </li>
                <li class="about-step">
                    <h3 class="about-card-title">Pembeli menemukan produk</h3>
                    <p>Pembeli menelusuri katalog, melihat detail produk, lalu menghubungi penjual.</p>
                </li>
            </ol>
        </div>
    </section>

    {{-- 7. Ajakan --}}
    <section class="about-cta" aria-labelledby="about-cta-title">
        <div class="aw-container">
            <div class="about-cta-card">
                <h2 id="about-cta-title" class="about-section-title">Mulai beri pakaian kesempatan kedua</h2>
                <div class="about-actions">
                    <a class="about-button about-button-primary" href="{{ route('products.index') }}">Jelajahi Katalog</a>
                    <a class="about-button about-button-secondary" href="{{ route('seller.submissions.create') }}">Jual Barang</a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection