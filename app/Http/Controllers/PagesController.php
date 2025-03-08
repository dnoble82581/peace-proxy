<?php

namespace App\Http\Controllers;

use App\Models\Negotiation;
use App\Models\Tenant;
use App\Models\User;
use App\Services\StripeService;
use Illuminate\Support\Facades\Cache;

class PagesController extends Controller
{
    private StripeService $stripeService;

    // Use dependency injection to initialize StripeService
    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Edit a specific user by ID.
     */
    public function editUser(int $userId)
    {
        $user = User::findOrFail($userId); // Directly call findOrFail

        return view('pages.update-user', compact('user'));
    }

    /**
     * Show edit subject page based on room ID.
     */
    public function editSubject(int $roomId)
    {
        return view('pages.subject.edit-subject', compact('roomId'));
    }

    /**
     * Show admin page for a specific tenant.
     */
    public function admin(int $tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);
        $team = User::all();
        $negotiations = Negotiation::query()
            ->with('associates')
            ->get();

        // Use the injected stripeService to fetch Stripe-related data
        $subscriptionInfo = Cache::remember("tenant_{$tenantId}_subscription_info", now()->addMinutes(15),
            function () use ($tenant) {
                return [
                    'subscriptionName' => $this->stripeService->getSubscriptionName($tenant->stripe_id) ?? 'No Subscription',
                    'subscriptionTrialEnd' => $this->stripeService->getTrialEndDate($tenant->stripe_id),
                    'subscriptionTrialBegan' => $this->stripeService->getTrialStartDate($tenant->stripe_id),
                    'nextInvoiceAmount' => $this->stripeService->getNextInvoiceAmount($tenant->stripe_id),
                    'nextInvoiceDue' => $this->stripeService->getNextInvoiceDueDate($tenant->stripe_id),
                ];
            });

        return view('pages.admin', compact('team', 'tenant', 'subscriptionInfo', 'negotiations'));
    }

    /**
     * Show dashboard page for the authenticated user's tenant.
     */
    public function dashboard()
    {
        $negotiations = Negotiation::all(); // Use request()->user()

        return view('pages.dashboard', compact('negotiations'));
    }
}
