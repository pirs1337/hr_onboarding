<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use RonasIT\Support\Services\EntityService;
use App\Repositories\ScriptRepository;

class ScriptService extends EntityService
{
    protected $mediaService;

    public function __construct()
    {
        $this->mediaService = app(MediaService::class);

        $this->setRepository(ScriptRepository::class);
    }

    public function search($filters): LengthAwarePaginator
    {
        $relations = (empty($filters['with']) ? null : $filters['with']);

        return $this->repository
            ->with($relations)
            ->searchQuery($filters)
            ->filterByQuery(['title'])
            ->getSearchResults();
    }

    public function update($where, $data)
    {
        $originScript = $this->first($where);
        $updatedScript = $this->repository->update($where, $data);

        if ($updatedScript->wasChanged('cover_id')) {
            $this->mediaService->delete($originScript->cover_id);
        }

        return $updatedScript;
    }
}
