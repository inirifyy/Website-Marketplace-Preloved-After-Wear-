<?php

namespace App\Http\Controllers;

use App\Services\PhoneOtpService;
use App\Support\Phone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Verifikasi nomor HP lewat kode OTP 6 digit.
 * Routes: phone.verification.notice / .verify / .resend
 */
class PhoneVerificationController extends Controller
{
    public function notice(Request $request, PhoneOtpService $otp): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->isAdmin() || $user->hasVerifiedPhone()) {
            return redirect($user->homeUrl());
        }

        return view('auth.verify-phone', [
            'maskedPhone'  => Phone::mask(Phone::normalize($user->phone)),
            'hasPhone'     => (bool) Phone::normalize($user->phone),
            'codeSent'     => $user->phone_otp_hash && $user->phone_otp_expires_at?->isFuture(),
            'resendIn'     => $otp->secondsUntilResend($user),
            'ttl'          => PhoneOtpService::TTL_MINUTES,
        ]);
    }

    public function verify(Request $request, PhoneOtpService $otp): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'digits:6'],
        ], [
            'code.required' => 'Masukkan kode 6 digit.',
            'code.digits'   => 'Kode harus berupa 6 angka.',
        ]);

        $user   = $request->user();
        $result = $otp->verify($user, $data['code']);

        if ($result !== true) {
            return back()->withErrors(['code' => $result]);
        }

        return redirect()->intended($user->homeUrl())
            ->with('success', 'Nomor HP berhasil diverifikasi. Terima kasih!');
    }

    public function resend(Request $request, PhoneOtpService $otp): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedPhone()) {
            return redirect($user->homeUrl());
        }

        $result = $otp->issue($user);

        if (! $result['ok']) {
            return back()->with('error', $result['error']);
        }

        $back = back()->with('success', 'Kode verifikasi sudah dikirim ke nomor Anda.');

        if (isset($result['dev_code'])) {
            $back->with('dev_code', $result['dev_code']);
        }

        return $back;
    }
}
