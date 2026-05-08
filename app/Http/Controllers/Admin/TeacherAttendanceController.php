<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherAttendance;
use App\Models\Teacher;
use Carbon\Carbon;

class TeacherAttendanceController extends Controller
{
 
    public function index(Request $request)
    {
        $date     = $request->date ?? now()->toDateString();
        $teachers = Teacher::orderBy('full_name')->get();

        // سجلات اليوم المحدد
        $rows = TeacherAttendance::where('date', $date)->get();

        // تحويل teacher_id لـ string لضمان تطابق المفاتيح في الـ view
        $existing = $rows->pluck('status', 'teacher_id')->mapWithKeys(fn($v, $k) => [(string)$k => $v]);

        return view('admin.attendance.index', compact('teachers', 'existing', 'date'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'date'        => 'required|date',
            'attendance'  => 'required|array',
            'attendance.*'=> 'in:present,absent,late',
        ]);

        $adminUserId = Auth::user()->user_id;

        foreach ($request->attendance as $teacherId => $status) {
            TeacherAttendance::updateOrCreate(
                [
                    'teacher_id' => $teacherId,
                    'date'       => $request->date,
                ],
                [
                    'recorded_by' => $adminUserId,
                    'status'      => $status,
                ]
            );
        }

        return redirect()->route('admin.teacher-attendance.index', ['date' => $request->date])
            ->with('success', 'تم حفظ الحضور بنجاح ✓');
    }

 
    public function report(Request $request)
    {
        $month    = $request->month ?? now()->format('Y-m');
        $teachers = Teacher::orderBy('full_name')->get();

        $start   = $month . '-01';
        $end     = Carbon::parse($start)->endOfMonth()->format('Y-m-d');
        $records = TeacherAttendance::whereBetween('date', [$start, $end])
            ->get()
            ->groupBy('teacher_id');

        $summary = [];
        foreach ($teachers as $teacher) {
            $summary[$teacher->teacher_id] = TeacherAttendance::effectiveAbsences(
                $teacher->teacher_id,
                $month
            );
        }

        return view('admin.attendance.report', compact('teachers', 'records', 'summary', 'month'));
    }

}