<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;

class AuthenticationUserService
{
    public function handle(string $email, string $password)
    {
        Auth::attempt(['email' => $email, 'password' => $password]);
    }
}
