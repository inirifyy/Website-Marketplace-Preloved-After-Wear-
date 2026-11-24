{{-- Gaya khusus halaman login (Screen 6 dan 9) dan registrasi (Screen 7). Dipakai oleh layouts/auth.blade.php. --}}
<style>
    :root {
        --au-line: #E8E8E6;
        --au-muted: #666666;
        --au-soft: #F7F7F6;
        --au-input: #F2F2F2;
        --au-serif: 'EB Garamond', Georgia, 'Times New Roman', serif;
    }
    *, *::before, *::after { box-sizing: border-box; }
    .au-body { margin: 0; min-height: 100vh; font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif; font-size: 14px; line-height: 1.55; color: #111; background: #fff; -webkit-font-smoothing: antialiased; }
    :where(.au-body a) { color: inherit; }
    :where(.au-body h1, .au-body h2, .au-body h3) { margin: 0; font-family: var(--au-serif); font-weight: 500; letter-spacing: -.01em; line-height: 1.15; }
    :where(.au-body p) { margin: 0; }

    /* ---------- Pesan ---------- */
    .au-alert { margin-bottom: 1rem; padding: .7rem .9rem; border-radius: 8px; font-size: .8rem; line-height: 1.5; }
    .au-alert ul { margin: .25rem 0 0; padding-left: 1.1rem; }
    .au-alert.is-error { background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; }
    .au-alert.is-ok { background: #EEF5F0; color: #2F6B45; border: 1px solid #CFE3D5; }

    /* ---------- Login ---------- */
    .au-login-wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2.5rem 1.25rem; }
    .au-card { width: 100%; max-width: 1150px; min-height: 640px; display: grid; grid-template-columns: 1fr 1fr; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 24px 64px rgba(0, 0, 0, .12), 0 2px 8px rgba(0, 0, 0, .05); }
    .au-left { padding: 2.5rem 4rem 3rem; display: flex; flex-direction: column; justify-content: center; }
    .au-back { display: inline-block; align-self: flex-start; margin-bottom: 1.5rem; font-size: .6rem; letter-spacing: .1em; text-transform: uppercase; color: var(--au-muted); text-decoration: none; }
    .au-back:hover { color: #111; }
    .au-brand { display: flex; align-items: center; gap: .75rem; margin-bottom: 2.25rem; text-decoration: none; }
    .au-brand img { width: 2.4rem; height: 2.4rem; object-fit: contain; }
    .au-brand b { display: block; font-family: var(--au-serif); font-size: 1.25rem; font-weight: 600; letter-spacing: .02em; line-height: 1.1; text-transform: uppercase; }
    .au-brand small { display: block; font-size: .6rem; letter-spacing: .12em; text-transform: uppercase; color: var(--au-muted); }
    .au-left h1 { font-size: 2rem; margin-bottom: .6rem; }
    .au-left .au-sub { color: var(--au-muted); font-size: .85rem; line-height: 1.6; margin-bottom: 1.5rem; max-width: 26rem; }

    .au-label { display: block; margin: 1.1rem 0 .4rem; font-size: .66rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; }
    .au-field { position: relative; }
    .au-field input { width: 100%; height: 3rem; padding: 0 1rem; background: var(--au-input); border: 1px solid transparent; border-radius: 8px; font: inherit; font-size: .9rem; color: #111; }
    .au-field input::placeholder { color: #8A8A88; }
    .au-field input:focus { outline: none; border-color: #111; background: #fff; }
    .au-field .au-eye { position: absolute; right: .5rem; top: 50%; transform: translateY(-50%); width: 2.2rem; height: 2.2rem; display: grid; place-items: center; border: 0; background: transparent; color: #555; cursor: pointer; border-radius: 6px; }
    .au-field .au-eye:hover { color: #111; background: #E8E8E6; }
    .au-field.has-eye input { padding-right: 3rem; }

    .au-row { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin: 1.1rem 0 1.25rem; font-size: .8rem; }
    .au-check { display: inline-flex; align-items: center; gap: .5rem; color: var(--au-muted); cursor: pointer; }
    .au-check input { width: 1rem; height: 1rem; accent-color: #111; margin: 0; }
    .au-link { text-decoration: underline; text-underline-offset: 3px; }
    .au-submit { width: 100%; height: 3rem; display: flex; align-items: center; justify-content: center; gap: .5rem; border: 0; border-radius: 8px; background: #111; color: #fff; font: inherit; font-size: .75rem; font-weight: 600; letter-spacing: .08em; cursor: pointer; text-transform: uppercase; }
    .au-submit:hover { background: #2A2A2A; }
    .au-left .au-alt { margin-top: 1.5rem; text-align: center; font-size: .82rem; color: var(--au-muted); }
    .au-alt b, .au-alt a.au-strong { color: #111; font-weight: 600; text-decoration: none; }
    .au-alt a.au-strong:hover { text-decoration: underline; }
    .au-left .au-alt + .au-alt { margin-top: 1rem; }
    .au-alt a.au-plain { color: #444; font-weight: 500; text-decoration: none; }
    .au-alt a.au-plain:hover { color: #111; text-decoration: underline; }
    .au-note { display: flex; align-items: flex-start; gap: .75rem; margin-top: 1.5rem; padding: 1rem 1.1rem; background: var(--au-input); border-radius: 8px; font-size: .78rem; line-height: 1.55; color: #444; }
    .au-note svg { flex: none; margin-top: .1rem; color: #555; }

    .au-hero { position: relative; display: flex; align-items: center; padding: 3rem; background: #1b1b1b; color: #fff; overflow: hidden; }
    .au-hero-img { position: absolute; inset: 0; background-size: cover; background-position: center; filter: grayscale(1); }
    .au-hero::before { content: ""; position: absolute; inset: 0; z-index: 1; background: linear-gradient(to bottom, rgba(0, 0, 0, .18), rgba(0, 0, 0, .62)); }
    .au-hero .au-hero-text { position: relative; z-index: 2; width: 100%; }
    .au-hero .au-hero-text i { display: block; width: 3rem; height: 1px; background: rgba(255, 255, 255, .8); margin-bottom: 1.5rem; }
    .au-hero .au-hero-text blockquote { margin: 0; font-family: 'EB Garamond', Georgia, 'Times New Roman', serif; font-size: clamp(1.9rem, 3vw, 2.6rem); font-weight: 400; color: #fff; line-height: 1.3; max-width: 26rem; }
    .au-hero .au-hero-text hr { margin: 6rem 0 0; border: 0; border-top: 1px solid rgba(255, 255, 255, .25); }

    @media (max-width: 860px) {
        .au-card { grid-template-columns: 1fr; min-height: 0; }
        .au-hero { display: none; }
        .au-left { padding: 2rem 1.5rem 2.25rem; }
    }

    /* ---------- Registrasi ---------- */
    .au-reg { max-width: 1152px; margin: 0 auto; padding: 1.5rem 1.25rem 4rem; }
    .au-reg-top { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 1rem 0 2rem; }
    .au-reg-top .au-brand { margin: 0; }
    .au-reg-top .au-brand b { font-size: 1.35rem; letter-spacing: 0; text-transform: none; font-weight: 500; }
    .au-reg-top p { font-size: .85rem; color: var(--au-muted); }
    .au-reg-top p a { color: #111; font-weight: 600; text-decoration: underline; text-underline-offset: 3px; }
    .au-reg-head { text-align: center; margin: .5rem 0 2.25rem; }
    .au-reg-head h1 { font-size: clamp(1.9rem, 4vw, 2.7rem); margin-bottom: .6rem; }
    .au-reg-head p { color: var(--au-muted); font-size: .9rem; }

    .au-roles { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; max-width: 900px; margin: 0 auto 2rem; }
    .au-roles input { position: absolute; opacity: 0; pointer-events: none; }
    .au-role { position: relative; display: block; padding: 1.75rem; background: #fff; border: 1px solid #F0F0EE; border-radius: 14px; cursor: pointer; box-shadow: 0 1px 3px rgba(0, 0, 0, .04); transition: box-shadow .15s, border-color .15s; }
    .au-role:hover { border-color: #DADAD8; }
    .au-roles input:checked + .au-role { border-color: #E4E4E2; box-shadow: 0 8px 28px rgba(0, 0, 0, .1); }
    .au-roles input:focus-visible + .au-role { outline: 2px solid #111; outline-offset: 2px; }
    .au-role-ico { width: 3rem; height: 3rem; display: grid; place-items: center; background: #F1F1F0; border-radius: 10px; color: #111; margin-bottom: 1.25rem; }
    .au-role h3 { font-size: 1.3rem; margin-bottom: .5rem; }
    .au-role p { font-size: .85rem; color: var(--au-muted); line-height: 1.6; }
    .au-role em { display: block; margin-top: 1rem; font-style: normal; font-size: .78rem; font-weight: 500; }
    .au-role-tick { position: absolute; top: 1.4rem; right: 1.4rem; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: grid; place-items: center; background: #111; color: #fff; opacity: 0; transform: scale(.7); transition: .15s; }
    .au-roles input:checked + .au-role .au-role-tick { opacity: 1; transform: scale(1); }

    .au-form-card { max-width: 900px; margin: 0 auto; padding: 2.25rem 3rem 2.5rem; background: #fff; border-radius: 14px; box-shadow: 0 8px 28px rgba(0, 0, 0, .08), 0 1px 3px rgba(0, 0, 0, .04); }
    .au-form-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; margin-bottom: 1.75rem; }
    .au-form-head h2 { font-size: 1.55rem; margin-bottom: .3rem; }
    .au-form-head p { font-size: .82rem; color: var(--au-muted); }
    .au-mode { flex: none; padding: .35rem .7rem; background: #F1F1F0; border-radius: 4px; font-size: .62rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: var(--au-muted); }
    .au-grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem 1.5rem; }
    .au-full { grid-column: 1 / -1; }
    .au-form-card .au-lbl { display: block; margin-bottom: .45rem; font-size: .78rem; font-weight: 500; }
    .au-input { position: relative; }
    .au-input svg { position: absolute; left: .9rem; top: 50%; transform: translateY(-50%); color: #777; pointer-events: none; }
    .au-input input { width: 100%; height: 2.9rem; padding: 0 1rem 0 2.6rem; background: var(--au-input); border: 1px solid transparent; border-radius: 8px; font: inherit; font-size: .88rem; color: #111; }
    .au-input input::placeholder { color: #9A9A98; }
    .au-input input:focus { outline: none; border-color: #111; background: #fff; }
    .au-terms { display: flex; align-items: center; gap: .6rem; margin: 1.5rem 0 1.25rem; font-size: .82rem; color: #333; }
    .au-terms input { width: 1rem; height: 1rem; accent-color: #111; margin: 0; flex: none; }
    .au-form-card .au-submit { height: 3rem; font-size: .82rem; letter-spacing: .02em; text-transform: none; font-weight: 600; }

    .au-banner { display: flex; align-items: center; justify-content: space-between; gap: 1rem; max-width: 900px; margin: 1.5rem auto 0; padding: .9rem 1.25rem; background: #fff; border-radius: 12px; box-shadow: 0 4px 16px rgba(0, 0, 0, .08); }
    .au-banner-ico { flex: none; width: 2.2rem; height: 2.2rem; border-radius: 50%; display: grid; place-items: center; background: #E8F3EC; color: #1F7A4D; }
    .au-banner-txt { flex: 1; font-size: .78rem; color: var(--au-muted); }
    .au-banner-txt b { display: block; color: #111; font-size: .85rem; font-weight: 600; }
    .au-banner a { flex: none; padding: .55rem 1rem; background: #F1F1F0; border-radius: 6px; font-size: .78rem; text-decoration: none; }
    .au-feats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; max-width: 900px; margin: 2rem auto 0; }
    .au-feat { padding: 1.1rem 1.25rem; background: #F4F4F3; border-radius: 10px; }
    .au-feat b { display: flex; align-items: center; gap: .5rem; margin-bottom: .45rem; font-size: .88rem; font-weight: 600; }
    .au-feat p { font-size: .8rem; line-height: 1.55; color: var(--au-muted); }

    @media (max-width: 760px) {
        .au-roles, .au-grid2, .au-feats { grid-template-columns: 1fr; }
        .au-form-card { padding: 1.5rem 1.25rem; }
        .au-form-head { flex-direction: column; }
        .au-banner { flex-wrap: wrap; }
    }
</style>
