<?php

namespace App\Http\Controllers;

use App\Models\Associate;
use App\Models\Room;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AssociateController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Associate::class);

        return Associate::all();
    }

    public function store(Room $room)
    {
        return view('pages.associate.create-associate')->with('roomId', $room->id);
    }

    public function show($roomId, $associateId)
    {
        $associate = Associate::findOrFail($associateId);

        return view('pages.associate.show-associate')->with('associate', $associate);
    }

    public function update($roomId, Associate $associate)
    {
        return view('pages.associate.edit-associate')->with('roomId', $roomId)->with('associate', $associate);

    }

    public function destroy(Associate $associate)
    {
        $this->authorize('delete', $associate);

        $associate->delete();

        return response()->json();
    }
}
