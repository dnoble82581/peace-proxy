<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserAvatarService
{
    public function getAvatarUrl(User $user): string
    {
        if ($user->avatar) {
            return Storage::disk('s3-public')->url($user->avatar);
        }

        return 'https://api.dicebear.com/9.x/initials/svg?seed='.$user->name;
    }
}
