<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Barryvdh\DomPDF\ServiceProvider;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // Middlewares de permissão
        $middleware->alias([
            'permission' => \App\Http\Middleware\CheckPermission::class,
            'can:manage-clients' => \App\Http\Middleware\CheckPermission::class . ':manage-clients',
            'can:manage-products' => \App\Http\Middleware\CheckPermission::class . ':manage-products',
            'can:view-reports' => \App\Http\Middleware\CheckPermission::class . ':view-reports',
            'can:manage-sales' => \App\Http\Middleware\CheckPermission::class . ':manage-sales',
            'can:manage-settings' => \App\Http\Middleware\CheckPermission::class . ':manage-settings',
            'can:manage-social' => \App\Http\Middleware\CheckPermission::class . ':manage-social',
            'can:manage-suppliers' => \App\Http\Middleware\CheckPermission::class . ':manage-suppliers',
        ]);

        // Middleware padrão 
        $middleware->web([
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->api([
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        
    })
    ->withProviders([
        Barryvdh\DomPDF\ServiceProvider::class, // ✅ agora está correto!
    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
