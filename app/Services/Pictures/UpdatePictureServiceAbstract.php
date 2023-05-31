<?php

namespace App\Services\Pictures;

use App\Models\Picture;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class UpdatePictureServiceAbstract extends StorePictureServiceAbstract
{
    public function handle(string $title, string $description, int $userId, Picture $picture, ?UploadedFile $file = null)
    {
        $this->store($title, $description, $userId, $picture, $file);
    }
}
