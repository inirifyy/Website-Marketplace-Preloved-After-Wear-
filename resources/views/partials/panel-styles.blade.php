{{--
    Gaya khusus halaman dashboard, profil, dan moderasi ulasan.
    Dipakai lewat:  @push('styles') @include('partials.panel-styles') @endpush
    Memakai variabel warna dari layouts/app.blade.php.
--}}
<style>
    .aw-panel { --aw-sage-dark: #566B52; --aw-line: rgba(48, 51, 47, .14); padding-block: 1.5rem 3rem; }
    .aw-panel h1 { margin: 0 0 .25rem; font-size: 1.75rem; line-height: 1.2; }
    .aw-panel h2 { margin: 2rem 0 .75rem; font-size: 1.2rem; }
    .aw-panel__lead { margin: 0; color: rgba(48, 51, 47, .75); }
    .aw-panel__head { display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end; justify-content: space-between; margin-bottom: 1.5rem; }
    .aw-panel__actions { display: flex; flex-wrap: wrap; gap: .5rem; }
    .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0; }

    /* Tombol */
    .aw-btn { display: inline-block; padding: .55rem 1rem; border: 1px solid var(--aw-charcoal); border-radius: .5rem; background: transparent; color: var(--aw-charcoal); font: inherit; font-size: .95rem; text-decoration: none; cursor: pointer; }
    .aw-btn:hover { background: rgba(48, 51, 47, .07); }
    .aw-btn--primary { background: var(--aw-sage-dark); border-color: var(--aw-sage-dark); color: var(--aw-white); }
    .aw-btn--primary:hover { background: #46593F; }
    .aw-btn--danger { border-color: #991b1b; color: #991b1b; }
    .aw-btn--danger:hover { background: #fef2f2; }
    .aw-btn--small { padding: .3rem .65rem; font-size: .85rem; }
    .aw-panel a:focus-visible, .aw-panel button:focus-visible, .aw-panel input:focus-visible,
    .aw-panel select:focus-visible, .aw-panel textarea:focus-visible { outline: 3px solid var(--aw-sage-dark); outline-offset: 2px; }

    /* Ringkasan angka */
    .aw-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: .75rem; }
    .aw-stat { display: block; padding: .9rem 1rem; background: var(--aw-white); border: 1px solid var(--aw-line); border-left: 4px solid var(--aw-sage); border-radius: .5rem; color: inherit; text-decoration: none; }
    a.aw-stat:hover { border-color: var(--aw-sage-dark); }
    .aw-stat__num { display: block; font-size: 1.9rem; font-weight: 600; line-height: 1.1; }
    .aw-stat__label { display: block; margin-top: .2rem; font-size: .9rem; color: rgba(48, 51, 47, .8); }

    /* Tabel */
    .aw-table-wrap { overflow-x: auto; background: var(--aw-white); border: 1px solid var(--aw-line); border-radius: .5rem; }
    .aw-table { width: 100%; border-collapse: collapse; font-size: .92rem; }
    .aw-table th, .aw-table td { padding: .7rem .85rem; text-align: left; vertical-align: top; border-bottom: 1px solid var(--aw-line); }
    .aw-table th { font-weight: 600; white-space: nowrap; background: rgba(125, 146, 120, .12); }
    .aw-table tr:last-child td { border-bottom: 0; }
    .aw-table__comment { min-width: 14rem; max-width: 28rem; white-space: pre-line; overflow-wrap: anywhere; }
    .aw-muted { color: rgba(48, 51, 47, .7); }
    .aw-thumb { width: 52px; height: 52px; object-fit: cover; border-radius: .4rem; background: var(--aw-cream); }
    .aw-thumb--empty { display: inline-flex; align-items: center; justify-content: center; width: 52px; height: 52px; border-radius: .4rem; background: var(--aw-cream); font-size: .65rem; text-align: center; color: rgba(48, 51, 47, .7); }
    .aw-empty { padding: 1.5rem 1rem; text-align: center; background: var(--aw-white); border: 1px dashed var(--aw-line); border-radius: .5rem; }

    /* Status (selalu ada teks, tidak hanya warna) */
    .aw-badge { display: inline-block; padding: .15rem .6rem; border-radius: 999px; font-size: .8rem; font-weight: 600; white-space: nowrap; }
    .aw-badge--pending  { background: #fdf3d8; color: #6b4e00; }
    .aw-badge--approved { background: #e3ecdf; color: #2f4a2b; }
    .aw-badge--rejected { background: #fbe4e2; color: #8a1f17; }
    .aw-badge--role     { background: var(--aw-cream); color: var(--aw-charcoal); border: 1px solid var(--aw-line); }

    /* Filter */
    .aw-filter { display: flex; flex-wrap: wrap; gap: .75rem; align-items: flex-end; margin-bottom: 1rem; }
    .aw-filter label { display: block; margin-bottom: .2rem; font-size: .85rem; font-weight: 600; }

    /* Form */
    .aw-field { margin-bottom: 1rem; }
    .aw-field label { display: block; margin-bottom: .25rem; font-weight: 600; }
    .aw-field__hint { margin: .25rem 0 0; font-size: .85rem; color: rgba(48, 51, 47, .7); }
    .aw-field__error { margin: .25rem 0 0; font-size: .85rem; color: #991b1b; }
    .aw-input { width: 100%; max-width: 32rem; padding: .55rem .7rem; border: 1px solid rgba(48, 51, 47, .4); border-radius: .5rem; background: var(--aw-white); color: var(--aw-charcoal); font: inherit; }
    .aw-input[aria-invalid="true"] { border-color: #991b1b; }
    textarea.aw-input { min-height: 6rem; resize: vertical; }
    .aw-form { max-width: 40rem; padding: 1.25rem; background: var(--aw-white); border: 1px solid var(--aw-line); border-radius: .5rem; }
    .aw-form fieldset { margin: 1.5rem 0 1rem; padding: 1rem 0 0; border: 0; border-top: 1px solid var(--aw-line); }
    .aw-form legend { padding: 0; font-weight: 600; }

    /* Profil */
    .aw-profile { display: grid; gap: 1rem; padding: 1.25rem; background: var(--aw-white); border: 1px solid var(--aw-line); border-radius: .5rem; }
    .aw-profile__who { display: flex; align-items: center; gap: 1rem; }
    .aw-avatar { flex: none; display: grid; place-items: center; width: 3.5rem; height: 3.5rem; border-radius: 50%; background: var(--aw-sage-dark); color: var(--aw-white); font-size: 1.4rem; font-weight: 600; }
    .aw-profile dl { display: grid; grid-template-columns: 9rem 1fr; gap: .5rem 1rem; margin: 0; }
    .aw-profile dt { font-weight: 600; }
    .aw-profile dd { margin: 0; overflow-wrap: anywhere; white-space: pre-line; }
    @media (max-width: 520px) { .aw-profile dl { grid-template-columns: 1fr; gap: 0; } .aw-profile dd { margin-bottom: .6rem; } }

    .aw-review-list { display: grid; gap: .75rem; margin: 0; padding: 0; list-style: none; }
    .aw-review-item { padding: .9rem 1rem; background: var(--aw-white); border: 1px solid var(--aw-line); border-radius: .5rem; }
    .aw-review-item p { margin: .35rem 0 0; white-space: pre-line; overflow-wrap: anywhere; }
    .aw-stars { letter-spacing: .1em; color: #7a5a00; white-space: nowrap; }

    /* Pagination sederhana */
    .aw-pager { display: flex; flex-wrap: wrap; gap: .75rem; align-items: center; justify-content: space-between; margin-top: 1rem; }
</style>