<?php

namespace App\Listeners;

use App\Events\PictureStored;
use App\Jobs\CreateThumbnailsJob;

class CreateThumbnails
{
    public function handle(PictureStored $event)
    {
        $filePath =  $event->picture->file_path;
        foreach (config('thumbnail.height') as $height) {
            CreateThumbnailsJob::dispatch($filePath, $height);
        }
    }
}
