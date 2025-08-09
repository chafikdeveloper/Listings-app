<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "name" => "Grey",
                "email" => "grey@gmail.com",
                "password" => "pass1234",
                "role" => "admin"
            ],
            [
                "name" => "Tim",
                "email" => "tim@gmail.com",
                "password" => "pass1234",
                "role" => "admin"
            ],
            [
                "name" => "John",
                "email" => "john@gmail.com",
                "password" => "pass1234",
                "role" => "suspended"
            ],
            [
                "name" => "Jack",
                "email" => "jack@gmail.com",
                "password" => "pass1234",
                "role" => "general"
            ],
            [
                "name" => "Edward",
                "email" => "edward@gmail.com",
                "password" => "pass1234",
                "role" => "general"
            ],
            [
                "name" => "Noah",
                "email" => "noah@gmail.com",
                "password" => "pass1234",
                "role" => "suspended"
            ],
        ];

        foreach($users as $user) {
            User::create($user);
        }
    }
}
