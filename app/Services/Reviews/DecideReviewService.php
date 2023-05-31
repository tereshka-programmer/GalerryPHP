<?php

namespace App\Services\Reviews;

use App\Enum\ReviewStatus;
use App\Models\Review;

class DecideReviewService
{
    public function handle(Review $review, ReviewStatus $status): Review
    {
        $review->status = $status->value;
        $review->save();

        return $review;
    }
}
