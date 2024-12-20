<?php

namespace App\Policies;

use App\Models\Demand;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DemandPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, Demand $demand): bool
    {
        return $user->tenant_id === $demand->tenant_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Demand $demand): bool
    {
        return $user->tenant_id === $demand->tenant_id;
    }

    public function delete(User $user, Demand $demand): bool
    {
        return $user->tenant_id === $demand->tenant_id;
    }

    public function restore(User $user, Demand $demand): bool {}

    public function forceDelete(User $user, Demand $demand): bool {}
}
