<?php

namespace Tests\Unit;

use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function testRegistrationFailedInvalidName()
    {
        $data = [
            'first_name' => '',
            'last_name'  => 'Kovalchuk',
            'email'      => 'qwerty@gmail.com',
            'password' => '123456',
            'password_confirmation' =>'123456',
        ];

        $response = $this->post(route('registration'), $data);
        $response->assertSessionHasErrors(['first_name' => 'A first name is required']);

        $data2 = [
            'first_name' => 'v',
            'last_name'  => 'Kovalchuk',
            'email'      => 'qwerty@gmail.com',
            'password' => '123456',
            'password_confirmation' =>'123456',
        ];

        $response = $this->post(route('registration'), $data2);
        $response->assertSessionHasErrors(['first_name' => 'Your first name is too short!']);

        $data3 = [
            'first_name' => 'vqwertyuioppoiuytrewqwertyuiopoiuytrewqwertyuiopoiuytrew',
            'last_name'  => 'Kovalchuk',
            'email'      => 'qwerty@gmail.com',
            'password' => '123456',
            'password_confirmation' =>'123456',
        ];

        $response = $this->post(route('registration'), $data3);
        $response->assertSessionHasErrors(['first_name' => 'Your first name is too long!']);
    }

    public function testRegistrationFailedInvalidLastName()
    {
        $data = [
            'first_name' => 'vlad',
            'last_name'  => '',
            'email'      => 'qwerty@gmail.com',
            'password' => '123456',
            'password_confirmation' =>'123456',
        ];

        $response = $this->post(route('registration'), $data);
        $response->assertSessionHasErrors(['last_name' => 'A last name is required']);

        $data2 = [
            'first_name' => 'vlad',
            'last_name'  => 'k',
            'email'      => 'qwerty@gmail.com',
            'password' => '123456',
            'password_confirmation' =>'123456',
        ];

        $response = $this->post(route('registration'), $data2);
        $response->assertSessionHasErrors(['last_name' => 'Your last name is too short!']);

        $data3 = [
            'first_name' => 'vlad',
            'last_name'  => 'wertyuiopoiuytrewqwertyuioppoiuytrewqwertyuiop',
            'email'      => 'qwerty@gmail.com',
            'password' => '123456',
            'password_confirmation' =>'123456',
        ];

        $response = $this->post(route('registration'), $data3);
        $response->assertSessionHasErrors(['last_name' => 'Your last name is too long!']);
    }



    public function testRegistrationFailedPasswordConformation()
    {
        $data = [
            'first_name' => 'vlad',
            'last_name'  => 'Kovalchuk',
            'email'      => 'qwerty@gmail.com',
            'password' => '123123',
            'password_confirmation' =>'123456',
        ];
        $response = $this->post(route('registration'), $data);
        $response->assertSessionHasErrors(['password'=>'The password confirmation does not match.']);
    }

    public function testRegistrationSuccessAuthor()
    {
        $data = [
            'first_name' => 'vlad',
            'last_name'  => 'Kovalchuk',
            'email'      => 'qwerty@gmail.com',
            'password' => '123456',
            'password_confirmation' =>'123456',
            'author' => 'author'
        ];
        $response = $this->post(route('registration'), $data);

        $this->assertDatabaseHas('users', [
            'email'=>'qwerty@gmail.com',
            'role'=>'author'
        ]);
    }

    public function testRegistrationSuccessUser()
    {
        $data1 = [
            'first_name' => 'vlad1',
            'last_name'  => 'Kovalchuk',
            'email'      => 'qwerty@gmail.com',
            'password' => '123456',
            'password_confirmation' =>'123456',
        ];
        $response = $this->post(route('registration'), $data1);
        $this->assertDatabaseHas('users', [
            'email'=>'qwerty@gmail.com',
            'role'=>'user'
        ]);
    }
}
