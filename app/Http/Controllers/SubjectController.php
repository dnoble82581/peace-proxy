<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Subject;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Subject::class);

        return Subject::all();
    }

    public function store(Request $request) {}

    public function show($roomId)
    {
        $room = Room::findOrFail($roomId);
        $subject = $room->subject;

        return view('pages.subject.show-subject')->with('subject', $subject);
    }

    public function update(int $roomId)
    {
        return view('pages.subject.edit-subject')->with('roomId', $roomId);
    }

    public function destroy(Subject $subject)
    {
        $this->authorize('delete', $subject);

        $subject->delete();

        return response()->json();
    }
}
