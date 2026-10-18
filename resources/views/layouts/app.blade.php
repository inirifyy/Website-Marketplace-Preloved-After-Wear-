kerangka utama website, seperti font, CSS, navbar, footer, dan tempat isi halaman ditampilkan.

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    {{-- Wajib untuk tampilan responsif di ponsel --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'After Wear: marketplace barang preloved layak pakai untuk membantu mengurangi limbah tekstil.')">

    {{-- Judul dinamis: tiap halaman mengisi @section('title', '...') --}}
    <title>@hasSection('title')@yield('title') | After Wear @else After Wear | Marketplace Preloved @endif</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    {{-- Font dari konfigurasi vite.config.js (kosong jika belum di-build) --}}
    @fonts

    {{--
        CSS dan JS dimuat lewat Vite sesuai vite.config.js.
        Dibungkus pengecekan seperti bawaan Laravel: halaman tetap tampil
        (tanpa gaya) sebelum "npm run dev" atau "npm run build" dijalankan,
        jadi tidak muncul error ViteManifestNotFoundException.
    --}}
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    {{-- Gaya dasar tata letak saja. Gaya lengkap tetap di resources/css/app.css --}}
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body.aw-body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
            line-height: 1.5;
            color: #1f2937;
            background: #ffffff;
        }
        .aw-main { flex: 1 0 auto; width: 100%; }
        .aw-container { width: 100%; max-width: 1200px; margin-inline: auto; padding-inline: 1rem; }
        @media (min-width: 768px) { .aw-container { padding-inline: 1.5rem; } }
        img, video { max-width: 100%; }
        .aw-alert { margin-block: 1rem; padding: .75rem 1rem; border-radius: .5rem; border: 1px solid transparent; }
        .aw-alert-success { background: #ecfdf5; border-color: #a7f3d0; color: #065f46; }
        .aw-alert-error { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
    </style>

    {{-- Tempat CSS tambahan khusus halaman: @push('styles') ... @endpush --}}
    @stack('styles')
</head>
<body class="aw-body">

    {{-- Navbar dan footer hanya dipanggil di sini, JANGAN di-include lagi di halaman lain --}}
    @include('partials.navbar')

    <main class="aw-main">
        {{-- Pesan sukses/gagal dari controller: redirect()->with('success', '...') --}}
        @if (session('success') || session('error'))
            <div class="aw-container">
                @if (session('success'))
                    <div class="aw-alert aw-alert-success" role="status">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="aw-alert aw-alert-error" role="alert">{{ session('error') }}</div>
                @endif
            </div>
        @endif

        {{-- Isi tiap halaman --}}
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Tempat JavaScript tambahan khusus halaman: @push('scripts') ... @endpush --}}
    @stack('scripts')
</body>
</html>