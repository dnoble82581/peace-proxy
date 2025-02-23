<?php

namespace App\Http\Controllers;

use App\Models\DeliveryPlan;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class DeliveryPlanController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', DeliveryPlan::class);

        return DeliveryPlan::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', DeliveryPlan::class);

        $data = $request->validate([
            'delivery_location' => ['nullable'],
            'special_instructions' => ['nullable'],
            'title' => ['required'],
            'notes' => ['nullable'],
            'user_id' => ['required', 'exists:users'],
            'room_id' => ['required', 'exists:rooms'],
            'tenant_id' => ['required', 'exists:tenants'],
        ]);

        return DeliveryPlan::create($data);
    }

    public function show(DeliveryPlan $deliveryPlan)
    {
        $this->authorize('view', $deliveryPlan);

        return $deliveryPlan;
    }

    public function update(Request $request, DeliveryPlan $deliveryPlan)
    {
        $this->authorize('update', $deliveryPlan);

        $data = $request->validate([
            'delivery_location' => ['nullable'],
            'special_instructions' => ['nullable'],
            'title' => ['required'],
            'notes' => ['nullable'],
            'user_id' => ['required', 'exists:users'],
            'room_id' => ['required', 'exists:rooms'],
            'tenant_id' => ['required', 'exists:tenants'],
        ]);

        $deliveryPlan->update($data);

        return $deliveryPlan;
    }

    public function destroy(DeliveryPlan $deliveryPlan)
    {
        $this->authorize('delete', $deliveryPlan);

        $deliveryPlan->delete();

        return response()->json();
    }
}
