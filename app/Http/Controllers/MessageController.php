<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Message::class);

        return Message::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Message::class);

        $data = $request->validate([
            'user_id' => ['required', 'exists:users'],
            'tenant_id' => ['required', 'exists:tenants'],
            'room_id' => ['required', 'exists:rooms'],
            'message' => ['required'],
        ]);

        return Message::create($data);
    }

    public function show(Message $message)
    {
        $this->authorize('view', $message);

        return $message;
    }

    public function update(Request $request, Message $message)
    {
        $this->authorize('update', $message);

        $data = $request->validate([
            'user_id' => ['required', 'exists:users'],
            'tenant_id' => ['required', 'exists:tenants'],
            'room_id' => ['required', 'exists:rooms'],
            'message' => ['required'],
        ]);

        $message->update($data);

        return $message;
    }

    public function destroy(Message $message)
    {
        $this->authorize('delete', $message);

        $message->delete();

        return response()->json();
    }
}
