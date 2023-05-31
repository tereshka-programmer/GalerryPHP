<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\Review;
use App\Services\Like\LikeService;
use Illuminate\Http\RedirectResponse;

class LikeController extends Controller
{
    public function likePicture(Picture $picture, LikeService $likeService): RedirectResponse
    {
        $likeService->like($picture);
        return redirect()->route('home');
    }

    public function deleteLikePicture(Picture $picture, LikeService $likeService): RedirectResponse
    {
        $likeService->deleteLike($picture);

        return redirect()->route('home');
    }

    public function dislikePicture(Picture $picture, LikeService $likeService): RedirectResponse
    {
        $likeService->dislike($picture);
        return redirect()->route('home');
    }

    public function deleteDislikePicture(Picture $picture, LikeService $likeService): RedirectResponse
    {
        $likeService->deleteDislike($picture);
        return redirect()->route('home');
    }

    public function likeReview(Review $review, LikeService $likeService): RedirectResponse
    {
        $likeService->like($review);

        return redirect()->route('picture.preview', $review->picture_id);
    }

    public function deleteLikeReview(Review $review, Picture $picture, LikeService $likeService): RedirectResponse
    {
        $likeService->deleteLike($review);

        return redirect()->route('picture.preview', $picture);
    }

    public function dislikeReview(Review $review, LikeService $likeService): RedirectResponse
    {
        $likeService->dislike($review);

        return redirect()->route('picture.preview', $review->picture_id);
    }

    public function deleteDislikeReview(Review $review, Picture $picture, LikeService $likeService): RedirectResponse
    {
        $likeService->deleteDislike($review);

        return redirect()->route('picture.preview', $picture);
    }
}
