{{-- Gaya global sesuai desain Figma: font, navbar, tombol, footer.
     Di-include layouts/app.blade.php SETELAH page-styles, jadi menang atas gaya lama. --}}
<style>
    :root {
        --aw-font-sans: 'Plus Jakarta Sans', 'Inter', ui-sans-serif, system-ui, sans-serif;
        --aw-font-serif: 'EB Garamond', 'Cormorant Garamond', Georgia, serif;
        --af-line: #E8E8E6;
        --af-soft: #F7F7F6;
        --af-muted: #666666;
        --af-green-bg: #E8F3EC;
        --af-green-ink: #1F7A4D;
        --af-wa: #0F9D6B;
    }

    /* ---------- Tombol ---------- */
    .btn { display: inline-flex; align-items: center; justify-content: center; gap: .4rem; height: 2.4rem; padding: 0 1.1rem; border-radius: 8px; border: 1px solid #111; background: #fff; color: #111; font: inherit; font-size: .85rem; font-weight: 500; text-decoration: none; cursor: pointer; box-sizing: border-box; }
    .btn:hover { background: #F7F7F6; }
    .btn.dark { background: #111; color: #fff; border-color: #111; }
    .btn.dark:hover { background: #2A2A2A; }
    .btn.warn { border-color: #F59E0B; color: #B45309; }
    .btn-text { background: none; border: 0; font: inherit; font-size: .85rem; color: var(--af-muted); cursor: pointer; padding: 0 .4rem; }
    .btn-text:hover { color: #111; }

    /* ---------- Navbar ---------- */
    .nav { background: #fff; border-bottom: 1px solid var(--af-line); position: sticky; top: 0; z-index: 50; }
    .nav .wrap { display: flex; align-items: center; gap: 1.5rem; min-height: 4.25rem; padding-block: .5rem; flex-wrap: nowrap; }
    .brand { display: inline-flex; align-items: center; gap: .6rem; font-family: var(--aw-font-serif); font-size: 1.5rem; font-weight: 500; color: #111; text-decoration: none; white-space: nowrap; }
    .brand img { width: 30px; height: 30px; object-fit: contain; }
    .nav .search { position: relative; flex: 0 1 340px; max-width: none; margin: 0; }
    .nav .search svg { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: #888; pointer-events: none; }
    .nav .search input { width: 100%; height: 2.4rem; padding: 0 .9rem 0 2.4rem; background: #fff; border: 1px solid #DADAD8; border-radius: 8px; font-size: .85rem; box-sizing: border-box; }
    .nav ul { display: flex; align-items: center; gap: 1.5rem; list-style: none; margin: 0; padding: 0; }
    .nav ul a { font-size: .85rem; color: var(--af-muted); text-decoration: none; white-space: nowrap; }
    .nav ul a:hover { color: #111; }
    .nav ul a.on { color: #111; font-weight: 600; font-size: .95rem; }
    .nav .acts { margin-left: auto; display: flex; align-items: center; gap: .6rem; }
    .nav .sep { width: 1px; height: 1.6rem; background: var(--af-line); margin-inline: .25rem; }
    .avatar { width: 2.1rem; height: 2.1rem; border-radius: 50%; background: #111; color: #fff; display: grid; place-items: center; font-size: .85rem; font-weight: 600; text-decoration: none; }
    @media (max-width: 1000px) {
        .nav .wrap { flex-wrap: wrap; gap: .6rem 1rem; }
        .nav .search { order: 3; flex: 1 1 100%; }
        .nav ul { order: 4; width: 100%; overflow-x: auto; gap: 1.1rem; padding-bottom: .25rem; }
    }

    /* ---------- Footer ---------- */
    .foot { margin-top: 3rem; padding: 3rem 0 0; background: #FAFAFA; color: #111; border-top: 1px solid var(--af-line); }
    .foot .foot-grid { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 2rem; align-items: flex-start; }
    .foot .brand { color: #111; }
    .foot .foot-brand { max-width: 420px; }
    .foot .foot-brand p { margin: .9rem 0 0; color: var(--af-muted); font-size: .9rem; line-height: 1.7; }
    .foot .foot-brand p.foot-note { color: #111; font-size: .8rem; line-height: 1.5; max-width: 330px; }
    .foot h3 { margin: 0 0 .9rem; font-size: .8rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; }
    .foot .foot-contact p { display: flex; align-items: flex-start; gap: .6rem; margin: 0 0 .7rem; color: var(--af-muted); font-size: .9rem; }
    .foot .foot-contact svg { flex: none; margin-top: .2rem; color: var(--af-muted); }
    .foot .copy { margin-top: 3rem; padding-block: 1.5rem; border-top: 1px solid var(--af-line); display: flex; flex-wrap: wrap; justify-content: space-between; gap: .5rem; font-size: .8rem; color: var(--af-muted); }
    .foot .copy a { color: inherit; }
    .foot .copy a:hover { color: #111; }

        /* ---------- Beranda: kategori & keunggulan ---------- */
    .cat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; }
    .cat-card { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .25rem; padding: 1.4rem 1rem; background: #F7F7F6; border-radius: 10px; text-decoration: none; text-align: center; color: #111; transition: background .15s; }
    .cat-card:hover { background: #EFEFED; }
    .cat-ico { width: 2.6rem; height: 2.6rem; border-radius: 50%; background: #fff; display: grid; place-items: center; margin-bottom: .5rem; color: #111; }
    .cat-card b { font-size: .8rem; font-weight: 600; }
    .cat-card span.small { font-size: .72rem; color: var(--af-muted); }

    .why-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; }
    .why-card { background: #fff; border: 1px solid var(--af-line); border-radius: 10px; padding: 1.4rem; display: flex; flex-direction: column; }
    .why-ico { width: 2.6rem; height: 2.6rem; border-radius: 8px; background: #F1F1F0; display: grid; place-items: center; margin-bottom: 1.25rem; color: #111; }
    .why-card h3 { font-family: var(--aw-font-serif); font-size: 1.15rem; font-weight: 500; margin: 0 0 .6rem; }
    .why-card p { margin: 0; font-size: .8rem; line-height: 1.7; color: var(--af-muted); }

    @media (max-width: 1000px) { .why-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px) { .cat-grid { grid-template-columns: repeat(2, 1fr); } .why-grid { grid-template-columns: 1fr; } }

        /* ---------- Halaman artikel edukasi ---------- */
    .back-link { font-size: .78rem; color: var(--af-muted); text-decoration: none; }
    .back-link:hover { color: #111; }
    .art { max-width: 960px; margin: 0 auto; padding-bottom: 1rem; }
    .art h1 { text-align: center; font-size: clamp(1.9rem, 4vw, 2.6rem); max-width: 760px; margin: 1.5rem auto 1rem; }

    .art .meta { display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: .4rem 0; font-size: .75rem; color: var(--af-muted); margin-bottom: 1.5rem; }
    .art .meta span { display: inline-flex; align-items: center; }
    .art .meta span + span::before { content: "•"; margin-inline: .7rem; color: #BDBDBA; }
    .meta-author { color: #111; font-weight: 500; }
    .meta-avatar { width: 1.5rem; height: 1.5rem; border-radius: 50%; background: #111; color: #fff; font-style: normal; font-size: .6rem; font-weight: 600; display: inline-grid; place-items: center; margin-right: .5rem; }

    .art .cover img { width: 100%; height: clamp(220px, 40vw, 400px); object-fit: cover; border-radius: 12px; display: block; }

    .art .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin: 1rem 0 2.5rem; padding: 1rem 1.25rem; background: #F7F7F6; border-radius: 12px; }
    .art .stat { display: flex; align-items: center; gap: .85rem; }
    .art .stat-ico { flex: none; width: 2.4rem; height: 2.4rem; border-radius: 50%; background: #fff; color: #111; display: grid; place-items: center; }
    .art .stat-label { display: block; font-size: .62rem; letter-spacing: .06em; text-transform: uppercase; color: var(--af-muted); }
    .art .stat b { display: block; font-size: 1.05rem; line-height: 1.3; }
    .art .stat-note { display: block; font-size: .7rem; color: var(--af-muted); line-height: 1.4; }
    @media (max-width: 760px) { .art .stats { grid-template-columns: 1fr; } }

    .art > p, .art > h2, .art > blockquote, .art > .steps { max-width: 720px; margin-inline: auto; }
    .art > p { font-size: .95rem; line-height: 1.85; color: #333; margin-block: 0 1.25rem; }
    .art > h2 { font-size: 1.55rem; margin-block: 2.5rem 1rem; }
    .art blockquote { margin-block: 1.75rem; padding: 1.4rem 1.6rem; background: #F1F1F0; border-radius: 10px; font-family: var(--aw-font-serif); font-style: italic; font-size: 1.15rem; line-height: 1.6; }
    .art blockquote cite { display: block; margin-top: .6rem; font-family: var(--aw-font-sans); font-style: normal; font-size: .72rem; color: var(--af-muted); }
    .art .steps { margin-block: 2rem; padding: 1.5rem 1.75rem; background: #F7F7F6; border-radius: 12px; }
    .art .steps h3 { font-family: var(--aw-font-serif); font-size: 1.3rem; font-weight: 500; margin: 0 0 1rem; }
    .art .steps ol { margin: 0; padding-left: 1.25rem; }
    .art .steps li { font-size: .88rem; line-height: 1.7; color: var(--af-muted); margin-bottom: .75rem; }
    .art .steps li b { color: #111; display: block; }
    .art .tags { font-size: .78rem; color: var(--af-muted); }
    .author-box { max-width: 720px; margin: 2rem auto 0; padding: 1.4rem 1.6rem; border: 1px solid var(--af-line); border-radius: 12px; }
    .author-box b { font-family: var(--aw-font-serif); font-size: 1.15rem; font-weight: 500; }
    .author-box p { margin: .4rem 0 0; font-size: .82rem; color: var(--af-muted); line-height: 1.6; }

        /* ---------- Teks tombol selalu di tengah (login, registrasi, form lain) ---------- */
    .aw-btn,
    form button[type="submit"],
    form input[type="submit"] { justify-content: center; text-align: center; }

        /* ---------- Kartu produk ---------- */
    .grid.g3 { grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
    @media (max-width: 900px) { .grid.g3 { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 520px) { .grid.g3 { grid-template-columns: 1fr; } }

    .pc { display: block; color: #111; text-decoration: none; }
    .pc-img { position: relative; aspect-ratio: 1 / 1.05; background: #F1F1F0; border-radius: 8px; overflow: hidden; }
    .pc-img img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .3s; }
    .pc:hover .pc-img img { transform: scale(1.03); }
    .pc-img.is-sold img { opacity: .55; }
    .pc-badge { position: absolute; top: .7rem; left: .7rem; padding: .25rem .55rem; border-radius: 5px; background: #fff; color: #444; font-size: .62rem; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; }
    .pc-badge.is-new { background: var(--af-green-bg); color: var(--af-green-ink); }
    .pc-sold { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: .45rem .9rem; border-radius: 8px; background: #FFF1F1; color: #B42318; font-size: .7rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; white-space: nowrap; }
    .pc-body { padding: .85rem .15rem 0; }
    .pc-meta { display: flex; justify-content: space-between; gap: .5rem; font-size: .72rem; color: var(--af-muted); }
    .pc-name { margin: .35rem 0 .25rem; font-size: .92rem; font-weight: 500; line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .pc-price { font-size: 1rem; font-weight: 700; }
    .pc-price.is-sold { color: #9A9A98; font-weight: 500; text-decoration: line-through; }
    .pc-loc { display: flex; align-items: center; gap: .3rem; margin-top: .6rem; font-size: .72rem; color: var(--af-muted); }

        /* ---------- Katalog ---------- */
    .kt-top { padding-top: 1.5rem; }
    .kt-crumb { display: flex; flex-wrap: wrap; gap: .5rem; font-size: .78rem; color: var(--af-muted); }
    .kt-crumb a { color: inherit; text-decoration: none; }
    .kt-crumb a:hover { color: #111; }
    .kt-crumb b { color: #111; font-weight: 600; }
    .kt-title { margin: .6rem 0 1.25rem; font-size: clamp(1.7rem, 3.5vw, 2.4rem); }
    .kt-title small { font-family: var(--aw-font-sans); font-size: .85rem; font-weight: 400; color: var(--af-muted); margin-left: .35rem; }

    .kt-bar { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: .75rem 1rem; padding: .9rem 1.25rem; background: #F7F7F6; border-radius: 12px; }
    .kt-bar-left { display: flex; flex-wrap: wrap; align-items: center; gap: .5rem; }
    .kt-bar-label { font-size: .78rem; color: var(--af-muted); }
    .kt-chip { display: inline-flex; align-items: center; gap: .4rem; padding: .35rem .7rem; background: #fff; border-radius: 6px; font-size: .78rem; color: #111; text-decoration: none; }
    .kt-chip:hover { background: #F1F1F0; }
    .kt-clear { font-size: .78rem; color: var(--af-muted); text-decoration: underline; margin-left: .25rem; }
    .kt-sort { display: flex; align-items: center; gap: .6rem; margin: 0; font-size: .78rem; color: var(--af-muted); }
    .kt-sort select { height: 2.3rem; padding: 0 2rem 0 .8rem; background-color: #fff; border: 0; border-radius: 6px; font-size: .85rem; font-weight: 500; color: #111; cursor: pointer; }

    .kt-layout { display: grid; grid-template-columns: 1fr; gap: 1.75rem; margin-top: 1.5rem; align-items: start; }
    @media (min-width: 900px) { .kt-layout { grid-template-columns: 280px 1fr; } }

    .kt-side { background: #F7F7F6; border-radius: 12px; padding: 1.4rem 1.25rem; }
    .kt-side-head { display: flex; align-items: center; justify-content: space-between; gap: .5rem; margin-bottom: 1.25rem; }
    .kt-side-head h2 { display: flex; align-items: center; gap: .5rem; margin: 0; font-size: 1.25rem; }
    .kt-count { padding: .25rem .5rem; background: #E8E8E6; border-radius: 5px; font-size: .6rem; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; color: var(--af-muted); }
    .kt-group { margin-bottom: 1.5rem; }
    .kt-group-title { display: flex; align-items: baseline; justify-content: space-between; gap: .5rem; margin-bottom: .7rem; font-size: .85rem; }
    .kt-group-title span { font-size: .68rem; color: var(--af-muted); }
    .kt-opt { display: flex; align-items: center; justify-content: space-between; padding: .3rem 0; font-size: .88rem; color: var(--af-muted); cursor: pointer; }
    .kt-opt input { accent-color: #111; margin-right: .5rem; }
    .kt-opt em { font-style: normal; font-size: .78rem; }
    .kt-opt:hover { color: #111; }
    .kt-field { position: relative; }
    .kt-field input { width: 100%; height: 2.5rem; padding: 0 2.2rem 0 .8rem; background: #fff; border: 0; border-radius: 8px; font-size: .85rem; }
    .kt-field svg { position: absolute; right: .8rem; top: 50%; transform: translateY(-50%); color: #888; pointer-events: none; }
    .kt-price { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem; }
    .kt-price label { display: block; font-size: .6rem; letter-spacing: .05em; color: var(--af-muted); }
    .kt-price input { width: 100%; height: 2.5rem; margin-top: .3rem; padding: 0 .7rem; background: #fff; border: 0; border-radius: 8px; font-size: .85rem; }
    .kt-apply { margin-top: .75rem; height: 2.5rem; }
    .kt-cond { display: flex; align-items: flex-start; gap: .6rem; padding: .4rem 0; cursor: pointer; }
    .kt-cond input { accent-color: #111; margin-top: .25rem; }
    .kt-cond b { display: flex; align-items: center; gap: .4rem; font-size: .85rem; font-weight: 500; }
    .kt-cond b i { width: .5rem; height: .5rem; border-radius: 50%; display: inline-block; }
    .kt-cond small { display: block; margin-top: .15rem; font-size: .7rem; line-height: 1.45; color: var(--af-muted); }
    .kt-impact { padding: 1rem; background: #fff; border-radius: 10px; }
    .kt-impact b { display: flex; align-items: center; gap: .4rem; font-size: .62rem; letter-spacing: .05em; text-transform: uppercase; }
    .kt-impact p { margin: .5rem 0 0; font-size: .8rem; line-height: 1.55; color: var(--af-muted); }
    .kt-empty { grid-column: 1 / -1; padding: 2rem 0; }

    .kt-pager { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-top: 2.5rem; }
    .kt-pages { display: flex; align-items: center; gap: .4rem; }
    .kt-pg { width: 2.4rem; height: 2.4rem; border-radius: 50%; display: grid; place-items: center; background: #F1F1F0; color: #111; font-size: .85rem; text-decoration: none; }
    .kt-pg:hover { background: #E7E7E5; }
    .kt-pg.is-on { background: #111; color: #fff; font-weight: 600; }
    .kt-dots { color: var(--af-muted); padding: 0 .2rem; }
    .kt-pg-nav { padding: .6rem 1rem; background: #F1F1F0; border-radius: 8px; font-size: .85rem; font-weight: 500; color: #111; text-decoration: none; white-space: nowrap; }
    .kt-pg-nav:hover { background: #E7E7E5; }
    .kt-pg-nav.is-off { opacity: .45; pointer-events: none; }
    @media (max-width: 560px) { .kt-pager { flex-wrap: wrap; justify-content: center; } }
</style> 