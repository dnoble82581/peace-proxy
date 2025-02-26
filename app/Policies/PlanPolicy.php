<?php

namespace App\Policies;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['Tactical Lead', 'Incident Command']);
    }

    public function view(User $user, Plan $plan): bool {}

    public function create(User $user): bool {}

    public function update(User $user, Plan $plan): bool {}

    public function delete(User $user, Plan $plan): bool {}

    public function attach(User $user): bool
    {
        return in_array($user->role, ['Tactical Lead', 'Incident Command']);
    }

    public function detach(User $user): bool
    {
        return in_array($user->role, ['Tactical Lead', 'Incident Command']);
    }

    public function restore(User $user, Plan $plan): bool {}

    public function forceDelete(User $user, Plan $plan): bool {}
}
