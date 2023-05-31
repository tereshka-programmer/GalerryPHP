<?php

namespace App\Policies;

use App\Models\Picture;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, Picture $picture): bool
    {
        return $user->id == $picture->user_id;
    }
    public function update(User $user, Picture $picture): bool
    {
        return $user->id == $picture->user_id;
    }
    public function delete(User $user, Picture $picture): bool
    {
        return $user->id == $picture->user_id;
    }
}
