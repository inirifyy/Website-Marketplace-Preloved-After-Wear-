{{--
    Gaya untuk halaman publik yang memakai kelas pendek:
    .nav .wrap .brand .search .acts .btn .hero .sec .grid .card .cta .layout .side
    .detail .gal .spec .note .rating .foot ...
    Sebelumnya kelas-kelas ini dipakai di layout, beranda, katalog, dan detail produk
    tetapi tidak didefinisikan di CSS mana pun. Semua aturan memakai :where() (specificity 0),
    jadi CSS buatan tim di resources/css/app.css tetap menang bila nanti menambahkannya.
--}}
<style>
    :where(.wrap) { width: 100%; max-width: 1200px; margin-inline: auto; padding-inline: 1rem; box-sizing: border-box; }
    @media (min-width: 768px) { :where(.wrap) { padding-inline: 2rem; } }
    :where(.mute) { color: var(--aw-gray-500, #6B6B6B); }
    :where(.small) { font-size: .85rem; }

    /* Navbar */
    :where(.nav) { background: #fff; border-bottom: 1px solid var(--aw-gray-200, #E7E7E5); position: sticky; top: 0; z-index: 50; }
    :where(.nav .wrap) { display: flex; align-items: center; gap: 1rem; min-height: 3.75rem; flex-wrap: wrap; padding-block: .5rem; }
    :where(.brand) { font-family: var(--aw-font-serif, Georgia, serif); font-size: 1.4rem; font-weight: 600; text-decoration: none; }
    :where(.nav .search) { flex: 1 1 200px; max-width: 320px; margin: 0; }
    :where(.nav .search input) { width: 100%; box-sizing: border-box; }
    :where(.nav ul) { display: flex; gap: 1.1rem; list-style: none; margin: 0; padding: 0; font-size: .85rem; font-weight: 500; }
    :where(.nav ul a) { text-decoration: none; color: var(--aw-gray-500, #6B6B6B); }
    :where(.nav ul a:hover, .nav ul a.on) { color: #111; }
    :where(.nav .acts) { margin-left: auto; display: flex; gap: .5rem; align-items: center; flex-wrap: wrap; }

    /* Tombol */
    :where(.btn) { display: inline-flex; align-items: center; justify-content: center; padding: .45rem .95rem; border-radius: 6px; border: 1px solid var(--aw-gray-200, #E7E7E5); background: #fff; color: #111; font: inherit; font-size: .85rem; font-weight: 500; text-decoration: none; cursor: pointer; box-sizing: border-box; }
    :where(.btn:hover) { background: #F7F7F6; }
    :where(.btn.dark) { background: #111; color: #fff; border-color: #111; }
    :where(.btn.dark:hover) { background: #2A2A2A; }
    :where(.btn.block) { display: flex; width: 100%; }

    /* Bagian halaman */
    :where(.sec) { padding-block: 3rem; }
    :where(.sec.white) { background: #fff; }
    :where(.sec h2, .detail h1) { margin: 0 0 1.25rem; }
    :where(.hero) { display: grid; gap: 2rem; padding-block: 3rem; align-items: center; }
    @media (min-width: 900px) { :where(.hero) { grid-template-columns: 1.1fr 1fr; } }
    :where(.hero h1) { font-size: clamp(2rem, 4vw, 3.2rem); margin: 0 0 1rem; }
    :where(.hero figure) { margin: 0; position: relative; }
    :where(.hero img) { width: 100%; border-radius: 10px; display: block; }
    :where(.hero figcaption) { position: absolute; left: 1rem; bottom: 1rem; background: #fff; padding: .6rem .9rem; border-radius: 8px; box-shadow: 0 4px 16px rgba(0,0,0,.1); }
    :where(.row) { display: flex; gap: .75rem; flex-wrap: wrap; margin-top: 1.25rem; }
    :where(.grid) { display: grid; gap: 1.25rem; }
    :where(.g2) { grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); }
    :where(.g3) { grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); }
    :where(.g4) { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); }
    :where(.cats a) { display: block; padding: 1rem; border: 1px solid var(--aw-gray-200, #E7E7E5); border-radius: 10px; background: #fff; text-decoration: none; }
    :where(.cats a b) { display: block; margin-bottom: .2rem; }
    :where(.card) { background: #fff; border: 1px solid var(--aw-gray-200, #E7E7E5); border-radius: 10px; padding: 1.1rem; }
    :where(.cta) { display: flex; gap: 1.5rem; align-items: center; justify-content: space-between; flex-wrap: wrap; background: #111; color: #fff; border-radius: 12px; padding: 2rem; }

    /* Katalog */
    :where(.layout) { display: grid; gap: 1.5rem; }
    @media (min-width: 900px) { :where(.layout) { grid-template-columns: 260px 1fr; } }
    :where(.side) { display: block; }
    :where(.side h4) { margin: 1.1rem 0 .4rem; font-size: .8rem; text-transform: uppercase; letter-spacing: .04em; color: var(--aw-gray-500, #6B6B6B); }
    :where(.side label) { display: flex; justify-content: space-between; gap: .5rem; padding: .2rem 0; font-size: .9rem; cursor: pointer; }
    :where(.side input[type=text], .side input[type=number]) { width: 100%; box-sizing: border-box; }
    :where(.chips) { display: flex; flex-wrap: wrap; gap: .5rem; align-items: center; margin-top: .75rem; }
    :where(.chip) { padding: .2rem .7rem; border-radius: 999px; background: #F1F1F0; font-size: .8rem; }
    :where(.pager) { margin-top: 1.5rem; }

    /* Detail produk */
    :where(.detail) { display: grid; gap: 2rem; padding-block: 1.5rem 2rem; }
    @media (min-width: 900px) { :where(.detail) { grid-template-columns: 1.1fr 1fr; } }
    :where(.gal .main img) { width: 100%; border-radius: 10px; display: block; aspect-ratio: 1/1; object-fit: cover; background: #F1F1F0; }
    :where(.thumbs) { display: grid; grid-template-columns: repeat(4, 1fr); gap: .5rem; margin-top: .5rem; }
    :where(.thumbs img) { width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 6px; }
    :where(.badge) { display: inline-block; padding: .15rem .6rem; border-radius: 999px; background: #EEF5F0; color: #2F6B45; font-size: .75rem; font-weight: 600; }
    :where(.badge.gray) { background: #F1F1F0; color: #444; }
    :where(.price) { font-size: 1.6rem; font-weight: 700; margin: .5rem 0 1rem; }
    :where(.spec) { width: 100%; border-collapse: collapse; font-size: .9rem; }
    :where(.spec td) { padding: .5rem 0; border-bottom: 1px solid var(--aw-gray-200, #E7E7E5); }
    :where(.spec td:first-child) { color: var(--aw-gray-500, #6B6B6B); width: 40%; }
    :where(.note) { background: #FFFBEB; border: 1px solid #FDE68A; border-radius: 8px; padding: .8rem 1rem; margin-top: 1rem; }
    :where(.seller) { margin-top: 1rem; }
    :where(.rating) { display: grid; gap: 1.5rem; }
    @media (min-width: 900px) { :where(.rating) { grid-template-columns: 1fr 1.5fr 1.5fr; } }
    :where(.rating .num) { font-size: 2.6rem; font-weight: 700; }
    :where(.bar) { display: grid; grid-template-columns: 2.2rem 1fr 2.6rem; gap: .5rem; align-items: center; font-size: .8rem; }
    :where(.bar i) { display: block; height: 6px; background: #E7E7E5; border-radius: 3px; overflow: hidden; }
    :where(.bar b) { display: block; height: 100%; background: #111; }

    /* Footer */
    :where(.foot) { margin-top: 3rem; padding-block: 2rem 1rem; background: #111; color: #F7F7F6; }
    :where(.foot .wrap) { display: flex; flex-wrap: wrap; gap: 2rem; justify-content: space-between; }
    :where(.foot .brand) { color: #fff; }
    :where(.foot .mute) { color: #B5B5B2; }
    :where(.foot .copy) { margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,.15); font-size: .8rem; color: #B5B5B2; }
    :where(.foot a) { color: inherit; }
</style>
