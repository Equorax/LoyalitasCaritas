<?php

// Impor kelas-kelas yang digunakan di bawah ini
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Impor kelas middleware inti dari namespace aslinya
use Illuminate\Auth\Middleware\Authenticate; // <- Namespace untuk middleware inti
use Illuminate\Auth\Middleware\RedirectIfAuthenticated; // <- Namespace untuk middleware inti

// Impor middleware RBAC kamu
use App\Http\Middleware\EnsureUserRole; // <- Namespace untuk middleware kamu

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan middleware alias 'role' di sini
        $middleware->alias([
            // Middleware bawaan Laravel 12, gunakan namespace lengkap
            'auth' => Authenticate::class, // <- Gunakan nama kelas saja setelah diimpor
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => RedirectIfAuthenticated::class, // <- Gunakan nama kelas saja setelah diimpor
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
            'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class, // <- Gunakan namespace yang benar untuk middleware 'signed'
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

            // Tambahkan middleware RBAC kamu
            'role' => EnsureUserRole::class, // <- Gunakan nama kelas saja setelah diimpor
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();