<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController as AdminStudent;
use App\Http\Controllers\Admin\TeacherController as AdminTeacher;
use App\Http\Controllers\Admin\ClassController as AdminClass;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Admin\AssignmentParentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminAnnouncementController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\TeacherAttendanceController as AdminTeacherAttendanceController;

 

// ── Dashboard ──────────────────────────────────────────────────────────
Route::get('/dashboard', [DashboardController::class, 'adminHomepage'])
    ->name('dashboard');                                         // → admin.dashboard

// ── Students ───────────────────────────────────────────────────────────
Route::get('/students/add-student',       [AdminStudent::class, 'showCreateStudentForm'])->name('add-student');       // → admin.add-student
Route::post('/students/add-student',      [AdminStudent::class, 'storeStudent'])         ->name('store-student');     // → admin.store-student
Route::get('/students/view-student-info', [AdminStudent::class, 'showStudents'])         ->name('view-student-info'); // → admin.view-student-info
Route::get('/students/students/edit',     [AdminStudent::class, 'showEditTeachersList']) ->name('edit-student');      // → admin.edit-student
Route::get('/students/students/view',     [AdminStudent::class, 'showStudents'])         ->name('view-student');      // → admin.view-student
Route::delete('/students/students/{id}',  [AdminStudent::class, 'deleteStudent'])        ->name('delete-student');    // → admin.delete-student
Route::get('/students/get/{id}',          [AdminStudent::class, 'getStudent'])           ->name('get-student');       // → admin.get-student
Route::post('/students/update/{id}',      [AdminStudent::class, 'updateStudent'])        ->name('update-student');    // → admin.update-student

// ── Parents ────────────────────────────────────────────────────────────
Route::get('/parents/add-parent',         [ParentController::class, 'showCreateParentForm'])->name('add-parent');        // → admin.add-parent
Route::post('/parents/add-parent',        [ParentController::class, 'storeParent'])         ->name('store-parent');      // → admin.store-parent
Route::get('/parents/view-parent-info',   [ParentController::class, 'showParents'])         ->name('view-parent-info');  // → admin.view-parent-info
Route::get('/parents/parents/edit',       [ParentController::class, 'showEditParentsList']) ->name('edit-parent');       // → admin.edit-parent
Route::delete('/parents/parents/{id}',    [ParentController::class, 'deleteParent'])        ->name('delete-parent');     // → admin.delete-parent
Route::get('/parents/{id}',               [ParentController::class, 'getParent'])           ->name('get-parent');        // → admin.get-parent
Route::get('/parents/{id}/edit',          [ParentController::class, 'edit']);                                            // بدون اسم (كما في الأصل)
Route::put('/parents/{id}',               [ParentController::class, 'updateParent'])        ->name('update-parent');     // → admin.update-parent
Route::get('parents/{id}/students',       [ParentController::class, 'getParentStudents'])   ->name('parents.students');  // → admin.parents.students

// ── Teachers ───────────────────────────────────────────────────────────
Route::get('/teachers/add-teacher',       [AdminTeacher::class, 'showCreateTeacherForm'])->name('add-teacher');    // → admin.add-teacher
Route::post('/teachers/add-teacher',      [AdminTeacher::class, 'storeTeacher'])         ->name('store-teacher');  // → admin.store-teacher
Route::get('/teachers/view-teacher-info', [AdminTeacher::class, 'showTeacher'])          ->name('view-teacher-info'); // → admin.view-teacher-info
Route::get('/teachers/teachers/edit',     [AdminTeacher::class, 'showEditTeachersList']) ->name('edit-teacher');   // → admin.edit-teacher
Route::delete('/teachers/teachers/{id}',  [AdminTeacher::class, 'deleteTeacher'])        ->name('delete-teacher'); // → admin.delete-teacher
Route::get('/teachers/get/{id}',          [AdminTeacher::class, 'getTeacher'])           ->name('get-teacher');    // → admin.get-teacher
Route::post('/teachers/update/{id}',      [AdminTeacher::class, 'updateTeacher'])        ->name('update-teacher'); // → admin.update-teacher

// ── Subjects ───────────────────────────────────────────────────────────
Route::get('/subjects/add-subject',    [SubjectController::class, 'showCreateSubjectForm'])->name('add-subject');      // → admin.add-subject
Route::post('/subjects/store-subject', [SubjectController::class, 'storeSubject'])         ->name('store-subject');    // → admin.store-subject
Route::get('/subjects/subjects',       [SubjectController::class, 'ShowSubjects'])         ->name('view-subjects-info');// → admin.view-subjects-info

// ── Classes ────────────────────────────────────────────────────────────
Route::get('/classes/view-class-info', [AdminClass::class, 'showClasses'])         ->name('view-class-info'); // → admin.view-class-info
Route::get('/classes/create-class',    [AdminClass::class, 'showCreateClassForm']) ->name('create-class');    // → admin.create-class
Route::post('/classes/create-class',   [AdminClass::class, 'storeClasses'])        ->name('store-class');     // → admin.store-class
 
// ── Staff ────────────────────────────────────────────────────────────
Route::get('/staff/add',          [StaffController::class, 'showCreateStaffForm'])->name('add-staff');
Route::post('/staff/add',         [StaffController::class, 'storeStaff'])         ->name('store-staff');
Route::get('/staff/view',         [StaffController::class, 'showStaff'])           ->name('view-staff');
Route::get('/staff/edit',         [StaffController::class, 'showEditStaffList'])   ->name('edit-staff');
Route::get('/staff/get/{id}',     [StaffController::class, 'getStaff'])            ->name('get-staff');
Route::put('/staff/update/{id}', [StaffController::class, 'updateStaff'])->name('update-staff');
Route::delete('/staff/{id}',      [StaffController::class, 'deleteStaff'])         ->name('delete-staff');

// ── Assignments ────────────────────────────────────────────────────────
Route::get('/assignments/view-assignment', [AssignmentController::class, 'showAssignments'])          ->name('view-assignment');        // → admin.view-assignment
Route::get('/assignments/create',          [AssignmentController::class, 'showCreateAssignmentForm']) ->name('add-assignment');         // → admin.add-assignment
Route::post('/assignments/store',          [AssignmentController::class, 'storeAssignment'])          ->name('store-assignment');       // → admin.store-assignment
Route::get('/assignments/parent',          [AssignmentParentController::class, 'showParentAssignments'])  ->name('view-parent-assignment');  // → admin.view-parent-assignment
Route::post('/assignments/parent',         [AssignmentParentController::class, 'storeParentAssignment'])  ->name('store-parent-assignment'); // → admin.store-parent-assignment
Route::get('/assignments/get-students',    [AssignmentParentController::class, 'getStudentsByClass'])       ->name('assignments.get-students'); // → admin.assignments.get-students

// ── Teacher Attendance ─────────────────────────────────────────────────
Route::get('teacher-attendance',           [AdminTeacherAttendanceController::class, 'index'])  ->name('teacher-attendance.index');  // → admin.teacher-attendance.index
Route::post('teacher-attendance',          [AdminTeacherAttendanceController::class, 'store'])  ->name('teacher-attendance.store');  // → admin.teacher-attendance.store
Route::get('teacher-attendance/report',    [AdminTeacherAttendanceController::class, 'report']) ->name('teacher-attendance.report'); // → admin.teacher-attendance.report
 
// ── Reports ────────────────────────────────────────────────────────────
Route::get('/reports',         [AdminNotificationController::class, 'reports'])      ->name('reports.index');  // → admin.reports.index
Route::get('/reports/create',  [AdminNotificationController::class, 'createReport']) ->name('reports.create'); // → admin.reports.create
Route::post('/reports',        [AdminNotificationController::class, 'storeReport'])  ->name('reports.store');  // → admin.reports.store
Route::delete('/reports/{id}', [AdminNotificationController::class, 'destroyReport'])->name('reports.destroy');// → admin.reports.destroy
 
// ── Announcements ──────────────────────────────────────────────────────
Route::get('/announcements',          [AdminAnnouncementController::class, 'index'])  ->name('announcements.index');  // → admin.announcements.index
Route::get('/announcements/create',   [AdminAnnouncementController::class, 'create']) ->name('announcements.create'); // → admin.announcements.create
Route::post('/announcements',         [AdminAnnouncementController::class, 'store'])  ->name('announcements.store');  // → admin.announcements.store
Route::delete('/announcements/{id}',  [AdminAnnouncementController::class, 'destroy'])->name('announcements.destroy');// → admin.announcements.destroy