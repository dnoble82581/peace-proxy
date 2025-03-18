<?php

namespace App\Http\Controllers;

use App\Models\NegotiationLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class NegotiationLogController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', NegotiationLog::class);

        return NegotiationLog::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', NegotiationLog::class);

        $data = $request->validate([
            'action' => ['required'],
            'loggable' => ['required'],
            'data' => ['nullable'],
        ]);

        return NegotiationLog::create($data);
    }

    public function show(NegotiationLog $negotiationLog)
    {
        $this->authorize('view', $negotiationLog);

        return $negotiationLog;
    }

    public function update(Request $request, NegotiationLog $negotiationLog)
    {
        $this->authorize('update', $negotiationLog);

        $data = $request->validate([
            'action' => ['required'],
            'loggable' => ['required'],
            'data' => ['nullable'],
        ]);

        $negotiationLog->update($data);

        return $negotiationLog;
    }

    public function destroy(NegotiationLog $negotiationLog)
    {
        $this->authorize('delete', $negotiationLog);

        $negotiationLog->delete();

        return response()->json();
    }
}
