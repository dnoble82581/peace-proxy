<?php

namespace App\Http\Controllers;

use App\Models\Hostage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class HostageController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Hostage::class);

        return Hostage::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Hostage::class);

        $data = $request->validate([
            'negotiation_id' => ['required', 'exists:negotiations'],
            'subject_id' => ['required', 'exists:subjects'],
            'room_id' => ['required', 'exists:rooms'],
            'image_path' => ['nullable'],
            'name' => ['required'],
            'phone' => ['nullable'],
            'email' => ['nullable', 'email', 'max:254'],
            'race' => ['nullable'],
            'gender' => ['nullable'],
            'address' => ['nullable'],
            'city' => ['nullable'],
            'state' => ['nullable'],
            'zipcode' => ['nullable'],
            'dob' => ['nullable'],
            'age' => ['nullable', 'integer'],
            'children' => ['nullable', 'integer'],
            'veteran' => ['nullable'],
            'facebook_url' => ['nullable'],
            'x_url' => ['nullable'],
            'instagram_url' => ['nullable'],
            'youtube_url' => ['nullable'],
            'snapchat_url' => ['nullable'],
            'notes' => ['nullable'],
            'physical_description' => ['nullable'],
            'relationship_to_subject' => ['nullable'],
            'weapons' => ['nullable'],
            'highest_education' => ['nullable'],
            'medical_issues' => ['nullable'],
            'mental_health_history' => ['nullable'],
            'substance_abuse' => ['nullable'],
        ]);

        return Hostage::create($data);
    }

    public function show(Hostage $hostage)
    {
        $this->authorize('view', $hostage);

        return $hostage;
    }

    public function update($roomId)
    {
        return view('pages.hostage.edit-hostage')->with('roomId', $roomId);

        //        $this->authorize('update', $hostage);
        //
        //        $data = $request->validate([
        //            'negotiation_id' => ['required', 'exists:negotiations'],
        //            'subject_id' => ['required', 'exists:subjects'],
        //            'room_id' => ['required', 'exists:rooms'],
        //            'image_path' => ['nullable'],
        //            'name' => ['required'],
        //            'phone' => ['nullable'],
        //            'email' => ['nullable', 'email', 'max:254'],
        //            'race' => ['nullable'],
        //            'gender' => ['nullable'],
        //            'address' => ['nullable'],
        //            'city' => ['nullable'],
        //            'state' => ['nullable'],
        //            'zipcode' => ['nullable'],
        //            'dob' => ['nullable'],
        //            'age' => ['nullable', 'integer'],
        //            'children' => ['nullable', 'integer'],
        //            'veteran' => ['nullable'],
        //            'facebook_url' => ['nullable'],
        //            'x_url' => ['nullable'],
        //            'instagram_url' => ['nullable'],
        //            'youtube_url' => ['nullable'],
        //            'snapchat_url' => ['nullable'],
        //            'notes' => ['nullable'],
        //            'physical_description' => ['nullable'],
        //            'relationship_to_subject' => ['nullable'],
        //            'weapons' => ['nullable'],
        //            'highest_education' => ['nullable'],
        //            'medical_issues' => ['nullable'],
        //            'mental_health_history' => ['nullable'],
        //            'substance_abuse' => ['nullable'],
        //        ]);
        //
        //        $hostage->update($data);
        //
        //        return $hostage;
    }

    public function destroy(Hostage $hostage)
    {
        $this->authorize('delete', $hostage);

        $hostage->delete();

        return response()->json();
    }
}
