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

    public function editSubject($roomId)
    {
        return view('pages.subject.edit-subject')->with('roomId', $roomId);
    }

    public function command()
    {
        return view('pages.command');
    }

    public function tacticalRoom()
    {
        $roomId = Redis::get('room_id');
        $room = Room::query()
            ->with('subject', 'associates')
            ->findOrFail($roomId);

        return view('pages.tactical')->with('room', $room);
    }

    public function negotiationRoom($roomId): View
    {
        $room = Room::with([
            'messages:id,message,created_at,room_id,user_id,updated_at', // Fetch necessary columns
            'messages.user:id,name', // Fetch user data for each message
            'subject:id,name,address,city,state,zip,phone,tenant_id,room_id,facebook_url,x_url,instagram_url,snapchat_url,youtube_url,weapons,weapons_details',
            'subject.demands:id,subject_id,tenant_id,type,deadline,description,title,status,notes',
            'subject.moodLogs:id,subject_id,tenant_id,mood,name,created_at',
            'subject.callLogs',
            'subject.warnings:id,subject_id,user_id,tenant_id,room_id,warning_type,warning',
            'subject.associates',
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
