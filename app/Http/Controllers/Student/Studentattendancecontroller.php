<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentAttendance;

class StudentAttendanceController extends Controller
{
    public function index()
    {
        $studentId = Auth::user()->profile_id;

        $records = StudentAttendance::where('student_id', $studentId)
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

        return view('student.attendance', compact(
            'subjectStats', 'totalPresent', 'totalAbsent', 'totalLate', 'totalLateAsAbsent'
        ));
    }
}