<?php

namespace App\Http\Requests\Achievements;

use App\Http\Requests\Request;
use App\Services\AchievementService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseAchievementRequest extends Request
{
    protected function checkAchievementExists()
    {
        $achievement = app(AchievementService::class)->find($this->route('id'));

        if (empty($achievement)) {
            throw new NotFoundHttpException("Achievement doesn't exists");
        }
    }

    public function validateResolved()
    {
        $this->checkAchievementExists();

        parent::validateResolved();
    }
}
