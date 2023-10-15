<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Message::factory(10)->create();

        User::insert([
            [
                'name' => 'Jhon Deo',
                'email' => 'jhon@gmail.com',
                'password' => Hash::make(123456789)
            ],
            [
                'name' => 'Art Vandelay',
                'email' => 'art@gmail.com',
                'password' => Hash::make(123456789)
            ]
        ]);
    }
}
