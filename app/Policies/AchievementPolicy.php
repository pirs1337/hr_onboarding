<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class AchievementPolicy extends BasePolicy
{
    public function create(User $user)
    {
        return $this->hasRole($user, Role::ADMIN, Role::MANAGER);
    }

    public function delete(User $user)
    {
        return $this->hasRole($user, Role::ADMIN, Role::MANAGER);
    }

    public function update(User $user)
    {
        return $this->hasRole($user, Role::ADMIN, Role::MANAGER);
    }
}
