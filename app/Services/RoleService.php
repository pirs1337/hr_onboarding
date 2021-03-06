<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use RonasIT\Support\Services\EntityService;

class RoleService extends EntityService
{
    public function __construct()
    {
        $this->setRepository(RoleRepository::class);
    }

    public function search($filters)
    {
        return $this->repository
            ->searchQuery($filters)
            ->getSearchResults();
    }
}
