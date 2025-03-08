<?php

namespace App\Policies;

use App\Models\TextMessage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TextMessagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, TextMessage $textMessage): bool {}

    public function create(User $user): bool {}

    public function update(User $user, TextMessage $textMessage): bool {}

    public function delete(User $user, TextMessage $textMessage): bool {}

    public function restore(User $user, TextMessage $textMessage): bool {}

    public function forceDelete(User $user, TextMessage $textMessage): bool {}
}
