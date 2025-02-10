<?php

namespace App\Traits;

trait UserPrivilegeTrait
{
    public function isAdmin(): bool
    {
        return $this->privileges == 'admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->privileges == 'super_admin';
    }
}
