<?php

namespace App\Services\Thumbnail;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CreateThumbnailService
{
    public function handle(string $filePath, int $height): void
    {
        $directoryPath = config('thumbnail.folder') . pathinfo($filePath, PATHINFO_FILENAME);
        $thumbnail = Image::make(Storage::path($filePath));
        $thumbnail->fit(null, height: $height);
        Storage::makeDirectory($directoryPath);

        $thumbnail->save(Storage::path($directoryPath.'/'. $height.'.'.  pathinfo($filePath, PATHINFO_EXTENSION)));
    }
}
