<?php
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Teacher\TeacherNotificationController;
use App\Http\Controllers\Student\StudentNotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Student\StudentHomeController;
use App\Http\Controllers\Teacher\TeacherHomeController ;
 use App\Http\Controllers\Admin\StudentController as AdminStudent;
use App\Http\Controllers\Admin\TeacherController as AdminTeacher;
use App\Http\Controllers\Admin\ClassController as AdminClass;
use App\Http\Controllers\Admin\DashboardController  ;
use App\Http\Controllers\Admin\ParentController  ;
use App\Http\Controllers\Admin\AssignmentParentController  ;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Parent\ParentAnnouncementController;
use App\Http\Controllers\Parent\ParentAttendanceController;
use App\Http\Controllers\Parent\ParentChildrenController;
use App\Http\Controllers\Parent\ParentDashboardController;
use App\Http\Controllers\Parent\ParentGradesController;
use App\Http\Controllers\Parent\ParentHomeworkController; 
use App\Http\Controllers\Parent\ParentMessageController;
use App\Http\Controllers\Parent\ParentSettingsController;
use App\Http\Controllers\Teacher\AttendanceController;
    
use App\Http\Controllers\Student\StudentAnnouncementController;
use App\Http\Controllers\Student\StudentAttendanceController;
use App\Http\Controllers\Admin\AdminAnnouncementController;
use App\Http\Controllers\Teacher\TeacherAnnouncementController;
 
use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Admin\TeacherAttendanceController as AdminTeacherAttendanceController;
 use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Parent\ParentContentController;

 

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
    Route::get('/admin/students/get/{id}', [AdminStudent::class, 'getStudent'])->name('admin.get-student');
    Route::post('/admin/students/update/{id}', [AdminStudent::class, 'updateStudent'])->name('admin.update-student');
     
    Route::get('/admin/parents/add-parent',[ParentController::class,'showCreateParentForm'])->name('admin.add-parent');
    Route::post('/admin/parents/add-parent',[ParentController::class,'storeParent'])->name('admin.store-parent');
    Route::get('/admin/parents/view-parent-info',[ParentController::class,'showParents'])->name('admin.view-parent-info');
    Route::get('/admin/parents/parents/edit',[ParentController::class,'showEditParentsList'])->name('admin.edit-parent'); 
    Route::delete('/admin/parents/parents/{id}',[ParentController::class,'deleteParent'])->name('admin.delete-parent');
    Route::get('/admin/parents/{id}', [ParentController::class, 'getParent'])
    ->name('admin.get-parent');
    Route::get('/admin/parents/{id}/edit', [ParentController::class, 'edit']);
    Route::put('/admin/parents/{id}', [ParentController::class, 'updateParent'])
    ->name('admin.update-parent');


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

Route::get(
    '/admin/assignments/parent',
    [AssignmentParentController::class, 'showParentAssignments']
)->name('admin.view-parent-assignment');


Route::post(
    '/admin/assignments/parent',
    [AssignmentParentController::class, 'storeParentAssignment']
)->name('admin.store-parent-assignment');
});
Route::get(
    '/admin/assignments/get-students',
    [AssignmentParentController::class, 'getStudentsByClass']
)->name('admin.get-students-by-class');
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // حضور المعلمين
    Route::get('teacher-attendance',           [AdminTeacherAttendanceController::class, 'index'])->name('teacher-attendance.index');
    Route::post('teacher-attendance',          [AdminTeacherAttendanceController::class, 'store'])->name('teacher-attendance.store');
    Route::get('teacher-attendance/report',    [AdminTeacherAttendanceController::class, 'report'])->name('teacher-attendance.report');
    Route::get('teacher-attendance/{id}/show', [AdminTeacherAttendanceController::class, 'show'])->name('teacher-attendance.show');

    // Notifications
    Route::get('/notifications',         [AdminNotificationController::class, 'index'])->name('notifications.index');
    Route::delete('/notifications/{id}', [AdminNotificationController::class, 'destroyNotification'])->name('notifications.destroy');

    // ✅ صحيح — بدون /admin/ لأن prefix موجود
    Route::get('parents/{id}/students',  [ParentController::class, 'getParentStudents'])->name('parents.students');

    // Reports
    Route::get('/reports',        [AdminNotificationController::class, 'reports'])->name('reports.index');
    Route::get('/reports/create', [AdminNotificationController::class, 'createReport'])->name('reports.create');
    Route::post('/reports',       [AdminNotificationController::class, 'storeReport'])->name('reports.store');
    Route::delete('/reports/{id}',[AdminNotificationController::class, 'destroyReport'])->name('reports.destroy');

        Route::get('/announcements',         [AdminAnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create',  [AdminAnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements',        [AdminAnnouncementController::class, 'store'])->name('announcements.store');
    Route::delete('/announcements/{id}', [AdminAnnouncementController::class, 'destroy'])->name('announcements.destroy');

});
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard',       [StudentHomeController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/student/timetable',       [StudentHomeController::class, 'timetable'])->name('student.timetable');
    Route::get('/student/exams',           [StudentHomeController::class, 'exams'])->name('student.exams');
    Route::get('/student/grades',          [StudentHomeController::class, 'grades'])->name('student.grades');
    Route::get('/student/profile',         [StudentHomeController::class, 'profile'])->name('student.profile');
    Route::get('/student/content',         [StudentHomeController::class, 'content'])->name('student.content');
    Route::get('/student/notifications',   [StudentNotificationController::class, 'index'])->name('student.notifications');
    Route::get('/student/attendance',      [StudentAttendanceController::class, 'index'])->name('student.attendance');

    // ✅ هذا فقط
    Route::get('/student/announcements',   [StudentAnnouncementController::class, 'index'])->name('student.announcements');
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
        // في routes/web.php
        Route::get('notifications/get-recipients', [TeacherNotificationController::class, 'getRecipients'])
            ->name('teacher.notifications.getRecipients');
    // Inbox (received from admin)
    Route::get('/notifications',           [TeacherNotificationController::class, 'inbox'])            ->name('notifications.inbox');
 
    // Send to students/parents
    Route::get('/notifications/create',    [TeacherNotificationController::class, 'createNotification'])->name('notifications.create');
    Route::post('/notifications/send',     [TeacherNotificationController::class, 'storeNotification']) ->name('notifications.send');
  // Sent box
    Route::get('/notifications/sent',      [TeacherNotificationController::class, 'sent'])             ->name('notifications.sent');
    // Reports to parents
    Route::get('/report/create',           [TeacherNotificationController::class, 'createReport'])     ->name('report.create');
    Route::post('/report',                 [TeacherNotificationController::class, 'storeReport'])      ->name('report.store');

  
Route::middleware(['auth', 'role:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

    
    // ... باقي routes ...

    // ── أضف هذه الـ 4 routes ──
    Route::get('attendance',        [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('attendance',       [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
}); 

  Route::get('/teacher/announcements',         [TeacherAnnouncementController::class, 'index'])->name('teacher.announcements.index');
    Route::get('/teacher/announcements/create',  [TeacherAnnouncementController::class, 'create'])->name('teacher.announcements.create');
    Route::post('/teacher/announcements',        [TeacherAnnouncementController::class, 'store'])->name('teacher.announcements.store');
    Route::delete('/teacher/announcements/{id}', [TeacherAnnouncementController::class, 'destroy'])->name('teacher.announcements.destroy');

});
Route::middleware(['auth', 'role:parent'])
    ->prefix('parent')
    ->name('parent.')
    ->group(function () {

        Route::get('/dashboard', [ParentDashboardController::class, 'showParentDashboard'])
            ->name('dashboard');

        // ✅ routes جديدة لاختيار الابن
        Route::post('/select-child', [ParentDashboardController::class, 'selectChild'])
            ->name('select-child');
        Route::get('/clear-child', [ParentDashboardController::class, 'clearChild'])
            ->name('clear-child');

        Route::get('/children', [ParentChildrenController::class, 'index'])
            ->name('children');
        Route::get('/grades', [ParentGradesController::class, 'index'])
            ->name('grades');
        Route::get('/attendance', [ParentAttendanceController::class, 'index'])
            ->name('attendance');
        Route::get('/homework', [ParentHomeworkController::class, 'index'])
            ->name('homework');
        Route::get('/announcements', [ParentAnnouncementController::class, 'index'])
            ->name('announcements');
        Route::get('/messages', [ParentMessageController::class, 'index'])
            ->name('messages');
        Route::get('/settings', [ParentSettingsController::class, 'index'])
            ->name('settings');
Route::get('/content', [ParentContentController::class, 'index'])
    ->name('content');
    });