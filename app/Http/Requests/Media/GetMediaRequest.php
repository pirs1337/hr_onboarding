<?php

namespace App\Http\Requests\Media;

use App\Http\Requests\Request;
use App\Services\MediaService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetMediaRequest extends Request
{
    private function checkMediaExists()
    {
       $media = app(MediaService::class)->find($this->route('id'));

        if (empty($media)) {
            throw new NotFoundHttpException("Media doesn't exists");
        }
    }

    public function validateResolved()
    {
        $this->checkMediaExists();

        parent::validateResolved();
    }
}
