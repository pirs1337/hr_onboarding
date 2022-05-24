<?php

namespace App\Http\Controllers;

use App\Http\Requests\Achievements\CreateAchievementRequest;
use App\Http\Requests\Achievements\UpdateAchievementRequest;
use App\Http\Requests\Achievements\DeleteAchievementRequest;
use App\Http\Requests\Achievements\GetAchievementRequest;
use App\Http\Requests\Achievements\SearchAchievementsRequest;
use App\Services\AchievementService;
use Symfony\Component\HttpFoundation\Response;

class AchievementController extends Controller
{
    public function create(CreateAchievementRequest $request, AchievementService $service)
    {
        $data = $request->onlyValidated();

        $result = $service->create($data);

        return response()->json($result);
    }

    public function get(GetAchievementRequest $request, AchievementService $service, $id)
    {
        $result = $service->find($id);

        return response()->json($result);
    }

    public function search(SearchAchievementsRequest $request, AchievementService $service)
    {
        $result = $service->search($request->onlyValidated());

        return response()->json($result);
    }

    public function update(UpdateAchievementRequest $request, AchievementService $service, $id)
    {
        $service->update($id, $request->onlyValidated());

        return response('', Response::HTTP_NO_CONTENT);
    }

    public function delete(DeleteAchievementRequest $request, AchievementService $service, $id)
    {
        $service->delete($id);

        return response('', Response::HTTP_NO_CONTENT);
    }

}
