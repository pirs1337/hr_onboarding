<?php

namespace App\Services;

use RonasIT\Support\Services\EntityService;
use App\Repositories\AchievementRepository;

/**
 * @mixin AchievementRepository
 * @property AchievementRepository $repository
 */
class AchievementService extends EntityService
{
    protected $mediaService;

    public function __construct()
    {
        $this->mediaService = app(MediaService::class);

        $this->setRepository(AchievementRepository::class);
    }

    public function search($filters)
    {
        return $this->repository
            ->searchQuery($filters)
            ->filterByQuery(['script_id'])
            ->getSearchResults();
    }

    public function update($where, $data)
    {
        $originAchievement = $this->first($where);
        $updatedAchievement = $this->repository->update($where, $data);

        if ($updatedAchievement->wasChanged('incomplete_cover_id')) {
            $this->mediaService->delete($originAchievement->incomplete_cover_id);
        }

        if ($updatedAchievement->wasChanged('complete_cover_id')) {
            $this->mediaService->delete($originAchievement->complete_cover_id);
        }

        return $updatedAchievement;
    }
}
