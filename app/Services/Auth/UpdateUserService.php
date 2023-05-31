<?php

namespace App\Services\Auth;

use App\Enum\Role;
use App\Models\User;

class UpdateUserService extends StoreUserService
{
    public function handle(string $firstName, string $lastName, Role $role, User $user)
    {
        $this->store($firstName, $lastName, $role, $user);
    }
}
