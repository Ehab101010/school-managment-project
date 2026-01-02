<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Student\StudentHomeController;
use App\Http\Controllers\Teacher\TeacherHomeController ;
 use App\Http\Controllers\Admin\StudentController as AdminStudent;
use App\Http\Controllers\Admin\TeacherController as AdminTeacher;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ClassController as AdminClass;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

 

Route::get('/', fn() => redirect()->route('login'));
Route::get('/login',[AuthController::class,'showLogin'])->name('login');
Route::post('/login',[AuthController::class,'login'])->name('login');  

Route::post('/logout',[AuthController::class,'logout'])->name('logout')->middleware('auth');
Route::get('/change-password', [AuthController::class, 'showChangePassword'])
    ->name('password.change');

Route::post('/change-password', [AuthController::class, 'changePassword'])
    ->name('password.update');

 

Route::middleware(['auth','role:admin'])->group(function(){
     Route::get('/admin/dashboard',[DashboardController::class,'adminHomepage'])->name('admin.dashboard');
     Route::get('/admin/students/add-student',[AdminStudent::class,'showCreateStudentForm'])->name('admin.add-student');
    Route::post('/admin/students/add-student',[AdminStudent::class,'storeStudent'])->name('admin.store-student');
    Route::get('/admin/students/view-student-info',[AdminStudent::class,'showStudents'])->name('admin.view-student-info');
    Route::get('/admin/students/students/edit',[AdminStudent::class,'showEditTeachersList'])->name('admin.edit-student');
    Route::get('/admin/students/students/view',[AdminStudent::class,'showStudents'])->name('admin.view-student');
    Route::delete('/admin/students/students/{id}',[AdminStudent::class,'deleteStudent'])->name('admin.delete-student');

 Route::get('/admin/students/get/{id}', [AdminStudent::class, 'getStudent'])
     ->name('admin.get-student');

 Route::post('/admin/students/update/{id}', [AdminStudent::class, 'updateStudent'])
     ->name('admin.update-student');

     Route::get('/admin/teachers/add-teacher',[AdminTeacher::class,'showCreateTeacherForm'])->name('admin.add-teacher');
    Route::post('/admin/teachers/add-teacher',[AdminTeacher::class,'storeTeacher'])->name('admin.store-teacher');
    Route::get('/admin/teachers/view-teacher-info',[AdminTeacher::class,'showTeacher'])->name('admin.view-teacher-info');
    Route::get('/admin/teachers/teachers/edit',[AdminTeacher::class,'showEditTeachersList'])->name('admin.edit-teacher');
    Route::delete('/admin/teachers/teachers/{id}',[AdminTeacher::class,'deleteTeacher'])->name('admin.delete-teacher');
    
 Route::get('/admin/teachers/get/{id}', [AdminTeacher::class, 'getTeacher'])
     ->name('admin.get-teacher');

 Route::post('/admin/teachers/update/{id}', [AdminTeacher::class, 'updateTeacher'])
     ->name('admin.update-teacher');

     Route::get('/admin/subjects/add-subject',[SubjectController::class,'showCreateSubjectForm'])->name('admin.add-subject');
    Route::post('/admin/subjects/store-subject',[SubjectController::class,'storeSubject'])->name('admin.store-subject');
    Route::get('/admin/subjects/subjects',[SubjectController::class,'ShowSubjects'])->name('admin.view-subjects-info');
    
     Route::get('/admin/classes/view-class-info',[AdminClass::class,'showClasses'])->name('admin.view-class-info');
    Route::get('/admin/classes/create-class',[AdminClass::class,'showCreateClassForm'])->name('admin.create-class');
    Route::post('/admin/classes/create-class',[AdminClass::class,'storeClasses'])->name('admin.store-class');

 Route::get('/admin/assignments/view-assignment', [AssignmentController::class, 'showAssignments'])
    ->name('admin.view-assignment');

Route::get('/admin/assignments/create', [AssignmentController::class, 'showCreateAssignmentForm'])
    ->name('admin.add-assignment');

Route::post('/admin/assignments/store', [AssignmentController::class, 'storeAssignment'])
    ->name('admin.store-assignment');


 

});


Route::middleware(['auth', 'role:student'])->group(function () {

    Route::get('/student/dashboard', [StudentHomeController::class, 'dashboard'])
        ->name('student.dashboard');

    Route::get('/student/timetable', [StudentHomeController::class, 'timetable'])
        ->name('student.timetable');

    Route::get('/student/exams', [StudentHomeController::class, 'exams'])
        ->name('student.exams');

    Route::get('/student/grades', [StudentHomeController::class, 'grades'])
        ->name('student.grades');

    Route::get('/student/profile', [StudentHomeController::class, 'profile'])
        ->name('student.profile');

    Route::get('/student/content', [StudentHomeController::class, 'content'])
        ->name('student.content');

});

Route::middleware(['auth','role:teacher'])->group(function(){

    Route::get('/teacher/dashboard', [TeacherHomeController::class,'showTeacherDashboard'])
        ->name('teacher.dashboard');

    Route::get('/teacher/view-stu-info', [TeacherHomeController::class,'showStudentInformation'])
        ->name('teacher.view-stu-info');

    Route::get('/teacher/timetable', [TeacherHomeController::class,'showTeacherTimetable'])
        ->name('teacher.timetable');

    Route::get('/teacher/add-grades', [TeacherHomeController::class, 'showAddGradesForm'])
        ->name('teacher.add-grades');

    Route::post('/teacher/store-grades', [TeacherHomeController::class, 'storeStudentGrades'])
        ->name('teacher.store-grades');

    Route::get('/teacher/create-content', [TeacherHomeController::class,'showCreateContentForm'])
        ->name('teacher.create-content');
 
        Route::post('/teacher/store-content', [TeacherHomeController::class,'storeEducationalContent'])
        ->name('teacher.storeContent');

    Route::delete('/teacher/content/delete/{id}', [TeacherHomeController::class, 'deleteEducationalContent'])
        ->name('teacher.content.delete');

    Route::get('/teacher/view-content', [TeacherHomeController::class,'showEducationalContent'])
        ->name('teacher.view-content');
});

