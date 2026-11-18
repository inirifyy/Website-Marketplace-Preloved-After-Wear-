<style>
    .aw-nav { background: #FFFFFF; border-bottom: 1px solid #E2E8F0; position: sticky; top: 0; z-index: 50; }
    .aw-nav__inner { display: flex; align-items: center; justify-content: space-between; height: 4.5rem; gap: 1rem; }
    .aw-nav__brand { display: flex; align-items: center; gap: 0.5rem; text-decoration: none; font-size: 1.35rem; font-weight: 800; color: #1E293B; }
    .aw-nav__brand span { color: #059669; }
    .aw-nav__menu { display: none; align-items: center; gap: 1.25rem; font-size: 0.9rem; font-weight: 600; }
    @media (min-width: 768px) { .aw-nav__menu { display: flex; } }
    .aw-nav__menu a { text-decoration: none; color: #475569; transition: color 0.15s; }
    .aw-nav__menu a:hover { color: #059669; }
    .aw-nav__actions { display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem; }
    .aw-btn { display: inline-flex; align-items: center; justify-content: center; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none; transition: 0.15s; cursor: pointer; border: none; }
    .aw-btn-primary { background: #059669; color: #FFFFFF; }
    .aw-btn-primary:hover { background: #047857; color: #FFFFFF; }
    .aw-btn-outline { border: 1px solid #CBD5E1; color: #334155; background: transparent; }
    .aw-btn-outline:hover { background: #F8FAFC; }
    .aw-btn-seller { background: #F59E0B; color: #FFFFFF; }
    .aw-btn-seller:hover { background: #D97706; }
</style>

<header class="aw-nav">
    <div class="aw-container">
        <div class="aw-nav__inner">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="aw-nav__brand">
                <span style="display:inline-block; width:1.75rem; height:1.75rem; background:#059669; border-radius:0.4rem; color:#fff; text-align:center; line-height:1.75rem; font-size:1rem;">♻</span>
                After<span>Wear</span>
            </a>

            <!-- Nav Links -->
            <nav class="aw-nav__menu" aria-label="Navigasi Utama">
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('products.index') }}">Katalog Produk</a>
                <a href="{{ route('education') }}">Edukasi</a>
                <a href="{{ route('testimonials') }}">Testimoni</a>
                <a href="{{ route('about') }}">Tentang Kami</a>
            </nav>

            <!-- Actions / Auth -->
            <div class="aw-nav__actions">
                @guest
                    <a href="{{ route('login') }}" class="aw-btn aw-btn-outline">Masuk</a>
                    <a href="{{ route('register') }}" class="aw-btn aw-btn-primary">Daftar</a>
                @else
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.categories.index') }}" class="aw-btn aw-btn-outline" style="border-color:#F59E0B; color:#B45309;">
                            Kelola Kategori
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="aw-btn aw-btn-outline" style="border-color:#F59E0B; color:#B45309;">
                            Dashboard Admin
                        </a>
                    @elseif(Auth::user()->isSeller())
                        <a href="{{ route('seller.submissions.create') }}" class="aw-btn aw-btn-seller">
                            + Jual Pakaian
                        </a>
                        <a href="{{ route('seller.dashboard') }}" class="aw-btn aw-btn-outline">
                            Toko Saya
                        </a>
                    @else
                        <a href="{{ route('profile.show') }}" class="aw-btn aw-btn-outline">
                            Akun Saya
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" style="display:inline; margin:0;">
                        @csrf
                        <button type="submit" class="aw-btn" style="color:#DC2626; background:transparent; padding:0.5rem 0.75rem;">
                            Keluar
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</header>
