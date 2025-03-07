<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\User;
use Exception;
use Laravel\Cashier\Checkout;
use Laravel\Cashier\Exceptions\CustomerAlreadyCreated;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;

class StripeService
{
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
        // Set Stripe API Key
        Stripe::setApiKey(config('stripe.secret_key'));

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
                'cancel_url' => route('dashboard'),
            ]);
    }
}
