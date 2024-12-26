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

    public function store(Request $request)
    {
        $this->authorize('create', Subject::class);

        $data = $request->validate([
            'name' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email', 'max:254'],
            'race' => ['required'],
            'gender' => ['required'],
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'zip' => ['required'],
            'date_of_birth' => ['required', 'date'],
            'age' => ['required', 'integer'],
            'children' => ['required', 'integer'],
            'veteran' => ['required'],
            'highest_education' => ['required'],
            'substance_abuse' => ['required'],
            'mental_health_history' => ['required'],
            'physical_description' => ['required'],
            'notes' => ['required'],
            'facebook_url' => ['required'],
            'x_url' => ['required'],
            'instagram_url' => ['required'],
            'snapchat_url' => ['required'],
            'negotiation_id' => ['required', 'exists:negotiations'],
            'room_id' => ['required', 'exists:rooms'],
        ]);

        return Subject::create($data);
    }

    public function show(Subject $subject)
    {
        $this->authorize('view', $subject);

        return $subject;
    }

    public function update(Room $room, Subject $subject)
    {
        return view('subject.edit');
    }

    public function destroy(Subject $subject)
    {
        $this->authorize('delete', $subject);

        $subject->delete();

        return response()->json();
    }
}
