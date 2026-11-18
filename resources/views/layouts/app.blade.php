<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'After Wear')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header class="nav"><div class="wrap">
  <a class="brand" href="{{ url('/') }}">After Wear</a>
  <form class="search" action="{{ url('/products') }}" method="GET">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari pakaian preloved..." aria-label="Cari produk">
  </form>
  <ul>
    <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'on' : '' }}">Beranda</a></li>
    <li><a href="{{ url('/education') }}" class="{{ request()->is('education*') ? 'on' : '' }}">Edukasi</a></li>
    <li><a href="{{ url('/testimonials') }}">Testimoni</a></li>
    <li><a href="{{ url('/seller/submissions/create') }}">Jual Barang</a></li>
  </ul>
  <div class="acts">
    @guest
      <a class="btn" href="{{ url('/login') }}">Masuk</a>
      <a class="btn dark" href="{{ url('/register') }}">Daftar</a>
    @else
      <a class="btn" href="{{ url('/profile') }}">{{ auth()->user()->name }}</a>
    @endguest
  </div>
</div></header>

<main>@yield('content')</main>

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
  <div class="wrap copy"><span>Hak cipta © 2026 After Wear.</span><span>Pemberdayaan UMKM Fesyen Indonesia</span></div>
</footer>
</body>
</html>