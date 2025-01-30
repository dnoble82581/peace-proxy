<?php

namespace App\Traits;

trait UserRoleTrait
{
    public function isAdmin(): bool
    {
        return $this->role == 'admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role == 'super_admin';
    }

    public function getRoleName()
    {
        $role = $this->getRoleNames()->first();
        str_replace('-', ' ', $role);

        return $role;
    }
}
