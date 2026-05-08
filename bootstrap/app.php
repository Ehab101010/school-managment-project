<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',

        // ✅ أضف هذا فقط
        then: function () {

            // AJAX route بدون role middleware
            Route::middleware('web')
                ->get('/admin/assignments/get-students', [
                    \App\Http\Controllers\Admin\AssignmentParentController::class,
                    'getStudentsByClass',
                ])->name('admin.get-students-by-class');

            // Admin
            Route::middleware(['web', 'auth', 'role:admin'])
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
 
            // Teacher
            Route::middleware(['web', 'auth', 'role:teacher'])
                ->prefix('teacher')
                 ->group(base_path('routes/teacher.php'));

            // Student
            Route::middleware(['web', 'auth', 'role:student'])
                ->prefix('student')
                ->name('student.')
                ->group(base_path('routes/student.php'));

            // Parent
            Route::middleware(['web', 'auth', 'role:parent'])
                ->prefix('parent')
                ->name('parent.')
                ->group(base_path('routes/parent.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();