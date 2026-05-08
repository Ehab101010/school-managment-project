<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\StudentHomeController;
use App\Http\Controllers\Student\StudentNotificationController;
use App\Http\Controllers\Student\StudentAttendanceController;
use App\Http\Controllers\Student\StudentAnnouncementController;

 

Route::get('/dashboard',     [StudentHomeController::class,       'dashboard']) ->name('dashboard');     // → student.dashboard
Route::get('/timetable',     [StudentHomeController::class,       'timetable']) ->name('timetable');     // → student.timetable
Route::get('/exams',         [StudentHomeController::class,       'exams'])     ->name('exams');         // → student.exams
Route::get('/grades',        [StudentHomeController::class,       'grades'])    ->name('grades');        // → student.grades
Route::get('/profile',       [StudentHomeController::class,       'profile'])   ->name('profile');       // → student.profile
Route::get('/content',       [StudentHomeController::class,       'content'])   ->name('content');       // → student.content
Route::get('/content/file/{id}', [StudentHomeController::class, 'serveContentFile'])->name('content.file');
Route::get('/notifications', [StudentNotificationController::class,'index'])    ->name('notifications'); // → student.notifications
Route::get('/attendance',    [StudentAttendanceController::class,  'index'])    ->name('attendance');    // → student.attendance
Route::get('/announcements', [StudentAnnouncementController::class,'index'])    ->name('announcements'); // → student.announcements