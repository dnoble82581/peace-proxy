<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Stripe\StripeClient;

class PagesController extends Controller
{
    public function editUser(int $userId)
    {
        if ($userId) {
            $user = User::findorFail($userId);
        }

        return view('pages.update-user')->with('user', $user);
    }

    public function editSubject($roomId)
    {
        return view('pages.subject.edit-subject')->with('roomId', $roomId);
    }

    public function admin($tenantId)
    {
        $stripe = new StripeClient(config('stripe.secret_key')); // Your Stripe secret key

        // Retrieve customer subscriptions based on their Stripe customer ID

        $team = User::all();
        $tenant = Tenant::findorFail($tenantId);
        $subscriptions = $stripe->subscriptions->all(['customer' => $tenant->stripe_id]);

        return view('pages.admin')->with(['team' => $team, 'tenant' => $tenant, 'subscriptions' => $subscriptions]);
    }
}
