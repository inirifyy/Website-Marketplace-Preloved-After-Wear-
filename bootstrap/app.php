<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role'           => \App\Http\Middleware\RoleMiddleware::class,
            'phone.verified' => \App\Http\Middleware\EnsurePhoneIsVerified::class,
        ]);

        // Tamu yang membuka /admin atau /seller dibawa ke halaman login
        // dengan tab peran yang sesuai sudah terpilih.
        $middleware->redirectGuestsTo(fn (Request $request) => route('login', array_filter([
            'as' => $request->is('admin', 'admin/*') ? 'admin'
                : ($request->is('seller', 'seller/*') ? 'seller' : null),
        ])));

        // User yang sudah login dan membuka /login atau /register dibawa ke halamannya.
        $middleware->redirectUsersTo(fn (Request $request) => $request->user()?->homeUrl() ?? url('/'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
