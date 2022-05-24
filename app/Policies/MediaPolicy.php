<?php

namespace App\Policies;

use App\Models\Media;
use App\Models\Role;
use App\Models\User;

class MediaPolicy extends BasePolicy
{
    public function create(User $user)
    {
        return $this->hasRole($user, Role::ADMIN, Role::MANAGER);
    }

    public function delete(User $user, Media $media)
    {
        return $this->isOwner($media, $user);
    }
}
