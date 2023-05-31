<?php

namespace Database\Seeders;

use App\Enum\Role;
use App\Models\User;
use Database\Factories\AdminFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Picture::factory(10)->create();
        \App\Models\Review::factory(10)->create();

        $this->addAdmin();
        $this->addAuthor();
        $this->addUser();

    }

    private function addAdmin()
    {
        DB::table('users')->insert([
            'first_name' => 'max',
            'last_name' => 'tereshchenko',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => password_hash('123456', PASSWORD_DEFAULT), // password
            'remember_token' => Str::random(10),
            'role'=>Role::Admin->value
        ]);
    }

    private function addAuthor()
    {
        DB::table('users')->insert([
            'first_name' => 'max',
            'last_name' => 'tereshchenko',
            'email' => 'author@gmail.com',
            'email_verified_at' => now(),
            'password' => password_hash('123456', PASSWORD_DEFAULT), // password
            'remember_token' => Str::random(10),
            'role'=>Role::Author->value
        ]);
    }

    private function addUser()
    {
        DB::table('users')->insert([
            'first_name' => 'max',
            'last_name' => 'tereshchenko',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => password_hash('123456', PASSWORD_DEFAULT), // password
            'remember_token' => Str::random(10),
            'role'=>Role::User->value
        ]);
    }
}
