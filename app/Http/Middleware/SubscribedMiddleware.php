<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SubscribedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()->tenant?->subscribed()) {
            return redirect()->route('auth.pricing');
        }

        return $next($request);
    }
}
