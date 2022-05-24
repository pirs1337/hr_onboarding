<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
{
    use HandlesAuthorization;

    protected function isOwner($entity, $user, $ownerField = 'user_id')
    {
        return $user->id === $entity->{$ownerField};
    }

    protected function hasRole($user, ...$roles)
    {
        return in_array($user->role_id, $roles);
    }
}
