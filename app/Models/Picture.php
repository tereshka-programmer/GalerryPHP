<?php

namespace App\Models;

use App\Enum\PictureStatus;
use App\Enum\ReviewStatus;
use App\Events\PictureDeleted;
use App\Events\PictureStored;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Picture
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property string $file_path
 * @property string $description
 * @property string $title
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $userFavourites
 * @property-read int|null $user_favourites_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $waitingForApprovalReviews
 * @property-read int|null $waiting_for_approval_reviews_count
 * @method static \Database\Factories\PictureFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Picture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Picture query()
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereUserId($value)
 * @mixin \Eloquent
 */
class Picture extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'created' => PictureStored::class,
        'updated' => PictureStored::class,
        'deleted' => PictureDeleted::class,
    ];

    public function getPublicUrl()
    {
        return url()->to(Storage::url($this->file_path));
    }

    public function isPublished(): bool
    {
        return $this->status == PictureStatus::Published->value;
    }

    public function isDraft(): bool
    {
        return $this->status == PictureStatus::Draft->value;
    }
    public function isRevoked(): bool
    {
        return $this->status == PictureStatus::Revoked->value;
    }

    public function reviews(): HasMany
    {
        return $this->hasMany('App\Models\Review');
    }

    public function userFavourites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favourite_pictures')->withTimestamps();
    }

    public function likes(): MorphToMany
    {
        return $this->morphToMany(User::class, 'like', 'like');
    }

    public function waitingForApprovalReviews(): HasMany
    {
        return $this->hasMany('App\Models\Review')->where('status', ReviewStatus::WaitingForApproval->value)->orderByDesc('created_at');
    }

    public function checkFavouriteStatus(): bool
    {
        return $this->userFavourites()->where('id', auth()->id())->count() == 0;
    }

    public function wasLiked(Int $object): bool
    {
        return $this->likes()->where('user_id', auth()->id())->where('object', $object)->count() != 0;
    }

    public function likeCount(Int $object): int
    {
        return $this->likes()->where('user_id', auth()->id())->where('object')->count();
    }
}
