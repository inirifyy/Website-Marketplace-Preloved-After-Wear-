<?php

namespace App\Services;

use App\Models\User;
use App\Support\Phone;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Membuat, mengirim, dan memeriksa kode OTP 6 digit untuk verifikasi nomor HP.
 *
 * Pengiriman diatur lewat OTP_DRIVER di .env:
 *   log    : kode ditulis ke storage/logs/laravel.log (cocok untuk pengembangan).
 *            Jika OTP_SHOW_CODE=true, kode juga ditampilkan di halaman verifikasi.
 *   fonnte : kirim lewat WhatsApp memakai layanan Fonnte (butuh FONNTE_TOKEN).
 * Untuk gateway lain (Zenziva, Twilio, dll.), tambahkan satu method send<Nama>().
 */
class PhoneOtpService
{
    public const TTL_MINUTES = 10;
    public const MAX_ATTEMPTS = 5;
    public const RESEND_SECONDS = 60;

    /** Berapa detik lagi tombol "kirim ulang" boleh dipakai (0 = boleh sekarang). */
    public function secondsUntilResend(User $user): int
    {
        if (! $user->phone_otp_sent_at) {
            return 0;
        }

        $elapsed = $user->phone_otp_sent_at->diffInSeconds(now(), true);

        return (int) max(0, self::RESEND_SECONDS - $elapsed);
    }

    /**
     * Buat kode baru lalu kirim.
     *
     * @return array{ok: bool, error?: string, dev_code?: string}
     */
    public function issue(User $user): array
    {
        $phone = Phone::normalize($user->phone);

        if (! $phone || ! preg_match(Phone::PATTERN, $phone)) {
            return ['ok' => false, 'error' => 'Nomor HP belum diisi atau formatnya tidak valid. Perbarui di halaman profil.'];
        }

        if ($wait = $this->secondsUntilResend($user)) {
            return ['ok' => false, 'error' => "Tunggu {$wait} detik sebelum meminta kode baru."];
        }

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->forceFill([
            'phone_otp_hash'       => Hash::make($code),
            'phone_otp_expires_at' => now()->addMinutes(self::TTL_MINUTES),
            'phone_otp_sent_at'    => now(),
            'phone_otp_attempts'   => 0,
        ])->save();

        if (! $this->deliver($phone, $code)) {
            return ['ok' => false, 'error' => 'Kode gagal dikirim. Coba lagi beberapa saat lagi.'];
        }

        $result = ['ok' => true];

        if (config('services.otp.driver', 'log') === 'log' && config('services.otp.show_code')) {
            $result['dev_code'] = $code; // HANYA untuk pengembangan
        }

        return $result;
    }

    /** @return true|string  true jika benar, atau pesan error. */
    public function verify(User $user, string $code): bool|string
    {
        if (! $user->phone_otp_hash || ! $user->phone_otp_expires_at) {
            return 'Belum ada kode. Klik "Kirim kode" terlebih dahulu.';
        }

        if ($user->phone_otp_expires_at->isPast()) {
            return 'Kode sudah kedaluwarsa. Minta kode baru.';
        }

        if ($user->phone_otp_attempts >= self::MAX_ATTEMPTS) {
            return 'Terlalu banyak percobaan salah. Minta kode baru.';
        }

        if (! Hash::check($code, $user->phone_otp_hash)) {
            $user->forceFill(['phone_otp_attempts' => $user->phone_otp_attempts + 1])->save();

            return 'Kode salah.';
        }

        $user->forceFill([
            'phone_verified_at'    => now(),
            'phone_otp_hash'       => null,
            'phone_otp_expires_at' => null,
            'phone_otp_sent_at'    => null,
            'phone_otp_attempts'   => 0,
        ])->save();

        return true;
    }

    // ------------------------------------------------------------------

    private function deliver(string $phone, string $code): bool
    {
        $message = "After Wear: kode verifikasi Anda {$code}. Berlaku " . self::TTL_MINUTES . ' menit. Jangan bagikan kode ini ke siapa pun.';

        return match (config('services.otp.driver', 'log')) {
            'fonnte' => $this->sendFonnte($phone, $message),
            default  => $this->sendLog($phone, $message),
        };
    }

    private function sendLog(string $phone, string $message): bool
    {
        Log::info("[OTP] ke +{$phone}: {$message}");

        return true;
    }

    private function sendFonnte(string $phone, string $message): bool
    {
        $token = config('services.otp.fonnte_token');

        if (! $token) {
            Log::error('[OTP] FONNTE_TOKEN belum diisi di .env');

            return false;
        }

        try {
            $response = Http::withHeaders(['Authorization' => $token])
                ->asForm()
                ->timeout(10)
                ->post('https://api.fonnte.com/send', [
                    'target'  => $phone,
                    'message' => $message,
                ]);

            return $response->successful() && ($response->json('status') !== false);
        } catch (\Throwable $e) {
            Log::error('[OTP] Fonnte gagal: ' . $e->getMessage());

            return false;
        }
    }
}
