<?php

namespace App\Policies;

use App\Models\Resolution;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResolutionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, Resolution $resolution): bool {}

    public function create(User $user): bool {}

    public function update(User $user, Resolution $resolution): bool {}

    public function delete(User $user, Resolution $resolution): bool {}

    public function restore(User $user, Resolution $resolution): bool {}

    public function forceDelete(User $user, Resolution $resolution): bool {}
}
