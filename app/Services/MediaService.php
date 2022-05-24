<?php

namespace App\Services;

use App\Repositories\MediaRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RonasIT\Support\Services\EntityService;
use RonasIT\Support\Traits\FilesUploadTrait;

class MediaService extends EntityService
{
    use FilesUploadTrait;

    public function __construct()
    {
        $this->setRepository(MediaRepository::class);
    }

    public function create($content, $fileName, $data = [])
    {
        $path = $this->saveFile($fileName, $content);
        $data['name'] = $path;
        $data['link'] = '';
        $data['user_id'] = Auth::id();

        return $this->repository->create($data);
    }

    public function delete($where)
    {
        DB::transaction(function () use ($where) {
            $media = $this->first($where);

            if (!empty($media)) {
                $path = $media->name;

                if (!$this->isCloudStorage()) {
                    $path = $this->getFilePathFromUrl($path);
                }

                $this->repository->delete($where);

                Storage::delete($path);
            }
        });
    }

    public function getContent($where)
    {
        $media = $this->first($where);

        if ($this->isCloudStorage()) {
            return Storage::temporaryUrl($media->name, now()->addMinutes(config('defaults.media_temp_link_lifetime')));
        }

        $path = $this->getFilePathFromUrl($media->name);

        return Storage::url($path);
    }

    private function isCloudStorage()
    {
        $currentDisk = config('filesystems.default');
        $cloudDisks = ['gcs', 'aws'];

        return in_array($currentDisk, $cloudDisks);
    }
}
