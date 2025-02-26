<?php

namespace App\Policies;

use App\Models\Response;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResponsePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, Response $response): bool {}

    public function create(User $user): bool
    {
        return in_array($user->role, ['Tactical Lead', 'Incident Command']);
    }

    public function update(User $user, Response $response): bool {}

    public function delete(User $user, Response $response): bool {}

    public function restore(User $user, Response $response): bool {}

    public function forceDelete(User $user, Response $response): bool {}
}
