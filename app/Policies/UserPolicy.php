<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class UserPolicy extends BasePolicy
{
    public function create(User $user): bool
    {
        return $this->hasRole($user, Role::ADMIN, Role::MANAGER);
    }

    public function search(User $user): bool
    {
        return $this->hasRole($user, Role::ADMIN, Role::MANAGER);
    }

    public function update(User $user): bool
    {
        return $this->hasRole($user, Role::ADMIN, Role::MANAGER);
    }
}
