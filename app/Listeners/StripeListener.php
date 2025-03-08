<?php

namespace App\Listeners;

use App\Models\Tenant;
use Carbon\Carbon;
use Exception;
use Laravel\Cashier\Events\WebhookReceived;
use Log;
use Stripe\Stripe;

class StripeListener
{
    public function __construct()
    {
        Stripe::setApiKey(config('stripe.secret_key'));
    }

    public function handle(WebhookReceived $event): void
    {
        // Access the payload directly from the $event object
        $payload = $event->payload;

        // Process the event only if it matches 'customer.subscription.created'
        if ($payload['type'] === 'customer.subscription.created') {
            $subscription = $payload['data']['object']; // Access subscription object
            $customerId = $subscription['customer']; // Stripe customer ID
            $trialEndsAt = ! empty($subscription['trial_end'])
                ? Carbon::createFromTimestamp($subscription['trial_end'])->toDateTimeString()
                : null;

            // Find the tenant using the Stripe customer ID
            $tenant = Tenant::where('stripe_id', $customerId)->first();

            if ($tenant) {
                try {
                    // Retrieve the default payment method using Cashier
                    $defaultPaymentMethod = $tenant->defaultPaymentMethod();

                    if ($defaultPaymentMethod) {
                        // Update tenant with payment-related information
                        Log::info('Updating tenant with trial_ends_at value: '.$trialEndsAt);

                        $tenant->update([
                            'pm_last_four' => $defaultPaymentMethod->card->last4 ?? null,
                            'pm_type' => $defaultPaymentMethod->card->brand ?? null,
                            'trial_ends_at' => $trialEndsAt,
                        ]);
                    } else {
                        Log::info('No default payment method found for tenant.');
                    }
                } catch (Exception $e) {
                    Log::error('Error with payment method: '.$e->getMessage());
                }
            } else {
                Log::warning('No tenant found for Stripe Customer ID: '.$customerId);
            }
        }
    }
}
