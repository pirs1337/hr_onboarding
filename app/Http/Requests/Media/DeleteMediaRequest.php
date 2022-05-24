<?php

namespace App\Http\Requests\Media;

use App\Http\Requests\Request;
use App\Services\MediaService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteMediaRequest extends Request
{
    private $media;

    public function authorize(): bool
    {
        return $this->user()->can('delete', $this->media);
    }

    private function checkMediaExists()
    {
        if (empty($this->media)) {
            throw new NotFoundHttpException("Media doesn't exists");
        }
    }

    public function validateResolved()
    {
        $this->media = app(MediaService::class)->find($this->route('id'));

        $this->checkMediaExists();

        parent::validateResolved();
    }
}
