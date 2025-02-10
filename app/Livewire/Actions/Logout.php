<?php

namespace App\Livewire\Actions;

use App\Events\UserLoggedOutEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke(): Redirector|RedirectResponse
    {
        if (auth()->user()->tenant_id) {
            event(new UserLoggedOutEvent(auth()->user()->tenant_id));
        }
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();

        return redirect('/');

    }
}
