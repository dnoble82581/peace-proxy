<?php

namespace App\Http\Controllers;

use App\Models\TextMessage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TextMessageController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', TextMessage::class);

        return TextMessage::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', TextMessage::class);

        $data = $request->validate([
            'sender' => ['required'],
            'recipient' => ['required'],
            'message_content' => ['required'],
            'message_status' => ['required'],
            'message_type' => ['required'],
            'message_id' => ['nullable'],
            'sent_at' => ['nullable', 'date'],
        ]);

        return TextMessage::create($data);
    }

    public function show(TextMessage $textMessage)
    {
        $this->authorize('view', $textMessage);

        return $textMessage;
    }

    public function update(Request $request, TextMessage $textMessage)
    {
        $this->authorize('update', $textMessage);

        $data = $request->validate([
            'sender' => ['required'],
            'recipient' => ['required'],
            'message_content' => ['required'],
            'message_status' => ['required'],
            'message_type' => ['required'],
            'message_id' => ['nullable'],
            'sent_at' => ['nullable', 'date'],
        ]);

        $textMessage->update($data);

        return $textMessage;
    }

    public function destroy(TextMessage $textMessage)
    {
        $this->authorize('delete', $textMessage);

        $textMessage->delete();

        return response()->json();
    }
}
