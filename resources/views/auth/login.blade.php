@extends('layouts.auth')

@section('title', 'Masuk ke Akun')

@section('content')
@php
    // Peran yang sedang dipilih: dari ?as=buyer|seller|admin (dikirim AuthController), atau input lama setelah gagal login.
    $role = old('login_as', $loginAs ?? 'buyer');
    if (! in_array($role, ['buyer', 'seller', 'admin'], true)) { $role = 'buyer'; }

    $logoFile = file_exists(public_path('images/logo-after-wear.png')) ? 'images/logo-after-wear.png' : 'images/Logo After Wear.png';
    // Foto latar: terima login-bg dengan ekstensi jpg, jpeg, png, atau webp.
    $bgFile = null;
    foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
        if (file_exists(public_path('images/login-bg.' . $ext))) { $bgFile = asset('images/login-bg.' . $ext); break; }
    }

    $copy = [
        'buyer' => [
            'title' => 'Masuk sebagai Pembeli',
            'desc' => 'Kelola profil dan riwayat ulasan Anda saat berbelanja fashion preloved.',
            'btn' => 'Masuk sebagai Pembeli',
            'ph' => 'pembeli@example.com',
        ],
        'seller' => [
            'title' => 'Masuk sebagai Penjual',
            'desc' => 'Akses dashboard penjual untuk mengelola pengajuan produk, kurasi, dan aktivitas toko Anda.',
            'btn' => 'Masuk sebagai Penjual',
            'ph' => 'toko@umkm.example.com',
        ],
        'admin' => [
            'title' => 'Masuk sebagai Admin',
            'desc' => 'Khusus pengelola After Wear untuk mengelola produk, kategori, dan konten website.',
            'btn' => 'Masuk sebagai Admin',
            'ph' => 'admin@afterwear.test',
        ],
    ];
    $c = $copy[$role];
    $lupaSandi = 'https://wa.me/6281312547254?text=' . rawurlencode('Halo After Wear, saya lupa kata sandi akun saya.');
@endphp

<div class="au-login-wrap">
    <div class="au-card">
        <div class="au-left">
            <a class="au-back" href="{{ route('home') }}">Kembali ke Beranda</a>

            <a class="au-brand" href="{{ route('home') }}">
                <img src="{{ asset($logoFile) }}" alt="" onerror="this.remove()">
                <span><b>After Wear</b><small>Preloved Archive</small></span>
            </a>

            <h1>{{ $c['title'] }}</h1>
            <p class="au-sub">{{ $c['desc'] }}</p>

            @if (session('success'))
                <div class="au-alert is-ok" role="status">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="au-alert is-error" role="alert">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="au-alert is-error" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="POST">
                @csrf
                <input type="hidden" name="login_as" value="{{ $role }}">

                <label class="au-label" for="email">Alamat Email</label>
                <div class="au-field">
                    <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="{{ $c['ph'] }}" autocomplete="email">
                </div>

                <label class="au-label" for="password">Kata Sandi</label>
                <div class="au-field has-eye">
                    <input type="password" name="password" id="password" required placeholder="••••••••••••" autocomplete="current-password">
                    <button type="button" class="au-eye" id="togglePass" aria-label="Tampilkan atau sembunyikan kata sandi">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>

                <div class="au-row">
                    <label class="au-check"><input type="checkbox" name="remember" value="1"> Ingat saya</label>
                    <a class="au-link" href="{{ $lupaSandi }}" target="_blank" rel="noopener">Lupa Kata Sandi?</a>
                </div>

                <button type="submit" class="au-submit">
                    {{ $c['btn'] }}
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </button>
            </form>

            @if ($role === 'buyer')
                <p class="au-alt">Belum punya akun? <a class="au-strong" href="{{ route('register') }}">Daftar Sekarang</a></p>
                <p class="au-alt"><a class="au-plain" href="{{ route('login', ['as' => 'seller']) }}">Masuk sebagai penjual</a></p>
            @elseif ($role === 'seller')
                <p class="au-alt">Belum punya akun penjual? <a class="au-strong" href="{{ route('register', ['as' => 'seller']) }}">Daftar sebagai Penjual</a></p>
                <div class="au-note">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M2 7h20"/></svg>
                    <span>Masuk sebagai penjual terverifikasi untuk mengelola pengajuan produk dan dashboard toko Anda.</span>
                </div>
                <p class="au-alt"><a class="au-plain" href="{{ route('login') }}">Masuk sebagai pembeli</a></p>
            @else
                <p class="au-alt"><a class="au-plain" href="{{ route('login') }}">Masuk sebagai pembeli</a></p>
            @endif
        </div>

        <aside class="au-hero">
            @if ($bgFile)
                <div class="au-hero-img" style="background-image: url('{{ $bgFile }}')"></div>
            @endif
            <div class="au-hero-text">
                <i></i>
                <blockquote>“Memilih preloved adalah komitmen estetika dan keberlanjutan.”</blockquote>
                <hr>
            </div>
        </aside>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        var btn = document.getElementById('togglePass');
        var input = document.getElementById('password');
        if (!btn || !input) { return; }
        btn.addEventListener('click', function () {
            input.type = input.type === 'password' ? 'text' : 'password';
        });
    })();
</script>
@endpush
