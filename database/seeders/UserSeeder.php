<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::insert([
            [
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),// password
                'user_type' => 'admin'
            ],
            [
                'name' => 'Jhone deo',
                'email' => 'user@gmail.com',
                'password' => Hash::make('user123'), // password
                'user_type' => 'user'
            ]
        ]);
    }
}
