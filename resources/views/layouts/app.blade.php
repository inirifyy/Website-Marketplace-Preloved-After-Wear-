<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    {{-- Wajib untuk tampilan responsif di ponsel --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'After Wear: marketplace barang preloved layak pakai untuk membantu mengurangi limbah tekstil.')">

    {{-- Judul dinamis: tiap halaman mengisi @section('title', '...') --}}
    <title>@hasSection('title') @yield('title') | After Wear @else After Wear | Marketplace Preloved @endif</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    {{-- Font dari konfigurasi vite.config.js (kosong jika belum di-build) --}}
    @fonts

    {{--
        Font identitas After Wear (sesuai desain Figma):
        - Serif editorial untuk heading : Cormorant Garamond
        - Sans-serif untuk antarmuka    : Inter
        Dimuat langsung di sini karena vite.config.js bukan bagian dari file ini.
        Jika font gagal dimuat, fallback Georgia / system-ui tetap dipakai.
    --}}
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=cormorant-garamond:400,500,600,500i|inter:400,500,600&display=swap">

    {{-- Font tambahan: EB Garamond & Plus Jakarta Sans (dari layout kedua) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{--
        Gaya dasar tata letak + palet warna proyek.
        Diletakkan SEBELUM @vite supaya resources/css/app.css tetap menang.
        Nama variabel lama (--aw-cream, --aw-sage, --aw-charcoal, --aw-white) DIPERTAHANKAN
        agar halaman anggota lain tidak rusak; hanya nilainya yang disesuaikan ke desain Figma.
        Aturan umum memakai :where() (specificity 0) supaya gaya komponen mana pun tetap menang.
    --}}
    <style>
        :root {
            /* Palet utama (monokrom) */
            --aw-white: #FFFFFF;          /* background utama */
            --aw-cream: #F7F7F6;          /* off-white: section / area pembeda */
            --aw-charcoal: #111111;       /* teks utama, tombol utama, sidebar admin */
            --aw-sage: #7FA487;           /* soft green: HANYA sukses / verifikasi / sustainability */

            /* Token tambahan */
            --aw-gray-50: #F7F7F6;
            --aw-gray-100: #F1F1F0;       /* input, card tertentu */
            --aw-gray-200: #E7E7E5;       /* border tipis */
            --aw-gray-500: #6B6B6B;       /* teks sekunder */
            --aw-success-bg: #EEF5F0;
            --aw-success-ink: #2F6B45;

            --aw-font-sans: 'Inter', 'Instrument Sans', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
            --aw-font-serif: 'Cormorant Garamond', 'Playfair Display', Georgia, 'Times New Roman', serif;

            --aw-r-sm: 6px;
            --aw-r-md: 10px;
            --aw-shadow-soft: 0 1px 2px rgba(17, 17, 17, .04), 0 4px 16px rgba(17, 17, 17, .04);
        }
        *, *::before, *::after { box-sizing: border-box; }
        html { -webkit-text-size-adjust: 100%; }
        :where(body.aw-body) {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: var(--aw-font-sans);
            font-size: 15px;
            line-height: 1.6;
            color: var(--aw-charcoal);
            background: var(--aw-white);
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }
        .aw-main { flex: 1 0 auto; width: 100%; }
        .aw-container { width: 100%; max-width: 1200px; margin-inline: auto; padding-inline: 1rem; }
        @media (min-width: 768px) { .aw-container { padding-inline: 2rem; } }
        img, video { max-width: 100%; }

        /* Tipografi dasar: heading memakai serif editorial (h1 & h2 saja, specificity 0) */
        :where(h1, h2) { font-family: var(--aw-font-serif); font-weight: 500; letter-spacing: -.01em; line-height: 1.15; }
        :where(h3, h4) { font-weight: 600; line-height: 1.3; }
        :where(a) { color: inherit; }
        :where(::selection) { background: var(--aw-charcoal); color: var(--aw-white); }

        /* Form dasar: input abu-abu muda, border tipis (specificity 0) */
        :where(input:not([type=checkbox]):not([type=radio]):not([type=file]):not([type=submit]):not([type=button]):not([type=hidden]), select, textarea) {
            font-family: inherit; font-size: .9rem; color: var(--aw-charcoal);
            background: var(--aw-gray-100); border: 1px solid var(--aw-gray-200); border-radius: var(--aw-r-sm);
            padding: .6rem .8rem;
        }
        :where(input, select, textarea)::placeholder { color: #9A9A98; }
        :where(input, select, textarea):focus-visible { outline: 2px solid var(--aw-charcoal); outline-offset: 1px; }
        :where(a, button):focus-visible { outline: 2px solid var(--aw-charcoal); outline-offset: 2px; }

        /* Pesan sukses / gagal: soft green hanya untuk sukses */
        .aw-alert { margin-block: 1rem; padding: .75rem 1rem; border-radius: var(--aw-r-sm); border: 1px solid var(--aw-gray-200); background: var(--aw-white); font-size: .9rem; }
        .aw-alert ul { margin: .25rem 0 0; padding-left: 1.25rem; }
        .aw-alert-success { background: var(--aw-success-bg); border-color: #CFE3D5; color: var(--aw-success-ink); }
        .aw-alert-error { background: #FEF2F2; border-color: #FECACA; color: #991B1B; }

        /*
         * Navbar publik (markup ada di partials/navbar.blade.php, milik anggota lain, TIDAK diubah).
         * Di sini hanya penyesuaian visual lewat selector ber-prefix .aw-body supaya menang atas
         * <style> milik partial tanpa memakai !important pada elemen lain.
         */
        .aw-body .aw-nav { background: var(--aw-white); border-bottom: 1px solid var(--aw-gray-200); font-family: var(--aw-font-sans); }
        .aw-body .aw-nav__inner { height: 3.5rem; gap: 1.5rem; }
        .aw-body .aw-nav__brand { font-family: var(--aw-font-serif); font-size: 1.35rem; font-weight: 600; letter-spacing: -.01em; color: var(--aw-charcoal); }
        .aw-body .aw-nav__brand span { color: inherit; }
        .aw-body .aw-nav__brand > span[style] { background: var(--aw-charcoal) !important; border-radius: var(--aw-r-sm) !important; width: 1.5rem !important; height: 1.5rem !important; line-height: 1.5rem !important; font-size: .8rem !important; }
        .aw-body .aw-nav__menu { gap: 1.5rem; font-size: .8125rem; font-weight: 500; }
        .aw-body .aw-nav__menu a { color: var(--aw-gray-500); }
        .aw-body .aw-nav__menu a:hover { color: var(--aw-charcoal); }
        .aw-body .aw-nav__actions { gap: .5rem; font-size: .8125rem; }
        .aw-body .aw-nav .aw-btn { padding: .4rem .9rem; border-radius: var(--aw-r-sm); font-size: .8125rem; font-weight: 500; line-height: 1.4; }
        .aw-body .aw-nav .aw-btn-primary,
        .aw-body .aw-nav .aw-btn-seller { background: var(--aw-charcoal); color: var(--aw-white); border: 1px solid var(--aw-charcoal); }
        .aw-body .aw-nav .aw-btn-primary:hover,
        .aw-body .aw-nav .aw-btn-seller:hover { background: #2A2A2A; color: var(--aw-white); }
        .aw-body .aw-nav .aw-btn-outline { background: var(--aw-white); color: var(--aw-charcoal); border: 1px solid var(--aw-gray-200); }
        .aw-body .aw-nav .aw-btn-outline:hover { background: var(--aw-gray-50); border-color: #CFCFCD; }
        /* Tombol admin di navbar memakai warna amber inline; diseragamkan ke monokrom */
        .aw-body .aw-nav .aw-btn-outline[style*="F59E0B"] { border-color: var(--aw-gray-200) !important; color: var(--aw-charcoal) !important; }
        @media (max-width: 767px) {
            .aw-body .aw-nav__inner { height: auto; min-height: 3.5rem; flex-wrap: wrap; padding-block: .5rem; gap: .5rem 1rem; }
            .aw-body .aw-nav__actions { flex-wrap: wrap; }
        }
        @media (min-width: 768px) and (max-width: 1023px) { .aw-body .aw-nav__menu { gap: 1rem; } }
    </style>

    {{-- Gaya untuk navbar/beranda/katalog/detail produk (kelas .wrap, .btn, .hero, dst.) --}}
    @include('partials.page-styles')

    {{--
        CSS dan JS dimuat lewat Vite sesuai vite.config.js.
        Dibungkus pengecekan seperti bawaan Laravel: halaman tetap tampil
        (tanpa gaya) sebelum "npm run dev" atau "npm run build" dijalankan,
        jadi tidak muncul error ViteManifestNotFoundException.
    --}}
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    {{-- Tempat CSS tambahan khusus halaman: @push('styles') ... @endpush --}}
    @stack('styles')
</head>
<body class="aw-body">

    {{-- ================= NAVBAR (inline, dari layout kedua) ================= --}}
    {{-- Versi lama: @include('partials.navbar') -- dinonaktifkan agar navbar tidak tampil dobel --}}
    <header class="nav"><div class="wrap">
      <a class="brand" href="{{ route('home') }}">After Wear</a>
      <form class="search" action="{{ route('products.index') }}" method="GET">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari pakaian preloved..." aria-label="Cari produk">
      </form>
      <ul>
        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'on' : '' }}">Beranda</a></li>
        <li><a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'on' : '' }}">Katalog</a></li>
        <li><a href="{{ route('education') }}" class="{{ request()->routeIs('education') ? 'on' : '' }}">Edukasi</a></li>
        <li><a href="{{ route('testimonials') }}" class="{{ request()->routeIs('testimonials') ? 'on' : '' }}">Testimoni</a></li>
        @if (! auth()->check() || auth()->user()->isSeller())
          <li><a href="{{ route('seller.submissions.create') }}">Jual Barang</a></li>
        @endif
      </ul>
      <div class="acts">
        @guest
          <a class="btn" href="{{ route('login') }}">Masuk</a>
          <a class="btn dark" href="{{ route('register') }}">Daftar</a>
        @else
          @php $navUser = auth()->user(); @endphp

          @if ($navUser->isAdmin())
            <a class="btn dark" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
            <a class="btn" href="{{ route('admin.categories.index') }}">Kategori</a>
          @elseif ($navUser->isSeller())
            <a class="btn" href="{{ route('seller.dashboard') }}">Toko Saya</a>
          @else
            <form method="POST" action="{{ route('profile.become-seller') }}" style="display:inline;margin:0"
                  onsubmit="return confirm('Ubah akun Anda menjadi akun penjual?');">
              @csrf
              <button type="submit" class="btn">Jadi Penjual</button>
            </form>
          @endif

          @if (! $navUser->isAdmin() && ! $navUser->hasVerifiedPhone())
            <a class="btn" href="{{ route('phone.verification.notice') }}" style="border-color:#F59E0B;color:#B45309">Verifikasi HP</a>
          @endif

          <a class="btn" href="{{ route('profile.show') }}">{{ \Illuminate\Support\Str::limit($navUser->name, 14) }}</a>
          <form method="POST" action="{{ route('logout') }}" style="display:inline;margin:0">
            @csrf
            <button type="submit" class="btn">Keluar</button>
          </form>
        @endguest
      </div>
    </div></header>

    <main class="aw-main">
        {{-- Pesan sukses/gagal dari controller: redirect()->with('success', '...') dan error validasi form --}}
        @if (session('success') || session('error') || $errors->any())
            <div class="aw-container">
                @if (session('success'))
                    <div class="aw-alert aw-alert-success" role="status">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="aw-alert aw-alert-error" role="alert">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="aw-alert aw-alert-error" role="alert">
                        <strong>Periksa kembali isian Anda:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif

        {{-- Isi tiap halaman --}}
        @yield('content')
    </main>

    {{-- ================= FOOTER (inline, dari layout kedua) ================= --}}
    {{-- Versi lama: @include('partials.footer') -- dinonaktifkan agar footer tidak tampil dobel --}}
    <footer class="foot">
      <div class="wrap">
        <div style="max-width:380px">
          <div class="brand">After Wear</div>
          <p class="mute" style="margin-top:8px">Marketplace kurasi pakaian preloved terpercaya untuk mendukung fashion sirkular dan UMKM Indonesia.</p>
        </div>
        <div>
          <b>Kontak &amp; Ekosistem</b>
          <p class="mute" style="margin-top:8px">WhatsApp UMKM: +62 852-4128-6043<br>Instagram: @afterwear.id<br>Makassar, Indonesia</p>
        </div>
      </div>
      <div class="wrap copy">
        <span>Hak cipta © 2026 After Wear.</span>
        <span>
          Pemberdayaan UMKM Fesyen Indonesia
          @guest
            &nbsp;•&nbsp; <a href="{{ route('login', ['as' => 'seller']) }}">Masuk Penjual</a>
            &nbsp;•&nbsp; <a href="{{ route('login', ['as' => 'admin']) }}">Masuk Admin</a>
          @endguest
        </span>
      </div>
    </footer>

    {{-- Tempat JavaScript tambahan khusus halaman: @push('scripts') ... @endpush --}}
    @stack('scripts')
</body>
</html>