<?php

namespace App\Http\Controllers;

use App\Models\AssociateImage;
use Illuminate\Http\Request;

class AssociateImageController extends Controller
{
    public function index()
    {
        return AssociateImage::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'associate_id' => ['required', 'exists:associates'],
            'image' => ['required'],
        ]);

        return AssociateImage::create($data);
    }

    public function show(AssociateImage $associateImage)
    {
        return $associateImage;
    }

    public function update(Request $request, AssociateImage $associateImage)
    {
        $data = $request->validate([
            'associate_id' => ['required', 'exists:associates'],
            'image' => ['required'],
        ]);

        $associateImage->update($data);

        return $associateImage;
    }

    public function destroy(AssociateImage $associateImage)
    {
        $associateImage->delete();

        return response()->json();
    }
}
