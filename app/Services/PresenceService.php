<?php

namespace App\Services;

class PresenceService
{
    public function handlePresenceUsers(array $users): array
    {
        return collect($users)->map(function ($user) {
            return [
                'id' => $user['id'],
                'name' => $user['name'],
                'avatar' => $user['avatar'],
                'last_active' => now(), // Initialize timestamp
            ];
        })->toArray();
    }
}
