<?php

namespace App\Listeners;

use App\Events\PictureDeleted;
use App\Jobs\DeleteThumbnailsJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class DeleteThumbnails
{
    public function handle(PictureDeleted $event)
    {
        DeleteThumbnailsJob::dispatch($event->picture->file_path);
    }
}
