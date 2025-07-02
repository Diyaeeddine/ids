<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
          
        ]);

        User::create([
            'name' => 'Plaisance',
            'email' => 'plaisance@gmail.com',
            'password' => Hash::make('user1234'),
        
        ]);

        User::create([
            'name' => 'Trésorier',
            'email' => 'tresorier@gmail.com',
            'password' => Hash::make('user1234'),
        ]);

        User::create([
            'name' => 'Comptable',
            'email' => 'comptable@gmail.com',
            'password' => Hash::make('user1234'),

        ]);

        User::create([
            'name' => 'Admin Juridique',
            'email' => 'admin.juridique@gmail.com',
            'password' => Hash::make('user1234'),

        ]);
        User::create([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('user1234'),

        ]);
        User::create([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('user1234'),

        ]);        
        User::create([
            'name' => 'user3',
            'email' => 'user3@gmail.com',
            'password' => Hash::make('user1234'),

        ]);
    }
}
