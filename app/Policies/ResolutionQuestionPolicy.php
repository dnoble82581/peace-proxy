<?php

namespace App\Policies;

use App\Models\ResolutionQuestion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResolutionQuestionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, ResolutionQuestion $resolutionQuestion): bool {}

    public function create(User $user): bool {}

    public function update(User $user, ResolutionQuestion $resolutionQuestion): bool {}

    public function delete(User $user, ResolutionQuestion $resolutionQuestion): bool {}

    public function restore(User $user, ResolutionQuestion $resolutionQuestion): bool {}

    public function forceDelete(User $user, ResolutionQuestion $resolutionQuestion): bool {}
}
