<?php

namespace App\Http\Controllers;

use App\Models\Negotiation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class NegotiationController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Negotiation::class);

        return Negotiation::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Negotiation::class);

        $data = $request->validate([
            'title' => ['required'],
            'address' => ['nullable'],
            'city' => ['required'],
            'state' => ['required'],
            'zip' => ['nullable'],
            'status' => ['required'],
            'initial_complanant' => ['required'],
            'initial_complaint' => ['required'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date'],
            'user_id' => ['required', 'exists:users'],
        ]);

        return Negotiation::create($data);
    }

    public function show(Negotiation $negotiation)
    {
        $this->authorize('view', $negotiation);

        return $negotiation;
    }

    public function update(Request $request, Negotiation $negotiation)
    {
        $this->authorize('update', $negotiation);

        $data = $request->validate([
            'title' => ['required'],
            'address' => ['nullable'],
            'city' => ['required'],
            'state' => ['required'],
            'zip' => ['nullable'],
            'status' => ['required'],
            'initial_complanant' => ['required'],
            'initial_complaint' => ['required'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date'],
            'user_id' => ['required', 'exists:users'],
        ]);

        $negotiation->update($data);

        return $negotiation;
    }

    public function destroy(Negotiation $negotiation)
    {
        $this->authorize('delete', $negotiation);

        $negotiation->delete();

        return response()->json();
    }
}
