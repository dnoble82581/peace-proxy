<?php

namespace App\Policies;

use App\Models\MoodLog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MoodLogPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, MoodLog $moodLog): bool {}

    public function create(User $user): bool {}

    public function update(User $user, MoodLog $moodLog): bool {}

    public function delete(User $user, MoodLog $moodLog): bool {}

    public function restore(User $user, MoodLog $moodLog): bool {}

    public function forceDelete(User $user, MoodLog $moodLog): bool {}
}
