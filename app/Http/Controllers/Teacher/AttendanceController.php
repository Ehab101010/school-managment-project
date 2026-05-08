<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentAttendance;
use App\Models\ClassAssignment;
use App\Models\Student;
use App\Models\Timetable;

class AttendanceController extends Controller
{
 
    public function index()
    {
        $user      = Auth::user();
        $teacherId = $user->profile_id;

         $assignments = ClassAssignment::with(['classRoom', 'subject'])
            ->where('teacher_id', $teacherId)
            ->get()
            ->groupBy('class_id');

        return view('teacher.attendance.index', compact('assignments'));
    }
 
   public function create(Request $request)
{
    $user      = Auth::user();
    $teacherId = $user->profile_id;

    // 1. إذا لم تكن هناك بيانات مرسلة، نعرض له نفس صفحة الـ index ليختار الفصل والمادة أولاً
    if (!$request->has(['class_id', 'subject_id', 'date'])) {
        $assignments = ClassAssignment::with(['classRoom', 'subject'])
            ->where('teacher_id', $teacherId)
            ->get()
            ->groupBy('class_id');

        // سنعرض صفحة الـ index لأنها تحتوي على نموذج اختيار الفصل والتاريخ
        return view('teacher.attendance.index', compact('assignments'));
    }

    // 2. إذا كانت البيانات موجودة، نقوم بالتحقق منها وعرض صفحة تسجيل الطلاب
    $request->validate([
        'class_id'   => 'required|integer',
        'subject_id' => 'required|integer',
        'date'       => 'required|date',
    ]);

    $classId   = $request->class_id;
    $subjectId = $request->subject_id;
    $date      = $request->date;

    $assignment = ClassAssignment::where('teacher_id', $teacherId)
        ->where('class_id', $classId)
        ->where('subject_id', $subjectId)
        ->firstOrFail();

    $students = Student::where('class_id', $classId)->orderBy('full_name')->get();

    $existing = StudentAttendance::where('class_id', $classId)
        ->where('subject_id', $subjectId)
        ->where('date', $date)
        ->pluck('status', 'student_id');

    return view('teacher.attendance.create', compact(
        'students', 'existing', 'classId', 'subjectId', 'date', 'assignment'
    ));
}
    public function store(Request $request)
    {
        $user      = Auth::user();
        $teacherId = $user->profile_id;

        $request->validate([
            'class_id'    => 'required|integer',
            'subject_id'  => 'required|integer',
            'date'        => 'required|date',
            'attendance'  => 'required|array',
            'attendance.*'=> 'in:present,absent,late',
        ]);

        $classId   = $request->class_id;
        $subjectId = $request->subject_id;
        $date      = $request->date;

        foreach ($request->attendance as $studentId => $status) {
            StudentAttendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $subjectId,
                    'date'       => $date,
                ],
                [
                    'class_id'   => $classId,
                    'teacher_id' => $teacherId,
                    'status'     => $status,
                    'notes'      => $request->input("notes.$studentId"),
                ]
            );
        }

        return redirect()->route('teacher.attendance.report', [
            'class_id'   => $classId,
            'subject_id' => $subjectId,
        ])->with('success', 'تم تسجيل الحضور بنجاح ✓');
    }
 
   public function report(Request $request)
{
    $user      = Auth::user();
    $teacherId = $user->profile_id;

     if (!$request->class_id || !$request->subject_id) {
        $assignments = ClassAssignment::with(['classRoom', 'subject'])
            ->where('teacher_id', $teacherId)
            ->get()
            ->groupBy('class_id');

        return view('teacher.attendance.report', compact('assignments'));
    }

     $classId   = $request->class_id;
    $subjectId = $request->subject_id;
    $month     = $request->month ?? now()->format('Y-m');

    $students = Student::where('class_id', $classId)->orderBy('full_name')->get();

    $records = StudentAttendance::where('class_id', $classId)
        ->where('subject_id', $subjectId)
        ->where('teacher_id', $teacherId)
        ->whereYear('date', substr($month, 0, 4))
        ->whereMonth('date', substr($month, 5, 2))
        ->get()
        ->groupBy('student_id');

$summary = [];
    foreach ($students as $student) {
        $recs = $records->get($student->student_id, collect());
        $summary[$student->student_id] = [
            'present' => $recs->where('status', 'present')->count(),
            'absent'  => $recs->where('status', 'absent')->count(),
            'late'    => $recs->where('status', 'late')->count(),
        ];
    }

     $assignment = ClassAssignment::with(['classRoom', 'subject'])
        ->where('teacher_id', $teacherId)
        ->where('class_id', $classId)
        ->where('subject_id', $subjectId)
        ->first();

    return view('teacher.attendance.report', compact(
        'students', 'records', 'summary', 'classId', 'subjectId', 'month', 'assignment'
    ));
}
}