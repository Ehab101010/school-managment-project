<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Timetable;
use App\Models\ExamSchedule;
use App\Models\Grade;
use App\Models\LearningContent;
use Illuminate\Support\Facades\Auth;

class StudentHomeController extends Controller
{
  public function dashboard()
{
    $student = Student::with('class')->find(Auth::user()->profile_id);
 

    return view('student.dashboard', compact(
        'student',
 
    ));
}

     public function timetable()
    {
        $student = Student::find(Auth::user()->profile_id);

        $timetable = Timetable::with(['subject', 'teacher'])
            ->where('class_id', $student->class_id)
            ->orderBy('period')
            ->get();

        $days = ['الأحد','الاثنين','الثلاثاء','الأربعاء','الخميس'];
        $periods = $timetable->pluck('period')->unique()->sort()->values();

        $mapped = [];
        foreach ($timetable as $row) {
            $mapped[$row->day][$row->period] = $row;
        }

        return view('student.student-schedule', compact('days','periods','mapped'));
    }

     public function exams()
    {
        $student = Student::find(Auth::user()->profile_id);

        $exams = ExamSchedule::with('subject')
            ->where('class_id', $student->class_id)
            ->orderBy('exam_date')
            ->get();

        return view('student.exam-schedule', compact('exams'));
    }

     public function grades()
    {
        $student = Student::find(Auth::user()->profile_id);

        $grades = Grade::with('subject')
            ->where('student_id', $student->student_id)
            ->get();

        return view('student.grades', compact('grades'));
    }

     public function profile()
    {
        $student = Student::with('class')->find(Auth::user()->profile_id);
        return view('student.profile', compact('student'));
    }
public function serveContentFile($id)
{
    $student = Student::with('class')->find(Auth::user()->profile_id);

    // تأكد إن المحتوى يخص صف الطالب فقط
    $content = LearningContent::where('id', $id)
        ->where('class_id', $student->class_id)
        ->firstOrFail();

    if (!$content->file_path) {
        abort(404);
    }

    $fullPath = storage_path('app/public/' . $content->file_path);

    if (!file_exists($fullPath)) {
        abort(404, 'الملف غير موجود');
    }

    $mimeMap = [
        'pdf'  => 'application/pdf',
        'xls'  => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt'  => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    ];

    $extension   = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
    $mimeType    = $mimeMap[$extension] ?? mime_content_type($fullPath);
    $disposition = ($extension === 'pdf') ? 'inline' : 'attachment';

    return response()->file($fullPath, [
        'Content-Type'        => $mimeType,
        'Content-Disposition' => $disposition . '; filename="' . basename($fullPath) . '"',
    ]);
}
     public function content()
    {
        $student = Student::with('class')->find(Auth::user()->profile_id);

        $content = LearningContent::with('subject')
            ->where('class_id', $student->class_id)
            ->orderByDesc('created_at')
            ->get();

        return view('student.view-content-stu', compact('content','student'));
    }
}
