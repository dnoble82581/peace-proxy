<?php

namespace App\Http\Controllers;

use App\Models\Negotiation;
use App\Models\User;
use App\Services\StripeService;

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
    public function admin(int $tenantId) {}

    /**
     * Show dashboard page for the authenticated user's tenant.
     */
    public function dashboard()
    {
        $negotiations = Negotiation::all(); // Use request()->user()

        return view('pages.dashboard', compact('negotiations'));
    }
}
