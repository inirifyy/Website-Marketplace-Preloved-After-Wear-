@extends('layouts.app')

@section('title', 'Masuk ke Akun')

@section('content')
<div class="aw-container" style="max-width: 480px; margin-block: 3.5rem;">
    <div style="background:#fff; border-radius:1rem; border:1px solid #E2E8F0; padding:2rem; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
        <div style="text-align:center; margin-bottom:1.5rem;">
            <h1 style="font-size:1.75rem; font-weight:800; margin:0 0 0.5rem; color:#1E293B;">Selamat Datang</h1>
            <p style="color:#64748B; font-size:0.9rem; margin:0;">Masuk untuk melanjutkan belanja pakaian preloved di After Wear</p>
        </div>

        <form action="{{ route('login.store') }}" method="POST">
            @csrf

            <div style="margin-bottom:1.25rem;">
                <label for="email" style="display:block; font-size:0.875rem; font-weight:600; margin-bottom:0.35rem; color:#334155;">Alamat Email</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                    placeholder="nama@email.com"
                    style="width:100%; padding:0.65rem 0.85rem; border-radius:0.5rem; border:1px solid #CBD5E1; font-size:0.95rem; box-sizing:border-box;">
            </div>

            <div style="margin-bottom:1.25rem;">
                <label for="password" style="display:block; font-size:0.875rem; font-weight:600; margin-bottom:0.35rem; color:#334155;">Kata Sandi</label>
                <input type="password" name="password" id="password" required
                    placeholder="••••••••"
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

        <div style="text-align:center; margin-top:1.5rem; font-size:0.875rem; color:#64748B;">
            Belum punya akun? <a href="{{ route('register') }}" style="color:#059669; font-weight:600; text-decoration:none;">Daftar Akun Baru</a>
        </div>
    </div>
</div>
@endsection
