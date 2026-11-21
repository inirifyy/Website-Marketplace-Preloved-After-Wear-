@extends('layouts.app')

@section('title', 'Masuk ke Akun')

@push('styles')
<style>
    .aw-role-tabs { display: grid; grid-template-columns: repeat(3, 1fr); gap: .35rem; padding: .3rem; background: #F1F1F0; border-radius: .6rem; margin-bottom: 1.25rem; }
    .aw-role-tabs input { position: absolute; opacity: 0; pointer-events: none; }
    .aw-role-tabs label { text-align: center; padding: .5rem .25rem; border-radius: .45rem; font-size: .875rem; font-weight: 600; color: #6B6B6B; cursor: pointer; transition: .15s; }
    .aw-role-tabs input:checked + label { background: #fff; color: #111; box-shadow: 0 1px 3px rgba(0,0,0,.12); }
    .aw-role-tabs input:focus-visible + label { outline: 2px solid #111; outline-offset: 1px; }
    .aw-role-hint { font-size: .85rem; color: #64748B; text-align: center; margin: -.5rem 0 1.25rem; min-height: 1.3em; }
</style>
@endpush

@section('content')
<div class="aw-container" style="max-width: 480px; margin-block: 3.5rem;">
    <div style="background:#fff; border-radius:1rem; border:1px solid #E2E8F0; padding:2rem; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
        <div style="text-align:center; margin-bottom:1.5rem;">
            <h1 style="font-size:1.75rem; font-weight:800; margin:0 0 0.5rem; color:#1E293B;">Selamat Datang</h1>
            <p style="color:#64748B; font-size:0.9rem; margin:0;">Pilih jenis akun, lalu masuk ke After Wear</p>
        </div>

        <form action="{{ route('login.store') }}" method="POST">
            @csrf

            {{-- Masuk sebagai: Pembeli / Penjual / Admin --}}
            @php $selected = old('login_as', $loginAs); @endphp
            <div class="aw-role-tabs" role="radiogroup" aria-label="Masuk sebagai">
                @foreach ($roles as $value => $label)
                    <div style="display:contents;">
                        <input type="radio" name="login_as" id="login_as_{{ $value }}" value="{{ $value }}"
                               @checked($selected === $value) data-hint="{{ $value }}">
                        <label for="login_as_{{ $value }}">{{ $label }}</label>
                    </div>
                @endforeach
            </div>
            <p class="aw-role-hint" id="roleHint" aria-live="polite"></p>

            <div style="margin-bottom:1.25rem;">
                <label for="email" style="display:block; font-size:0.875rem; font-weight:600; margin-bottom:0.35rem; color:#334155;">Alamat Email</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                    placeholder="nama@email.com" autocomplete="email"
                    style="width:100%; padding:0.65rem 0.85rem; border-radius:0.5rem; border:1px solid #CBD5E1; font-size:0.95rem; box-sizing:border-box;">
            </div>

            <div style="margin-bottom:1.25rem;">
                <label for="password" style="display:block; font-size:0.875rem; font-weight:600; margin-bottom:0.35rem; color:#334155;">Kata Sandi</label>
                <input type="password" name="password" id="password" required
                    placeholder="••••••••" autocomplete="current-password"
                    style="width:100%; padding:0.65rem 0.85rem; border-radius:0.5rem; border:1px solid #CBD5E1; font-size:0.95rem; box-sizing:border-box;">
            </div>

            <div style="display:flex; align-items:center; margin-bottom:1.5rem;">
                <label style="display:flex; align-items:center; gap:0.5rem; font-size:0.875rem; color:#475569; cursor:pointer;">
                    <input type="checkbox" name="remember" value="1">
                    Ingat saya di perangkat ini
                </label>
            </div>

            <button type="submit" class="aw-btn aw-btn-primary" style="width:100%; padding:0.75rem; font-size:1rem; border-radius:0.5rem;">
                Masuk Sekarang
            </button>
        </form>

        <div id="registerLink" style="text-align:center; margin-top:1.5rem; font-size:0.875rem; color:#64748B;">
            Belum punya akun?
            <a href="{{ route('register') }}" id="registerAnchor" style="color:#059669; font-weight:600; text-decoration:none;">Daftar Akun Baru</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        var hints = {
            buyer:  'Belanja pakaian preloved dan tulis ulasan.',
            seller: 'Ajukan barang dan kelola toko Anda.',
            admin:  'Khusus pengelola After Wear. Akun admin tidak bisa didaftarkan sendiri.'
        };
        var registerUrl = @json(route('register'));
        var sellerRegisterUrl = @json(route('register', ['as' => 'seller']));
        var hint = document.getElementById('roleHint');
        var regBox = document.getElementById('registerLink');
        var regAnchor = document.getElementById('registerAnchor');

        function update() {
            var checked = document.querySelector('input[name="login_as"]:checked');
            var role = checked ? checked.value : 'buyer';
            hint.textContent = hints[role] || '';
            regBox.style.display = role === 'admin' ? 'none' : '';
            regAnchor.href = role === 'seller' ? sellerRegisterUrl : registerUrl;
        }

        document.querySelectorAll('input[name="login_as"]').forEach(function (el) {
            el.addEventListener('change', update);
        });
        update();
    })();
</script>
@endpush
