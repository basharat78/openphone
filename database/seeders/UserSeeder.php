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
                'name' => 'QC User',
                'email' => 'qc@gmail.com',
                'password' => Hash::make('qc123'), // password
                'user_type' => 'qc'
            ]
        ]);
    }
}
