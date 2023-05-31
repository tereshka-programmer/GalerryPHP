<?php

namespace App\Services\Auth;

use App\Enum\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

abstract class StoreUserService
{
    public function store(string $firstName, string $lastName, Role $role, ?User $user = null, ?string $password = null, ?string $email = null): User
    {
        $user = $user ?: new User();
        if ($email) {
            $user->email = $email;
            $user->password = Hash::needsRehash($password) ? Hash::make($password) : $password;
        }
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->role = $role->value;

        $user->save();
        return $user;
    }
}
