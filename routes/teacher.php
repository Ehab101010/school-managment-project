<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\TeacherHomeController;
use App\Http\Controllers\Teacher\TeacherNotificationController;
use App\Http\Controllers\Teacher\TeacherAnnouncementController;
use App\Http\Controllers\Teacher\AttendanceController;

Route::middleware(['auth', 'role:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

    // Dashboard & General
    Route::get('/dashboard',     [TeacherHomeController::class, 'showTeacherDashboard'])   ->name('dashboard');
    Route::get('/view-stu-info', [TeacherHomeController::class, 'showStudentInformation']) ->name('view-stu-info');
    Route::get('/timetable',     [TeacherHomeController::class, 'showTeacherTimetable'])   ->name('timetable');

    // Grades
    Route::get('/add-grades',    [TeacherHomeController::class, 'showAddGradesForm'])   ->name('add-grades');
    Route::post('/store-grades', [TeacherHomeController::class, 'storeStudentGrades'])  ->name('store-grades');

// Content
Route::get('/create-content',          [TeacherHomeController::class, 'showCreateContentForm'])    ->name('create-content');
Route::post('/store-content',          [TeacherHomeController::class, 'storeEducationalContent'])  ->name('storeContent');
Route::get('/view-content',            [TeacherHomeController::class, 'showEducationalContent'])   ->name('view-content');
Route::put('/content/update/{id}',     [TeacherHomeController::class, 'updateEducationalContent']) ->name('content.update'); // ✅ أضفناها
Route::delete('/content/delete/{id}',  [TeacherHomeController::class, 'deleteEducationalContent']) ->name('content.delete');
Route::get('/content/file/{id}', [TeacherHomeController::class, 'serveContentFile'])->name('content.file');   
// Notifications 
    Route::get('/notifications',                [TeacherNotificationController::class, 'inbox'])         ->name('notifications.inbox');
    Route::get('/notifications/sent',           [TeacherNotificationController::class, 'sent'])          ->name('notifications.sent');
    Route::get('/notifications/get-recipients', [TeacherNotificationController::class, 'getRecipients'])->name('notifications.getRecipients');

    // Reports
    Route::get('/report/create',  [TeacherNotificationController::class, 'createReport'])->name('report.create');
    Route::post('/report',        [TeacherNotificationController::class, 'storeReport']) ->name('report.store');
    Route::delete('/report/{id}', [TeacherNotificationController::class, 'destroyReport'])->name('report.destroy');

    // Attendance
    Route::get('/attendance',        [AttendanceController::class, 'index'])  ->name('attendance.index');
    Route::get('/attendance/create', [AttendanceController::class, 'create']) ->name('attendance.create');
    Route::post('/attendance',       [AttendanceController::class, 'store'])  ->name('attendance.store');
    Route::get('/attendance/report', [AttendanceController::class, 'report']) ->name('attendance.report');

    // Announcements
    Route::get('/announcements',         [TeacherAnnouncementController::class, 'index'])  ->name('announcements.index');
    Route::get('/announcements/create',  [TeacherAnnouncementController::class, 'create']) ->name('announcements.create');
    Route::post('/announcements',        [TeacherAnnouncementController::class, 'store'])  ->name('announcements.store');
    Route::delete('/announcements/{id}', [TeacherAnnouncementController::class, 'destroy'])->name('announcements.destroy');
});