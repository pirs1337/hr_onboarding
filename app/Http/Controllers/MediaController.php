<?php

namespace App\Http\Controllers;

use App\Http\Requests\Media\CreateMediaRequest;
use App\Http\Requests\Media\DeleteMediaRequest;
use App\Http\Requests\Media\GetMediaRequest;
use App\Services\MediaService;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    public function create(CreateMediaRequest $request, MediaService $service)
    {
        $file = $request->file('file');
        $data = $request->validated();

        $content = file_get_contents($file->getPathname());

        $media = $service->create($content, $file->getClientOriginalName(), $data);

        return response()->json($media);
    }

    public function delete(DeleteMediaRequest $request, MediaService $service, $id)
    {
        $service->delete($id);

        return response('', Response::HTTP_NO_CONTENT);
    }

    public function getById(GetMediaRequest $request, MediaService $service, $id)
    {
        $result = $service->find($id);

        return response()->json($result);
    }

    public function getContentById(GetMediaRequest $request, MediaService $service, $id)
    {
        $result = $service->getContent($id);

        return redirect($result);
    }
}
