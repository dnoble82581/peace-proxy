<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaProvider;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SocialMediaProviderController extends Controller
{
    public function index(Request $request)
    {
        return SocialMediaProvider::query()
            ->select('id', 'platform_name', 'website_url')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('platform_name', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('platform_name', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->orderBy('platform_name')
            ->get()
            ->map(function (SocialMediaProvider $platform) {
                return $platform->only('platform_name', 'id', 'website_url');
            });
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
