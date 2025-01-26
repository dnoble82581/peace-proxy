<?php

namespace App\Http\Controllers;

use App\Models\AssociateRelationship;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AssociateRelationshipController extends Controller
{
    public function index(Request $request)
    {
        return AssociateRelationship::query()
            ->select('id', 'relationship', 'description')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('relationship', 'like', "%{$request->search}%")
                    ->Orwhere('description', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('relationship', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->orderBy('relationship')
            ->get()
            ->map(function (AssociateRelationship $relationship) {
                return $relationship->only('relationship', 'id', 'description');
            });
    }
}
