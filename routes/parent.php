<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Parent\ParentDashboardController;
use App\Http\Controllers\Parent\ParentChildrenController;
use App\Http\Controllers\Parent\ParentGradesController;
use App\Http\Controllers\Parent\ParentAttendanceController;
 use App\Http\Controllers\Parent\ParentAnnouncementController;
 use App\Http\Controllers\Parent\ParentMessageController;
use App\Http\Controllers\Parent\ParentContentController;

 

Route::get('/dashboard',     [ParentDashboardController::class,  'showParentDashboard'])->name('dashboard');     
Route::post('/select-child', [ParentDashboardController::class,  'selectChild'])        ->name('select-child');  
Route::get('/clear-child',   [ParentDashboardController::class,  'clearChild'])         ->name('clear-child');   
Route::get('/children',      [ParentChildrenController::class,   'index'])              ->name('children');     
Route::get('/grades',        [ParentGradesController::class,     'index'])              ->name('grades');       
Route::get('/attendance',    [ParentAttendanceController::class, 'index'])              ->name('attendance');   
 Route::get('/announcements', [ParentAnnouncementController::class,'index'])             ->name('announcements'); 
Route::get('/messages',      [ParentMessageController::class,    'index'])              ->name('messages');     
 Route::get('/content',       [ParentContentController::class,    'index'])              ->name('content');       