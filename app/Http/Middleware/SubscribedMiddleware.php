<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscribedMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()->tenant?->subscribed()) {
            return redirect()->route('auth.pricing');
        }

        return $next($request);
    }
}
