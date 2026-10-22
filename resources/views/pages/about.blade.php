@extends('layouts.app')

@section('title', 'Tentang Kami')
@section('meta_description', 'Kenali Prelove After Wear, marketplace pakaian preloved yang mempertemukan penjual dan pembeli sekaligus mengajak peduli pada limbah tekstil.')

@section('content')
<div class="about-page">

    {{-- 1. Pengantar --}}
    <section class="about-hero" aria-labelledby="about-title">
        <div class="aw-container">
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
    </section>

    {{-- 2. Konsep marketplace preloved --}}
    <section class="about-section" aria-labelledby="about-concept-title">
        <div class="aw-container">
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
                    <h3 class="about-card-title">Mempertemukan penjual dan pembeli</h3>
                    <p>Menyediakan tempat yang mudah digunakan untuk menjual dan mencari pakaian preloved.</p>
                </article>
                <article class="about-card">
                    <h3 class="about-card-title">Memperpanjang masa pakai pakaian</h3>
                    <p>Mendorong pakaian yang masih layak untuk dipakai lagi oleh orang lain.</p>
                </article>
                <article class="about-card">
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
        <div class="aw-container">
            <h2 id="about-waste-title" class="about-section-title">Peduli limbah tekstil</h2>
            <p>
                Pakaian yang dibuang sebelum waktunya ikut menambah limbah tekstil. Dengan memakai kembali
                pakaian yang masih baik, kita ikut mengurangi jumlah pakaian yang terbuang. Kami menyediakan
                halaman edukasi agar pengunjung bisa mengenal masalah ini dan mengetahui langkah kecil yang
                bisa dilakukan.
            </p>
            <p>
                <a class="about-link" href="{{ route('education') }}">Baca halaman edukasi limbah tekstil</a>
            </p>
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
            <h2 id="about-cta-title" class="about-section-title">Mulai beri pakaian kesempatan kedua</h2>
            <div class="about-actions">
                <a class="about-button about-button-primary" href="{{ route('products.index') }}">Jelajahi Katalog</a>
                <a class="about-button about-button-secondary" href="{{ route('seller.submissions.create') }}">Jual Barang</a>
            </div>
        </div>
    </section>

</div>
@endsection