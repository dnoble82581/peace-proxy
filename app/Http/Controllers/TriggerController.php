<?php

namespace App\Http\Controllers;

use App\Models\Trigger;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TriggerController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Trigger::class);

        return Trigger::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Trigger::class);

        $data = $request->validate([
            'subject_id' => ['required', 'exists:subjects'],
            'tenant_id' => ['required', 'exists:tenants'],
            'title' => ['required'],
            'description' => ['required'],
        ]);

        return Trigger::create($data);
    }

    public function show(Trigger $trigger)
    {
        $this->authorize('view', $trigger);

        return $trigger;
    }

    public function update(Request $request, Trigger $trigger)
    {
        $this->authorize('update', $trigger);

        $data = $request->validate([
            'subject_id' => ['required', 'exists:subjects'],
            'tenant_id' => ['required', 'exists:tenants'],
            'title' => ['required'],
            'description' => ['required'],
        ]);

        $trigger->update($data);

        return $trigger;
    }

    public function destroy(Trigger $trigger)
    {
        $this->authorize('delete', $trigger);

        $trigger->delete();

        return response()->json();
    }
}
