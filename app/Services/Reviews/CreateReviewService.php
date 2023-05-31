<?php

namespace App\Services\Reviews;

use App\Enum\ReviewStatus;
use App\Models\Review;
use App\Models\User;

class CreateReviewService
{
    public function handle(string $subject, string $message, ReviewStatus $status, int $pictureId, User $user): Review
    {
        $review = new Review();
        $review->email = $user->email;
        $review->user_id = $user->id;
        $review->picture_id = $pictureId;
        $review->subject = $subject;
        $review->message = $message;
        $review->status = $status->value;
        $review->save();
        return $review;
    }
}
