<?php

namespace App\Services\Thumbnail;

use Illuminate\Support\Facades\Storage;

class DeleteThumbnailService
{
    public function handle(string $filePath): void
    {
        $directoryPath = config('thumbnail.folder') . pathinfo($filePath, PATHINFO_FILENAME);
        Storage::deleteDirectory($directoryPath);
    }
}
