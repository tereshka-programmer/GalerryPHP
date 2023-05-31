<?php

namespace App\Services\Pictures;

use App\Models\Picture;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DeletePictureService
{
    public function handle(Picture $picture)
    {
        Storage::delete($picture->file_path);
        $picture->delete();
    }
}
