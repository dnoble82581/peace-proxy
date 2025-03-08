<?php

use App\Http\Middleware\CheckIsAdmin;
use App\Http\Middleware\SubscribedMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('subscriptions')
                ->name('subscriptions.')
                ->group(__DIR__.'/../routes/subscriptions.php');
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => CheckIsAdmin::class,
            'subscribed' => SubscribedMiddleware::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'stripe/*',
            '/api/sms/inbound',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
