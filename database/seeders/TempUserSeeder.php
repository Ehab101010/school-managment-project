<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TempUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email' => 'admin@school.com',
            'phone' => '1000000000'
        ]);

        User::create([
            'username' => 'teacher1',
            'password' => Hash::make('teacher123'),
            'role' => 'teacher',
            'email' => 'teacher1@school.com',
            'phone' => '2000000000'
        ]);

        User::create([
            'username' => 'student1',
            'password' => Hash::make('student123'),
            'role' => 'student',
            'email' => 'student1@school.com',
            'phone' => '3000000000'
        ]);

        User::create([
            'username' => 'parent1',
            'password' => Hash::make('parent123'),
            'role' => 'parent',
            'email' => 'parent1@school.com',
            'phone' => '4000000000'
        ]);
    }
}
