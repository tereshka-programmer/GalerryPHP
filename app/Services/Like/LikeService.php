<?php

namespace App\Services\Like;

use function auth;
use function now;

class LikeService
{
    public function like($object)
    {
        if ($object->wasLiked(-1)) {
            $this->deleteDislike($object);
        } elseif ($object->wasLiked(1)) {
            $this->deleteLike($object);
            //return true чтобы остановить выполнение функции like
            return true;
        }
        $object->likes()->attach(auth()->id(), ['object' => 1, 'created_at' => now(), 'updated_at' => now()]);
    }

    public function deleteLike($object)
    {
        $object->likes()->detach(auth()->id(), ['object' => 1]);
    }

    public function dislike($object)
    {
        if ($object->wasLiked(1)) {
            $this->deleteLike($object);
        } elseif ($object->wasLiked(-1)) {
            $this->deleteDislike($object);
            //return true чтобы остановить выполнение функции dislike
            return true;
        }

        $object->likes()->attach(auth()->id(), ['object' => -1, 'created_at' => now(), 'updated_at' => now()]);
    }

    public function deleteDislike($object)
    {
        $object->likes()->detach(auth()->id(), ['object' => -1]);
    }
}
