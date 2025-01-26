<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaProvider;
use Illuminate\Http\Request;

class SocialMediaProviderController extends Controller
{
    public function index()
    {
        return SocialMediaProvider::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'platform_name' => ['required'],
            'website_url' => ['required'],
        ]);

        return SocialMediaProvider::create($data);
    }

    public function show(SocialMediaProvider $socialMediaProvider)
    {
        return $socialMediaProvider;
    }

    public function update(Request $request, SocialMediaProvider $socialMediaProvider)
    {
        $data = $request->validate([
            'platform_name' => ['required'],
            'website_url' => ['required'],
        ]);

        $socialMediaProvider->update($data);

        return $socialMediaProvider;
    }

    public function destroy(SocialMediaProvider $socialMediaProvider)
    {
        $socialMediaProvider->delete();

        return response()->json();
    }
}
