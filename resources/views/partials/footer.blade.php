{{--
    Footer situs. Sudah dipanggil otomatis oleh layouts/app.blade.php,
    jadi JANGAN di-@include lagi di halaman lain.
    <style> ditaruh langsung di sini karena @push('styles') dari partial
    yang di-include layout tidak akan tampil (stack 'styles' sudah dicetak di <head>).
--}}
<style>
    .aw-footer { flex-shrink: 0; margin-top: 3rem; padding-block: 2rem 1.25rem; background: var(--aw-charcoal, #30332F); color: var(--aw-cream, #F3EFE6); font-size: .95rem; }
    .aw-footer a { color: inherit; text-underline-offset: 3px; }
    .aw-footer a:hover { color: #fff; }
    .aw-footer a:focus-visible { outline: 3px solid var(--aw-cream, #F3EFE6); outline-offset: 2px; }
    .aw-footer__grid { display: grid; gap: 1.5rem; grid-template-columns: 1fr; }
    @media (min-width: 768px) { .aw-footer__grid { grid-template-columns: 1.6fr 1fr 1fr; } }
    .aw-footer h2 { margin: 0 0 .6rem; font-size: 1rem; }
    .aw-footer p { margin: 0 0 .5rem; max-width: 36ch; }
    .aw-footer ul { margin: 0; padding: 0; list-style: none; }
    .aw-footer li { margin-bottom: .35rem; }
    .aw-footer__bottom { margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid rgba(243, 239, 230, .25); font-size: .85rem; }
</style>

<footer class="aw-footer">
    <div class="aw-container">
        <div class="aw-footer__grid">
            <div>
                <h2>After Wear</h2>
                <p>Marketplace pakaian preloved layak pakai. Beri pakaian kesempatan kedua dan kurangi limbah tekstil.</p>
            </div>

            <nav aria-label="Tautan footer">
                <h2>Jelajahi</h2>
                <ul>
                    <li><a href="{{ route('products.index') }}">Katalog produk</a></li>
                    <li><a href="{{ route('education') }}">Edukasi fashion berkelanjutan</a></li>
                    <li><a href="{{ route('testimonials') }}">Testimoni</a></li>
                    <li><a href="{{ route('about') }}">Tentang kami</a></li>
                </ul>
            </nav>

            <div>
                <h2>Kontak</h2>
                {{-- TODO tim: ganti dengan email dan nomor resmi After Wear --}}
                <ul>
                    <li><a href="mailto:halo@afterwear.test">halo@afterwear.test</a></li>
                    <li><a href="https://wa.me/6281234567890" rel="noopener">WhatsApp: 0812-3456-7890</a></li>
                </ul>
            </div>
        </div>

        <div class="aw-footer__bottom">
            &copy; {{ date('Y') }} After Wear. Dibuat oleh Kelompok 4.
        </div>
    </div>
</footer>