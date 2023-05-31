<?php

namespace App\Services\Pictures;

use App\Models\Picture;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class CreatePictureServiceAbstract extends StorePictureServiceAbstract
{
    public function handle(string $title, string $description, UploadedFile $file, int $user)
    {
        $this->store($title, $description, $user, file: $file);
    }
}
