<?php

namespace App\Services\FavouritesPictures;

use App\Models\Picture;

class CreateFavouriteService
{
    public function handle(Picture $picture, int $userId)
    {
        $picture->userFavourites()->attach($userId);
    }
}
