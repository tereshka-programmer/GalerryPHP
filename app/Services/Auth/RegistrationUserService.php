<?php

namespace App\Services\Auth;

use App\Enum\Role;

class RegistrationUserService extends StoreUserService
{
    public function handle(string $password, string $email, string $firstName, string $lastName, Role $role)
    {
        $this->store($firstName, $lastName, $role, password: $password, email: $email);
    }
}
