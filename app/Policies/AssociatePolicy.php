<?php

namespace App\Policies;

use App\Models\Associate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssociatePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, Associate $associate): bool {}

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Associate $associate): bool {}

    public function delete(User $user, Associate $associate): bool {}

    public function restore(User $user, Associate $associate): bool {}

    public function forceDelete(User $user, Associate $associate): bool {}
}
