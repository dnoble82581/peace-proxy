<?php

namespace App\Http\Controllers;

use App\Services\StripeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Stripe\Exception\ApiErrorException;

class SubscriptionController extends Controller
{
    // Show pricing plans to users
    /**
     * @throws ApiErrorException
     */
    public function showPricing()
    {
        $stripeService = new StripeService;
        $plans = $stripeService->fetchAllProducts();

        if (Auth::check()) {
            return view('subscriptions.auth-pricing', ['plans' => $plans]);
        }

        return view('subscriptions.pricing', ['plans' => $plans]);
    }

    // Handle user subscription

    /**
     * @throws IncompletePayment
     * @throws Exception
     */
    public function subscribe(Request $request)
    {
        $stripeService = new StripeService;
        $subscription = $stripeService->createSubscription($request->user()->tenant, $request->user(),
            $request->price_id);

        return redirect($subscription->url);
    }

    /**
     * @throws Exception
     */
    public function billingPortal(Request $request) {}

    // Redirect to Stripe Billing Portal

    public function showDashboard()
    {
        $subscription = Auth::user()->tenant->subscription('default');

        return view('subscriptions.dashboard', [
            'is_active' => $subscription->active(),
            'on_trial' => $subscription->onTrial(),
            'trial_ends_at' => $subscription->trial_ends_at,
        ]);
    }

    private function formatSimplePrice($price)
    {
        $amount = $price->unit_amount / 100; // Stripe stores amounts in cents

        return "\$$amount";
    }

    private function formatFullPrice($price)
    {
        $amount = $price->unit_amount / 100; // Stripe stores amounts in cents
        $currency = strtoupper($price->currency);

        return "{$currency} {$amount}/".($price->recurring ? $price->recurring->interval : 'once');
    }
}
