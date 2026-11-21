<?php

namespace App\Support;

/**
 * Pembantu format nomor HP Indonesia.
 * Semua nomor disimpan dalam format internasional tanpa tanda plus: 6281234567890.
 */
class Phone
{
    /** "0812-3456-7890", "+62 812 3456 7890", "812..." -> "6281234567890". */
    public static function normalize(?string $raw): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $raw);

        if ($digits === '' || $digits === null) {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        } elseif (str_starts_with($digits, '8')) {
            $digits = '62' . $digits;
        }

        return $digits;
    }

    /** Pola yang dipakai validasi: awalan 62, total 10-15 digit. */
    public const PATTERN = '/^62[0-9]{8,13}$/';

    /** 6281234567890 -> +62 812****7890 (untuk ditampilkan). */
    public static function mask(?string $normalized): string
    {
        if (! $normalized || strlen($normalized) < 8) {
            return '-';
        }

        return '+' . substr($normalized, 0, 5) . str_repeat('*', max(strlen($normalized) - 9, 2)) . substr($normalized, -4);
    }
}
