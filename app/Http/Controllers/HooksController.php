<?php

namespace App\Http\Controllers;

use App\Models\Hook;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class HooksController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Hook::class);

        return Hook::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Hook::class);

        $data = $request->validate([
            'subject_id' => ['required', 'exists:subjects'],
            'tenant_id' => ['required', 'exists:tenants'],
            'title' => ['required'],
            'description' => ['required'],
        ]);

        return Hook::create($data);
    }

    public function show(Hook $hooks)
    {
        $this->authorize('view', $hooks);

        return $hooks;
    }

    public function update(Request $request, Hook $hooks)
    {
        $this->authorize('update', $hooks);

        $data = $request->validate([
            'subject_id' => ['required', 'exists:subjects'],
            'tenant_id' => ['required', 'exists:tenants'],
            'title' => ['required'],
            'description' => ['required'],
        ]);

        $hooks->update($data);

        return $hooks;
    }

    public function destroy(Hook $hooks)
    {
        $this->authorize('delete', $hooks);

        $hooks->delete();

        return response()->json();
    }
}
