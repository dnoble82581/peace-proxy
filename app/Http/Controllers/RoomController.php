<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function index($roomId): View
    {
        $room = Room::with([
            'messages:id,message,room_id,tenant_id,created_at,updated_at,sent_at',
            'subject:id,name,address,city,state,zip,phone,tenant_id,room_id,weapons,weapons_details',
            'subject.demands:id,subject_id,tenant_id,type,deadline,description,title,status,notes',
            'subject.moodLogs:id,subject_id,tenant_id,mood,name,created_at',
            'subject.callLogs',
            'subject.warnings:id,subject_id,user_id,tenant_id,room_id,warning_type,warning',
            'subject.documents:id,documentable_id,filename,size,updated_at,extension,type,created_at',
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

    public function tacticalRoom($roomId)
    {
        $room = Room::with([
            'messages:id,message,room_id,senderable_id,senderable_type,created_at,updated_at',
            // Fetch necessary columns
            'messages.user:id,name', // Fetch user data for each message
            'subject:id,name,address,city,state,zip,phone,tenant_id,room_id,weapons,weapons_details',
            'subject.demands:id,subject_id,tenant_id,type,deadline,description,title,status,notes',
            'subject.moodLogs:id,subject_id,tenant_id,mood,name,created_at',
            'subject.callLogs',
            'subject.warnings:id,subject_id,user_id,tenant_id,room_id,warning_type,warning',
            'subject.documents:id,documentable_id,filename,size,updated_at,extension,type,created_at',
        ])->findOrFail($roomId);

        // Perform authorization check directly on the retrieved instance
        if (auth()->user()->cannot('view', $room)) {
            abort(403, 'Sorry, You are not authorized to view this room.');
        }

        Redis::set('room_id', $room->id);

        return view('pages.tactical', [
            'room' => $room,
        ]);
    }

    public function dispatchRoom($roomId)
    {
        return view('pages.dispatch');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'negotiation_id' => ['required', 'exists:negotiations'],
        ]);

        return Room::create($data);
    }

    public function show(Room $room)
    {
        return $room;
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'negotiation_id' => ['required', 'exists:negotiations'],
        ]);

        $room->update($data);

        return $room;
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return response()->json();
    }
}
