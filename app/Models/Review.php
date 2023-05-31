<?php

namespace App\Models;

use App\Enum\ReviewStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\Review
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property string $email
 * @property string $subject
 * @property int $picture_id
 * @property string $message
 * @property int $score
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $likes
 * @property-read int|null $likes_count
 * @method static \Database\Factories\ReviewFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review wherePictureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUserId($value)
 * @mixin \Eloquent
 */
class Review extends Model
{
    use HasFactory;

    public function likes(): MorphToMany
    {
        return $this->morphToMany(User::class, 'like', 'like');
    }
    public function isWaitingForApproval(): bool
    {
        return $this->status == ReviewStatus::WaitingForApproval->value;
    }
    public function isPublished(): bool
    {
        return $this->status == ReviewStatus::Published->value;
    }
    public function isRevoked(): bool
    {
        return $this->status == ReviewStatus::Revoked->value;
    }

    public function wasLiked(Int $object): bool
    {
        return $this->likes()->where('user_id', \auth()->id())->where('object', $object)->count() != 0;
    }

    public function likeCount(Int $object): bool
    {
        return $this->morphToMany(User::class, 'like', 'like')->count();
    }
}
