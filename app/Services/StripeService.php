<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Laravel\Cashier\Checkout;
use Laravel\Cashier\Exceptions\CustomerAlreadyCreated;
use Log;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Invoice;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;
use Stripe\Subscription;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('stripe.secret_key')); // Automatically use the secret key from config
    }

    /**
     * @throws CustomerAlreadyCreated
     */
    public function createStripeCustomer(Tenant $tenant, User $user): Customer
    {
        $options = [
            'name' => $tenant->tenant_name,
            'address' => [
                'city' => $tenant->address_city,
                'country' => $tenant->address_country,
                'line1' => $tenant->address_line1,
                'line2' => $tenant->address_line2,
                'postal_code' => $tenant->postal_code,
                'state' => $tenant->address_state,
            ],
            'email' => $tenant->tenant_email,
            'phone' => $tenant->primary_phone,
            'metadata' => [
                'user_id' => $user->id,
                'tenant_id' => $tenant->id,
            ],
        ];

        return $tenant->createAsStripeCustomer($options);
    }

    /**
     * @throws ApiErrorException
     */
    public function fetchAllProducts(): array
    {
        // Fetch all active prices
        $stripePrices = Price::all(['active' => true]);

        $plans = [];

        foreach ($stripePrices->data as $price) {
            // Retrieve the associated product detail
            $product = Product::retrieve($price->product);

            $plans[] = [
                'name' => $product->name,
                'id' => $product->id,
                'features' => $product->marketing_features,
                'price_id' => $price->id,
                'amount' => $price->unit_amount, // Store raw price for sorting
                'price' => $this->formatSimplePrice($price),
            ];
        }

        return collect($plans)->sortBy('price')->values()->toArray();
    }

    private function formatSimplePrice($price): string
    {
        $amount = $price->unit_amount / 100; // Stripe stores amounts in cents

        return "\$$amount";
    }

    /**
     * @throws Exception
     */
    public function createSubscription(Tenant $tenant, User $user, string $priceId): Checkout
    {
        return $tenant
            ->newSubscription('default', $priceId)
            ->trialDays(30)
            ->allowPromotionCodes()
            ->checkout([
                'success_url' => route('dashboard'),
                'cancel_url' => route('auth.pricing'),
            ]);
    }

    public function getSubscriptionName(?string $stripeCustomerId): ?string
    {
        if (! $stripeCustomerId) {
            return null; // No customer ID provided
        }

        try {
            // Fetch subscriptions for the customer
            $subscriptions = Subscription::all(['customer' => $stripeCustomerId]);

            if (! empty($subscriptions->data)) {
                $subscription = $subscriptions->data[0]; // Get the first subscription (if any)

                // Get product info from the subscription's price object
                $price = $subscription->items->data[0]->price; // First subscription item's price
                $product = Product::retrieve($price->product); // Fetch associated product

                return $product->name; // Return the product name
            }
        } catch (ApiErrorException $e) {
            // Log the error and return null
            Log::error('Error fetching subscription name from Stripe: '.$e->getMessage());
        }

        return null; // Default case if no subscription was found
    }

    public function getTrialEndDate(?string $stripeCustomerId): ?string
    {
        if (! $stripeCustomerId) {
            return null; // Return null if no customer ID is provided
        }

        try {
            // Retrieve all subscriptions for the customer
            $subscriptions = Subscription::all(['customer' => $stripeCustomerId]);

            if (! empty($subscriptions->data)) {
                $subscription = $subscriptions->data[0]; // Get the first active subscription

                if ($subscription->trial_end) {
                    // Convert trial_end (Unix timestamp) to a readable format
                    return Carbon::createFromTimestamp($subscription->trial_end)->toFormattedDateString();
                }
            }
        } catch (ApiErrorException $e) {
            // Log errors and return null to handle gracefully
            Log::error('Failed to fetch trial end date: '.$e->getMessage());
        }

        return null; // Default case: no trial end date found
    }

    public function getTrialStartDate(?string $stripeCustomerId): ?string
    {
        if (! $stripeCustomerId) {
            return null; // Return null if no customer ID is provided
        }

        try {
            // Retrieve all subscriptions for the customer
            $subscriptions = Subscription::all(['customer' => $stripeCustomerId]);

            if (! empty($subscriptions->data)) {
                $subscription = $subscriptions->data[0]; // Get the first active subscription

                if ($subscription->trial_start) {
                    // Convert trial_end (Unix timestamp) to a readable format
                    return Carbon::createFromTimestamp($subscription->trial_start)->toFormattedDateString();
                }
            }
        } catch (ApiErrorException $e) {
            // Log errors and return null to handle gracefully
            Log::error('Failed to fetch trial end date: '.$e->getMessage());
        }

        return null; // Default case: no trial end date found
    }

    public function getNextInvoiceAmount(?string $stripeCustomerId): ?string
    {
        if (! $stripeCustomerId) {
            return null; // Return null if the customer ID is not provided
        }

        try {
            // Retrieve the upcoming invoice for the customer
            $invoice = Invoice::upcoming(['customer' => $stripeCustomerId]);

            if ($invoice) {
                // Convert the total (stored in cents) to a formatted amount (e.g., dollars)
                return number_format($invoice->total / 100, 2); // Return the formatted amount
            }
        } catch (ApiErrorException $e) {
            // Log error and handle gracefully
            Log::error('Failed to fetch next invoice amount: '.$e->getMessage());
        }

        return null; // Return null if no invoice is found
    }

    public function getNextInvoiceDueDate(?string $stripeCustomerId): ?string
    {
        if (! $stripeCustomerId) {
            return null; // Return null if no Stripe customer ID is provided
        }

        try {
            // Retrieve the upcoming invoice for the customer
            $invoice = Invoice::upcoming(['customer' => $stripeCustomerId]);

            if ($invoice) {
                // Use `period_end` for the end of the invoice period (next charge date)
                // For manual collection, use `due_date` instead if it's set.
                $dueDate = $invoice->period_end; // Unix timestamp

                return Carbon::createFromTimestamp($dueDate)->toFormattedDateString(); // Format due date
            }
        } catch (ApiErrorException $e) {
            // Log any errors and return null
            Log::error('Failed to fetch next invoice due date: '.$e->getMessage());
        }

        return null; // Default case if no invoice is found
    }
}
