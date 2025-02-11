<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Redis;

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

    public function shell()
    {
        return view('pages.shell.index');
    }

    public function tacticalRoom()
    {
        $roomId = Redis::get('room_id');
        $room = Room::query()
            ->with('subject', 'associates')
            ->findOrFail($roomId);

        return view('pages.tactical')->with('room', $room);
    }
}
