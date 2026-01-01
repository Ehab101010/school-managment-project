<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // حذف المدير إذا كان موجود
        User::where('username', 'admin')->delete();

        // إنشاء حساب المدير
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'password' => 'admin123', // بدون Hash::make
                'role' => 'admin',
                'email' => 'admin@school.com',
                'phone' => '0500000001',
            ]
        );

        // إنشاء المعلمين
        $teachers = [
            ['username'=>'t.ahmad', 'password'=>'teacher123','role'=>'teacher','email'=>'ahmad@school.com','phone'=>'0500000002'],
            ['username'=>'t.sara', 'password'=>'teacher123','role'=>'teacher','email'=>'sara@school.com','phone'=>'0500000003'],
            // أضف باقي المعلمين هنا بنفس الطريقة
        ];

        foreach ($teachers as $teacher) {
            User::updateOrCreate(
                ['username' => $teacher['username']],
                [
                    'password' => $teacher['password'], // بدون Hash
                    'role' => $teacher['role'],
                    'email' => $teacher['email'],
                    'phone' => $teacher['phone'],
                ]
            );
        }

        // إنشاء الطلاب
        $students = [
            ['username'=>'s.ali','password'=>'student123','role'=>'student','email'=>'ali@school.com','phone'=>'0500000006'],
            ['username'=>'s.noor','password'=>'student123','role'=>'student','email'=>'noor@school.com','phone'=>'0500000007'],
            // أضف باقي الطلاب هنا بنفس الطريقة
        ];

        foreach ($students as $student) {
            User::updateOrCreate(
                ['username' => $student['username']],
                [
                    'password' => $student['password'], // بدون Hash
                    'role' => $student['role'],
                    'email' => $student['email'],
                    'phone' => $student['phone'],
                ]
            );
        }

        $this->command->info('تم إنشاء المستخدمين الأساسيين بنجاح!');
    }
}
