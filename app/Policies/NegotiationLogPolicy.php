<?php

namespace App\Policies;

use App\Models\NegotiationLog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NegotiationLogPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, NegotiationLog $negotiationLog): bool {}

    public function create(User $user): bool {}

    public function update(User $user, NegotiationLog $negotiationLog): bool {}

    public function delete(User $user, NegotiationLog $negotiationLog): bool {}

    public function restore(User $user, NegotiationLog $negotiationLog): bool {}

    public function forceDelete(User $user, NegotiationLog $negotiationLog): bool {}
}
