<?php

namespace App\Enums;

enum UserPrivileges: string
{
    case Admin = 'admin';
    case User = 'user';

    public function metaData(): array
    {
        return match ($this) {
            self::Admin => ['description' => 'Has full control and management privileges.'],
            self::User => ['description' => 'Regular user with limited access privileges.'],
        };
    }
}
