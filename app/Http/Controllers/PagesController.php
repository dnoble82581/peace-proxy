<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

class PagesController extends Controller
{
    public function editUser(int $userId)
    {
        if ($userId) {
            $user = User::findorFail($userId);
        }

        return view('pages.update-user')->with('user', $user);
    }

    public function command()
    {
        return view('pages.command');
    }

    public function negotiationRoom($roomId): View
    {
        $room = Room::with([
            'messages:id,message,created_at,room_id,user_id', // Fetch necessary columns
            'messages.user:id,name', // Fetch user data for each message
            'subject:id,name,tenant_id,room_id',
            'subject.hooks', // Fetch room subject
            'subject.demands',
        ])->findOrFail($roomId);

        // Perform authorization check directly on the retrieved instance
        if (auth()->user()->cannot('view', $room)) {
            abort(403, 'Sorry, You are not authorized to view this room.');
        }

        Redis::set('room_id', $room->id);

        return view('pages.negotiation-room', [
            'room' => $room,
        ]);
    }
}
