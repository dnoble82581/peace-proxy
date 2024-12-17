<?php

namespace App\Policies;

use App\Models\CallLog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CallLogPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, CallLog $callLog): bool {}

    public function create(User $user): bool {}

    public function update(User $user, CallLog $callLog): bool {}

    public function delete(User $user, CallLog $callLog): bool {}

    public function restore(User $user, CallLog $callLog): bool {}

    public function forceDelete(User $user, CallLog $callLog): bool {}
}
