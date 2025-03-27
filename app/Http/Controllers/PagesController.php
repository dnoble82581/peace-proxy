<?php

namespace App\Http\Controllers;

use App\Models\Negotiation;
use App\Models\Tenant;
use App\Models\User;

class PagesController extends Controller
{
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

    public function negotiation($negotiationId)
    {
        $negotiation = Negotiation::query()
            ->with([
                'logs', 'logs.user', 'user', 'demands', 'triggers', 'hooks', 'user.messages', 'rfis', 'subject',
            ])
            ->findOrFail($negotiationId);
        $user = auth()->user();

        return view('pages.admin.show-negotiation')->with(compact('negotiation', 'user'));
    }

    /**
     * Show admin page for a specific tenant.
     */
    public function admin(int $tenantId)
    {
        $user = auth()->user();
        $tenant = Tenant::with([
            'users',
            'subjects',
            'subjects.demands',
            'subjects.associates',
            'negotiations.hooks',
            'negotiations.triggers',
            'negotiations.demands',
        ])->findOrFail($tenantId);

        return view('pages.admin.admin', compact('tenant', 'user'));
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
