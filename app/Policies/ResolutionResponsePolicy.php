<?php

namespace App\Policies;

use App\Models\ResolutionResponse;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResolutionResponsePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, ResolutionResponse $resolutionResponse): bool {}

    public function create(User $user): bool {}

    public function update(User $user, ResolutionResponse $resolutionResponse): bool {}

    public function delete(User $user, ResolutionResponse $resolutionResponse): bool {}

    public function restore(User $user, ResolutionResponse $resolutionResponse): bool {}

    public function forceDelete(User $user, ResolutionResponse $resolutionResponse): bool {}
}
