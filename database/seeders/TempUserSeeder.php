<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TempUserSeeder extends Seeder
{
    public function run()
    {
        // User::create([
        //     'username' => 'admin',
        //     'password' => Hash::make('admin123'),
        //     'role' => 'admin',
        //     'email' => 'admin@school.com',
        //     'phone' => '1000000000'
        // ]);
\App\Models\User::create([
    'username' => 'student_affairs',
    'password' => '123456',       // يشفّر تلقائياً إذا عندك Hash في model
    'role'     => 'student_affairs',
]);
 
    // ── حذف البيانات القديمة ──
    // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    // DB::table('grades')->truncate();
    // DB::table('student_attendance')->truncate();
    // DB::table('reports')->truncate();
    // DB::table('announcements')->truncate();
    // DB::table('announcement_reads')->truncate();
    // DB::table('timetables')->truncate();
    // DB::table('exam_schedules')->truncate();
    // DB::table('class_assignments')->truncate();
    // DB::table('class_subject')->truncate();
    // DB::table('students')->truncate();
    // DB::table('parents')->truncate();
    // DB::table('teachers')->truncate();
    // DB::table('users')->truncate();
    // DB::table('classes')->truncate();
    // DB::table('subjects')->truncate();
    // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    // ══════════════════════════════════════════════
    // 1. SUBJECTS
    // ══════════════════════════════════════════════
 
 
 
    }
}
