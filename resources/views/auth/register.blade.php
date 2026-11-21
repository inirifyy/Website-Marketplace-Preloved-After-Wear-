@extends('layouts.app')

@section('title', 'Daftar Akun Baru')

@push('styles')
<style>
    .aw-reg-roles { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem; margin-bottom: 1.25rem; }
    .aw-reg-roles input { position: absolute; opacity: 0; pointer-events: none; }
    .aw-reg-roles label { display: block; padding: .75rem; border: 1px solid #CBD5E1; border-radius: .6rem; cursor: pointer; font-size: .85rem; color: #64748B; }
    .aw-reg-roles label b { display: block; color: #1E293B; font-size: .95rem; margin-bottom: .15rem; }
    .aw-reg-roles input:checked + label { border-color: #111; box-shadow: 0 0 0 1px #111; background: #F7F7F6; }
    .aw-reg-roles input:focus-visible + label { outline: 2px solid #111; outline-offset: 2px; }
</style>
@endpush

@section('content')
<div class="aw-container" style="max-width: 480px; margin-block: 3.5rem;">
    <div style="background:#fff; border-radius:1rem; border:1px solid #E2E8F0; padding:2rem; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
        <div style="text-align:center; margin-bottom:1.5rem;">
            <h1 style="font-size:1.75rem; font-weight:800; margin:0 0 0.5rem; color:#1E293B;">Buat Akun</h1>
            <p style="color:#64748B; font-size:0.9rem; margin:0;">Bergabung dengan komunitas pakaian preloved After Wear</p>
        </div>

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="aw-reg-roles" role="radiogroup" aria-label="Daftar sebagai">
                @php $selectedRole = old('role', $registerAs ?? 'buyer'); @endphp
                <div style="display:contents;">
                    <input type="radio" name="role" id="role_buyer" value="buyer" @checked($selectedRole === 'buyer')>
                    <label for="role_buyer"><b>Pembeli</b>Belanja &amp; beri ulasan</label>
                </div>
                <div style="display:contents;">
                    <input type="radio" name="role" id="role_seller" value="seller" @checked($selectedRole === 'seller')>
                    <label for="role_seller"><b>Penjual</b>Jual pakaian preloved</label>
                </div>
            </div>

            <div style="margin-bottom:1.25rem;">
                <label for="name" style="display:block; font-size:0.875rem; font-weight:600; margin-bottom:0.35rem; color:#334155;">Nama Lengkap</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                    placeholder="Contoh: Rian Pratama"
                    style="width:100%; padding:0.65rem 0.85rem; border-radius:0.5rem; border:1px solid #CBD5E1; font-size:0.95rem; box-sizing:border-box;">
            </div>

            <div style="margin-bottom:1.25rem;">
                <label for="email" style="display:block; font-size:0.875rem; font-weight:600; margin-bottom:0.35rem; color:#334155;">Alamat Email</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                    placeholder="nama@email.com"
                    style="width:100%; padding:0.65rem 0.85rem; border-radius:0.5rem; border:1px solid #CBD5E1; font-size:0.95rem; box-sizing:border-box;">
            </div>

            <div style="margin-bottom:1.25rem;">
                <label for="phone" style="display:block; font-size:0.875rem; font-weight:600; margin-bottom:0.35rem; color:#334155;">Nomor WhatsApp / HP</label>
                <input type="tel" name="phone" id="phone" required value="{{ old('phone') }}"
                    placeholder="081234567890" autocomplete="tel"
                    style="width:100%; padding:0.65rem 0.85rem; border-radius:0.5rem; border:1px solid #CBD5E1; font-size:0.95rem; box-sizing:border-box;">
                <p style="font-size:.78rem; color:#64748B; margin:.35rem 0 0;">Kami kirim kode verifikasi ke nomor ini. Email tidak perlu diverifikasi.</p>
            </div>

            <div style="margin-bottom:1.25rem;">
                <label for="password" style="display:block; font-size:0.875rem; font-weight:600; margin-bottom:0.35rem; color:#334155;">Kata Sandi (Minimal 8 Karakter)</label>
                <input type="password" name="password" id="password" required
                    placeholder="••••••••"
                    style="width:100%; padding:0.65rem 0.85rem; border-radius:0.5rem; border:1px solid #CBD5E1; font-size:0.95rem; box-sizing:border-box;">
            </div>

            <div style="margin-bottom:1.5rem;">
                <label for="password_confirmation" style="display:block; font-size:0.875rem; font-weight:600; margin-bottom:0.35rem; color:#334155;">Ulangi Kata Sandi</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    placeholder="••••••••"
                    style="width:100%; padding:0.65rem 0.85rem; border-radius:0.5rem; border:1px solid #CBD5E1; font-size:0.95rem; box-sizing:border-box;">
            </div>

            <button type="submit" class="aw-btn aw-btn-primary" style="width:100%; padding:0.75rem; font-size:1rem; border-radius:0.5rem;">
                Daftar Akun Sekarang
            </button>
        </form>

        <div style="text-align:center; margin-top:1.5rem; font-size:0.875rem; color:#64748B;">
            Sudah memiliki akun? <a href="{{ route('login') }}" style="color:#059669; font-weight:600; text-decoration:none;">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection
