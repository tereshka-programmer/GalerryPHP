<?php

namespace App\Services\FavouritesPictures;

use App\Models\Picture;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeleteFavouriteService
{
    public function handle(Picture $picture, User $user)
    {
        $user->myFavouritesPictures()->detach($picture->id);
    }
}
