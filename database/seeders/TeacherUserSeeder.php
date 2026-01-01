<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class TeacherUserSeeder extends Seeder
{
    public function run()
    {
        $teachers = [
            ['username'=>'ahmad.ali', 'profile_id'=>1, 'email'=>'ahmad.ali@school.com','phone'=>'0501000001'],
            ['username'=>'sara.mohamed', 'profile_id'=>2, 'email'=>'sara.mohamed@school.com','phone'=>'0501000002'],
            ['username'=>'khaled.youssef', 'profile_id'=>3, 'email'=>'khaled.youssef@school.com','phone'=>'0501000003'],
            ['username'=>'reem.sami', 'profile_id'=>4, 'email'=>'reem.sami@school.com','phone'=>'0501000004'],
            ['username'=>'mahmoud.hassan', 'profile_id'=>5, 'email'=>'mahmoud.hassan@school.com','phone'=>'0501000005'],
            ['username'=>'leila.abdullah', 'profile_id'=>6, 'email'=>'leila.abdullah@school.com','phone'=>'0501000006'],
            ['username'=>'fadi.adel', 'profile_id'=>7, 'email'=>'fadi.adel@school.com','phone'=>'0501000007'],
            ['username'=>'noura.tariq', 'profile_id'=>8, 'email'=>'noura.tariq@school.com','phone'=>'0501000008'],
            ['username'=>'ayman.mahmoud', 'profile_id'=>9, 'email'=>'ayman.mahmoud@school.com','phone'=>'0501000009'],
            ['username'=>'mona.saeed', 'profile_id'=>10, 'email'=>'mona.saeed@school.com','phone'=>'0501000010'],
            ['username'=>'omar.sami', 'profile_id'=>11, 'email'=>'omar.sami@school.com','phone'=>'0501000011'],
            ['username'=>'lian.youssef', 'profile_id'=>12, 'email'=>'lian.youssef@school.com','phone'=>'0501000012'],
        ];

        foreach ($teachers as $teacher) {
            User::updateOrCreate(
                ['username' => $teacher['username']],
                [
                    'password' => '123', // بدون Hash
                    'role' => 'teacher',
                    'profile_id' => $teacher['profile_id'],
                    'email' => $teacher['email'],
                    'phone' => $teacher['phone'],
                ]
            );
        }
    }
}
