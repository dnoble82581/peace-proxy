<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        return Tenant::query()
            ->select('id', 'name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->orderBy('name')
            ->get()
            ->map(function (Tenant $tenant) {
                return $tenant->only('id', 'name');
            });
    }
}
