@extends('layouts.auth')

@section('title', 'Daftar Akun Baru')

@section('content')
@php
    $selectedRole = old('role', $registerAs ?? 'buyer');
    if (! in_array($selectedRole, ['buyer', 'seller'], true)) { $selectedRole = 'buyer'; }
    $logoFile = file_exists(public_path('images/logo-after-wear.png')) ? 'images/logo-after-wear.png' : 'images/Logo After Wear.png';
@endphp

<div class="au-reg">
    <div class="au-reg-top">
        <a class="au-brand" href="{{ route('home') }}">
            <img src="{{ asset($logoFile) }}" alt="" onerror="this.remove()">
            <span><b>After Wear</b></span>
        </a>
        <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
    </div>

    <div class="au-reg-head">
        <h1>Bergabung dengan Komunitas After Wear</h1>
        <p>Pilih peran Anda untuk memulai perjalanan fesyen sirkular yang transparan dan berdaya guna.</p>
    </div>

    <form action="{{ route('register.store') }}" method="POST" id="regForm">
        @csrf

        <div class="au-roles" role="radiogroup" aria-label="Daftar sebagai">
            <input type="radio" name="role" id="role_buyer" value="buyer" @checked($selectedRole === 'buyer')>
            <label class="au-role" for="role_buyer">
                <span class="au-role-tick"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 5 5L20 7"/></svg></span>
                <span class="au-role-ico"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></span>
                <h3>Saya Pembeli</h3>
                <p>Beli pakaian preloved terkurasi langsung dari penjual terpercaya via WhatsApp dengan jaminan kualitas kurasi.</p>
                <em>Akses katalog arsip eksklusif →</em>
            </label>

            <input type="radio" name="role" id="role_seller" value="seller" @checked($selectedRole === 'seller')>
            <label class="au-role" for="role_seller">
                <span class="au-role-tick"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 5 5L20 7"/></svg></span>
                <span class="au-role-ico"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/></svg></span>
                <h3>Saya Penjual (UMKM)</h3>
                <p>Buka etalase preloved UMKM Anda, kelola arsip fashion terkurasi, dan jangkau ribuan pembeli sadar lingkungan.</p>
                <em>Dukungan verifikasi UMKM lokal →</em>
            </label>
        </div>

        <div class="au-form-card">
            <div class="au-form-head">
                <div>
                    <h2 id="formTitle">Formulir Pendaftaran Pembeli</h2>
                    <p id="formSub">Lengkapi data pribadi untuk mulai mengeksplorasi pakaian preloved terverifikasi.</p>
                </div>
                <span class="au-mode" id="formMode">Mode Pembeli</span>
            </div>

            @if (session('error'))
                <div class="au-alert is-error" role="alert">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="au-alert is-error" role="alert">
                    <strong>Periksa kembali isian Anda:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="au-grid2">
                <div class="au-full">
                    <label class="au-lbl" for="name">Nama Lengkap</label>
                    <div class="au-input">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Masukkan nama lengkap Anda" autocomplete="name">
                    </div>
                </div>

                <div>
                    <label class="au-lbl" for="email">Alamat Email</label>
                    <div class="au-input">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg>
                        <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="email">
                    </div>
                </div>

                <div>
                    <label class="au-lbl" for="phone">Nomor WhatsApp Aktif</label>
                    <div class="au-input">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <input type="tel" name="phone" id="phone" required value="{{ old('phone') }}" placeholder="08123456789" autocomplete="tel">
                    </div>
                </div>

                <div>
                    <label class="au-lbl" for="password">Kata Sandi</label>
                    <div class="au-input">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter" autocomplete="new-password">
                    </div>
                </div>

                <div>
                    <label class="au-lbl" for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <div class="au-input">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/></svg>
                        <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ketik ulang kata sandi" autocomplete="new-password">
                    </div>
                </div>
            </div>

            <label class="au-terms">
                <input type="checkbox" name="terms" value="1" required>
                <span>Saya menyetujui Ketentuan Privasi dan Komitmen Berkelanjutan After Wear.</span>
            </label>

            <button type="submit" class="au-submit" id="formBtn">
                <span id="formBtnText">Daftar sebagai Pembeli</span>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>
        </div>
    </form>

    @if (session('success'))
        <div class="au-banner" role="status">
            <span class="au-banner-ico"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 5 5L20 7"/></svg></span>
            <div class="au-banner-txt"><b>{{ session('success') }}</b></div>
            <a href="{{ route('login') }}">Masuk Sekarang &rsaquo;</a>
        </div>
    @endif

    <div class="au-feats">
        <div class="au-feat">
            <b><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg> Kurasi Terverifikasi</b>
            <p>Setiap pakaian lolos inspeksi standar transparansi kondisi 100%.</p>
        </div>
        <div class="au-feat">
            <b><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg> Transaksi WhatsApp</b>
            <p>Komunikasi personal langsung antara pembeli dan kurator lokal terdaftar.</p>
        </div>
        <div class="au-feat">
            <b><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg> Dampak Sirkular</b>
            <p>Perpanjang siklus hidup busana preloved berkualitas atelier.</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        var copy = {
            buyer: {
                title: 'Formulir Pendaftaran Pembeli',
                sub: 'Lengkapi data pribadi untuk mulai mengeksplorasi pakaian preloved terverifikasi.',
                mode: 'Mode Pembeli',
                btn: 'Daftar sebagai Pembeli'
            },
            seller: {
                title: 'Formulir Pendaftaran Penjual',
                sub: 'Lengkapi data untuk membuka etalase preloved UMKM Anda di After Wear.',
                mode: 'Mode Penjual',
                btn: 'Daftar sebagai Penjual'
            }
        };

        function render() {
            var checked = document.querySelector('input[name="role"]:checked');
            var c = copy[checked ? checked.value : 'buyer'];
            document.getElementById('formTitle').textContent = c.title;
            document.getElementById('formSub').textContent = c.sub;
            document.getElementById('formMode').textContent = c.mode;
            document.getElementById('formBtnText').textContent = c.btn;
        }

        document.querySelectorAll('input[name="role"]').forEach(function (el) {
            el.addEventListener('change', render);
        });
        render();
    })();
</script>
@endpush
