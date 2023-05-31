<?php

namespace App\Http\Controllers;

use App\Enum\ReviewStatus;
use App\Http\Requests\ReviewPostRequest;
use App\Models\Picture;
use App\Models\Review;
use App\Services\Reviews\CreateReviewService;
use App\Services\Reviews\DecideReviewService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UsersReviewsController extends Controller
{
    public function add(ReviewPostRequest $request, Picture $picture, CreateReviewService $createReviewService): RedirectResponse
    {
        $createReviewService->handle(
            $request->input('subject'),
            $request->input('message'),
            ReviewStatus::WaitingForApproval,
            $picture->id,
            auth()->user()
        );
        return redirect()->route('picture.preview', $picture);
    }

    public function publish(Review $review, DecideReviewService $decideReviewService): RedirectResponse
    {
        $decideReviewService->handle($review, ReviewStatus::Published);
        return redirect()->back();
    }

    public function hide(Review $review, DecideReviewService $decideReviewService): RedirectResponse
    {
        $decideReviewService->handle($review, ReviewStatus::Revoked);
        return redirect()->back();
    }

    public function indexWaitingReviews(Picture $picture): View
    {
        $reviews = Review::where('picture_id', $picture->id)->where('status', ReviewStatus::WaitingForApproval->value)->orderByDesc('created_at')->paginate(config('pagination.default.count'));

        return view('picture-reviews', ['picture' => $picture], ['reviews' => $reviews]);
    }
}
