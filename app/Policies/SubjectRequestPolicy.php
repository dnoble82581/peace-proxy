<?php

namespace App\Policies;

use App\Models\SubjectRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectRequestPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, SubjectRequest $subjectRequest): bool {}

    public function create(User $user): bool {}

    public function update(User $user, SubjectRequest $subjectRequest): bool {}

    public function delete(User $user, SubjectRequest $subjectRequest): bool {}

    public function restore(User $user, SubjectRequest $subjectRequest): bool {}

    public function forceDelete(User $user, SubjectRequest $subjectRequest): bool {}
}
