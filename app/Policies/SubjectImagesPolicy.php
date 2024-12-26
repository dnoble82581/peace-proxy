<?php

namespace App\Policies;

use App\Models\SubjectImages;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectImagesPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, SubjectImages $subjectImages): bool {}

    public function create(User $user): bool {}

    public function update(User $user, SubjectImages $subjectImages): bool {}

    public function delete(User $user, SubjectImages $subjectImages): bool {}

    public function restore(User $user, SubjectImages $subjectImages): bool {}

    public function forceDelete(User $user, SubjectImages $subjectImages): bool {}
}
