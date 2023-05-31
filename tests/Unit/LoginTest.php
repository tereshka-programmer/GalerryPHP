<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testLoginSuccess()
    {
        $user = User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'test@hotmail.com',
            'password' => bcrypt('123456')
        ]);

        $data = [
            'email' => 'test@hotmail.com',
            'password' => '123456',
        ];

        $response = $this->post(route('login'), $data);
        $response->assertRedirect(route('profile'));
        $this->assertTrue(Auth::check());
        $user->delete();
    }

    public function testLoginFailed()
    {
        $user = User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'test@hotmail.com',
            'password' => bcrypt('123456')
        ]);

        $data = [
            'email' => 'test@hotmail.com',
            'password' => '999999',
        ];

        $response = $this->post(route('login'), $data);
        $response->assertRedirect(route('profile'));
        $this->assertFalse(Auth::check());
        $user->delete();
    }
}
