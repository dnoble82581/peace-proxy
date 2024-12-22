<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomUser;
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
            'subject:id,name,address,city,state,zip,phone,tenant_id,room_id,facebook_url,x_url,instagram_url,snapchat_url',
            'subject.demands:id,subject_id,tenant_id,type,deadline,description,title,status,notes',
            'subject.moodLogs:id,subject_id,tenant_id,mood,name',
        ])->findOrFail($roomId);

        // Perform authorization check directly on the retrieved instance
        if (auth()->user()->cannot('view', $room)) {
            abort(403, 'Sorry, You are not authorized to view this room.');
        }

        RoomUser::updateOrCreate([
            'room_id' => $room->id,
            'tenant_id' => auth()->user()->tenant_id,
            'user_id' => auth()->user()->id,
            'role' => 'Primary Negotiator',
        ]);

        Redis::set('room_id', $room->id);

        return view('pages.negotiation-room', [
            'room' => $room,
        ]);
    }
}
