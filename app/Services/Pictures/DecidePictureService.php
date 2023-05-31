<?php

namespace App\Services\Pictures;

use App\Enum\PictureStatus;
use App\Models\Picture;

class DecidePictureService
{
    public function handle(Picture $picture, PictureStatus $status): Picture
    {
        $picture->status = $status->value;
        $picture->save();

        return $picture;
    }
}
