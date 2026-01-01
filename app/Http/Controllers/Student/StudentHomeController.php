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
        return view('student.dashboard', compact('student'));
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
