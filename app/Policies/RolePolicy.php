<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class RolePolicy extends BasePolicy
{
    public function search(User $user)
    {
        return $this->hasRole($user, Role::ADMIN, Role::MANAGER);
    }
}
