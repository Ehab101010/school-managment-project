<?php

namespace App\Http\Controllers\parent;

use App\Http\Controllers\Controller;
use App\Models\StudentAttendance;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $selectedStudentId = session('selected_child_id');

        if (!$selectedStudentId) {
            return redirect()->route('parent.dashboard')
                ->with('error', 'الرجاء اختيار أحد أبنائك أولاً');
        }

        $parentId = auth()->user()->profile_id;

        $student = Student::with('class')
            ->where('student_id', $selectedStudentId)
            ->where('parent_id', $parentId)
            ->firstOrFail();

        $records = StudentAttendance::where('student_id', $student->student_id)
            ->with('subject')
            ->get();

        $subjectStats = $records
            ->groupBy(fn($r) => $r->subject->subject_name ?? '—')
            ->map(fn($recs, $name) => [
                'subject_name'   => $name,
                'present'        => $recs->where('status', 'present')->count(),
                'absent'         => $recs->where('status', 'absent')->count(),
                'late'           => $recs->where('status', 'late')->count(),
                'late_as_absent' => intdiv($recs->where('status', 'late')->count(), 3),
            ])
            ->sortKeys()
            ->values();

        $totalPresent      = $subjectStats->sum('present');
        $totalAbsent       = $subjectStats->sum('absent');
        $totalLate         = $subjectStats->sum('late');
        $totalLateAsAbsent = intdiv($totalLate, 3);

        return view('parent.attendance', compact(
            'student', 'subjectStats',
            'totalPresent', 'totalAbsent', 'totalLate', 'totalLateAsAbsent'
        ));
    }
}