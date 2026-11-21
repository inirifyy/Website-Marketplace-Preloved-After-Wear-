<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Mewajibkan nomor HP terverifikasi (bukan email).
 * Admin dikecualikan. Pasang di route: ->middleware(['auth', 'phone.verified'])
 */
class EnsurePhoneIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->isAdmin() && ! $user->hasVerifiedPhone()) {
            if ($request->expectsJson()) {
                abort(403, 'Nomor HP Anda belum terverifikasi.');
            }

            return redirect()
                ->guest(route('phone.verification.notice'))
                ->with('error', 'Verifikasi nomor HP Anda dulu untuk melanjutkan.');
        }

        return $next($request);
    }
}
