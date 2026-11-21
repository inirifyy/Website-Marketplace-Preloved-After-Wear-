@extends('layouts.app')

@section('title', 'Verifikasi Nomor HP')

@section('content')
<div class="aw-container" style="max-width: 480px; margin-block: 3.5rem;">
    <div style="background:#fff; border-radius:1rem; border:1px solid #E2E8F0; padding:2rem; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
        <div style="text-align:center; margin-bottom:1.5rem;">
            <h1 style="font-size:1.6rem; font-weight:800; margin:0 0 .5rem; color:#1E293B;">Verifikasi Nomor HP</h1>
            @if ($hasPhone)
                <p style="color:#64748B; font-size:.9rem; margin:0;">
                    Masukkan kode 6 digit yang dikirim ke <strong>{{ $maskedPhone }}</strong>.
                    Kode berlaku {{ $ttl }} menit.
                </p>
            @else
                <p style="color:#991B1B; font-size:.9rem; margin:0;">
                    Nomor HP belum diisi. <a href="{{ route('profile.edit') }}">Isi di profil</a> dulu.
                </p>
            @endif
        </div>

        {{-- Mode pengembangan (OTP_DRIVER=log & OTP_SHOW_CODE=true): kode tampil di layar. --}}
        @if (session('dev_code'))
            <div class="aw-alert" style="background:#FFFBEB; border-color:#FDE68A; color:#92400E; text-align:center;">
                Mode pengembangan. Kode OTP: <strong style="font-size:1.3rem; letter-spacing:.2em;">{{ session('dev_code') }}</strong>
            </div>
        @endif

        @if ($hasPhone && $codeSent)
            <form action="{{ route('phone.verification.verify') }}" method="POST" style="margin-bottom:1rem;">
                @csrf
                <label for="code" style="display:block; font-size:.875rem; font-weight:600; margin-bottom:.35rem; color:#334155;">Kode verifikasi</label>
                <input type="text" name="code" id="code" required inputmode="numeric" autocomplete="one-time-code"
                       maxlength="6" pattern="[0-9]{6}" placeholder="000000" autofocus
                       style="width:100%; padding:.75rem; border-radius:.5rem; border:1px solid #CBD5E1; font-size:1.5rem; letter-spacing:.5em; text-align:center; box-sizing:border-box;">
                @error('code') <p style="color:#991B1B; font-size:.85rem; margin:.4rem 0 0;">{{ $message }}</p> @enderror

                <button type="submit" class="aw-btn aw-btn-primary" style="width:100%; margin-top:1rem; padding:.75rem; font-size:1rem; border-radius:.5rem;">
                    Verifikasi
                </button>
            </form>
        @endif

        @if ($hasPhone)
            <form action="{{ route('phone.verification.resend') }}" method="POST" style="text-align:center;">
                @csrf
                <button type="submit" id="resendBtn" class="aw-btn aw-btn-outline" style="font-size:.875rem;"
                        @if ($resendIn > 0) disabled data-wait="{{ $resendIn }}" @endif>
                    {{ $codeSent ? 'Kirim ulang kode' : 'Kirim kode' }}
                </button>
            </form>
        @endif

        <p style="text-align:center; font-size:.8rem; color:#64748B; margin:1.25rem 0 0;">
            Nomor salah? <a href="{{ route('profile.edit') }}">Ubah di profil</a> &middot;
            <a href="{{ route('home') }}">Nanti saja</a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        var btn = document.getElementById('resendBtn');
        if (!btn || !btn.dataset.wait) return;
        var left = parseInt(btn.dataset.wait, 10);
        var label = btn.textContent.trim();
        function tick() {
            if (left <= 0) { btn.disabled = false; btn.textContent = label; return; }
            btn.textContent = label + ' (' + left + ' dtk)';
            left--; setTimeout(tick, 1000);
        }
        tick();
    })();
</script>
@endpush
