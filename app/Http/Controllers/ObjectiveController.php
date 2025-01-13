<?php

namespace App\Http\Controllers;

use App\Models\Objective;
use Illuminate\Http\Request;

class ObjectiveController extends Controller
{
    public function index()
    {
        return Objective::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tenant_id' => ['required', 'exists:tenants'],
            'negotiation_id' => ['required', 'exists:negotiations'],
            'priority' => ['required'],
            'objective' => ['required'],
        ]);

        return Objective::create($data);
    }

    public function show(Objective $objective)
    {
        return $objective;
    }

    public function update(Request $request, Objective $objective)
    {
        $data = $request->validate([
            'tenant_id' => ['required', 'exists:tenants'],
            'negotiation_id' => ['required', 'exists:negotiations'],
            'priority' => ['required'],
            'objective' => ['required'],
        ]);

        $objective->update($data);

        return $objective;
    }

    public function destroy(Objective $objective)
    {
        $objective->delete();

        return response()->json();
    }
}
