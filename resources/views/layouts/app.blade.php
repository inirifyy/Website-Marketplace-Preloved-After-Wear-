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

    {{-- Font identitas After Wear. Jika gagal dimuat, fallback Georgia / system-ui tetap dipakai. --}}
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=cormorant-garamond:400,500,600,500i|inter:400,500,600&display=swap">

    {{-- Font tambahan: EB Garamond & Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{--
        Gaya dasar tata letak + palet warna proyek.
        Diletakkan SEBELUM @vite supaya resources/css/app.css tetap menang.
        Nama variabel lama (--aw-cream, --aw-sage, --aw-charcoal, --aw-white) DIPERTAHANKAN
        agar halaman anggota lain tidak rusak.
    --}}
    <style>
        :root {
            --aw-white: #FFFFFF;
            --aw-cream: #F7F7F6;
            --aw-charcoal: #111111;
            --aw-sage: #7FA487;

            --aw-gray-50: #F7F7F6;
            --aw-gray-100: #F1F1F0;
            --aw-gray-200: #E7E7E5;
            --aw-gray-500: #6B6B6B;
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

        :where(h1, h2) { font-family: var(--aw-font-serif); font-weight: 500; letter-spacing: -.01em; line-height: 1.15; }
        :where(h3, h4) { font-weight: 600; line-height: 1.3; }
        :where(a) { color: inherit; }
        :where(::selection) { background: var(--aw-charcoal); color: var(--aw-white); }

        :where(input:not([type=checkbox]):not([type=radio]):not([type=file]):not([type=submit]):not([type=button]):not([type=hidden]), select, textarea) {
            font-family: inherit; font-size: .9rem; color: var(--aw-charcoal);
            background: var(--aw-gray-100); border: 1px solid var(--aw-gray-200); border-radius: var(--aw-r-sm);
            padding: .6rem .8rem;
        }
        :where(input, select, textarea)::placeholder { color: #9A9A98; }
        :where(input, select, textarea):focus-visible { outline: 2px solid var(--aw-charcoal); outline-offset: 1px; }
        :where(a, button):focus-visible { outline: 2px solid var(--aw-charcoal); outline-offset: 2px; }

        .aw-alert { margin-block: 1rem; padding: .75rem 1rem; border-radius: var(--aw-r-sm); border: 1px solid var(--aw-gray-200); background: var(--aw-white); font-size: .9rem; }
        .aw-alert ul { margin: .25rem 0 0; padding-left: 1.25rem; }
        .aw-alert-success { background: var(--aw-success-bg); border-color: #CFE3D5; color: var(--aw-success-ink); }
        .aw-alert-error { background: #FEF2F2; border-color: #FECACA; color: #991B1B; }
    </style>

    {{-- Gaya untuk navbar/beranda/katalog/detail produk (kelas .wrap, .btn, .hero, dst.) --}}
    @include('partials.page-styles')

    {{-- Gaya sesuai desain Figma: font, navbar, tombol, footer. Harus SETELAH page-styles. --}}
    @include('partials.figma-styles')

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    {{-- Tempat CSS tambahan khusus halaman: @push('styles') ... @endpush --}}
    @stack('styles')
</head>
<body class="aw-body">

    @php
        // Pakai logo baru kalau sudah diekspor dari Figma, kalau belum pakai yang lama.
        $logoFile = file_exists(public_path('images/logo-after-wear.png'))
            ? 'images/logo-after-wear.png'
            : 'images/Logo After Wear.png';
    @endphp

    {{-- ================= NAVBAR ================= --}}
    <header class="nav">
      <div class="wrap">
        <a class="brand" href="{{ route('home') }}">
          <img src="{{ asset($logoFile) }}" alt="" onerror="this.remove()">
          <span>After Wear</span>
        </a>

        <form class="search" action="{{ route('products.index') }}" method="GET">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
          <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari pakaian preloved..." aria-label="Cari produk">
        </form>

        <ul>
          <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'on' : '' }}">Beranda</a></li>
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
              <a class="btn warn" href="{{ route('phone.verification.notice') }}">Verifikasi HP</a>
            @endif

            <span class="sep"></span>
            <a class="avatar" href="{{ route('profile.show') }}" title="{{ $navUser->name }}">{{ mb_strtoupper(mb_substr($navUser->name, 0, 1)) }}</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;margin:0">
              @csrf
              <button type="submit" class="btn-text">Keluar</button>
            </form>
          @endguest
        </div>
      </div>
    </header>

    <main class="aw-main">
        {{-- Pesan sukses/gagal dari controller dan error validasi form --}}
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

    {{-- ================= FOOTER ================= --}}
    <footer class="foot">
      <div class="wrap foot-grid">
        <div class="foot-brand">
          <a class="brand" href="{{ route('home') }}">
            <img src="{{ asset($logoFile) }}" alt="" onerror="this.remove()">
            <span>After Wear</span>
          </a>
          <p>Marketplace kurasi pakaian preloved terpercaya untuk mendukung fashion sirkular dan UMKM Indonesia.</p>
          <p class="foot-note">Kurasi teliti, transparansi kondisi, dan dampak nyata untuk keberlanjutan bumi.</p>
        </div>

        <div class="foot-contact">
          <h3>Kontak &amp; Ekosistem</h3>
          <p>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
           <a href="https://wa.me/6281312547254" target="_blank" rel="noopener" style="color:inherit;text-decoration:none">WhatsApp UMKM: +62<br>813-1254-7254</a>
          </p>
          <p>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
            <span>Instagram: @afterwear.id</span>
          </p>
          <p><span>Makassar, Indonesia</span></p>
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