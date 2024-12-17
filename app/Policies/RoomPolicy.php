<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool {}

    public function view(User $user, Room $room): bool
    {
        return $user->tenant_id === $room->tenant_id;
    }

    public function create(User $user): bool {}

    public function update(User $user, Room $room): bool {}

    public function delete(User $user, Room $room): bool {}

    public function restore(User $user, Room $room): bool {}

    public function forceDelete(User $user, Room $room): bool {}
}
