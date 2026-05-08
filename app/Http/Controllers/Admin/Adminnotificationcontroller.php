<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    // ── show message ───────────────────────────────────────────────
    public function reports()
    {
        $sent = Report::where('sender_id', Auth::id())
            ->with(['student', 'recipient'])
            ->latest()
            ->paginate(15);

        return view('admin.report.rep-index', compact('sent'));
    }

    // ── create message ─────────────────────────────────────────────────
    public function createReport()
    {
        $teachers = Teacher::join('users', function ($join) {
                $join->on('users.profile_id', '=', 'teachers.teacher_id')
                     ->where('users.role', '=', 'teacher');
            })
            ->select('teachers.*', 'users.user_id as user_id')
            ->orderBy('teachers.full_name')
            ->get();

        $parents = StudentParent::whereNotNull('user_id')
            ->orderBy('full_name')
            ->get();

       
        $classes = ClassModel::orderBy('class_name')
            ->get(['class_id', 'class_name', 'section_name']);
 
        $classParentsJson = [];
        $students = Student::with('parent')
            ->whereNotNull('class_id')
            ->get();

        foreach ($students as $student) {
            $classId = $student->class_id;
            if (!$student->parent || !$student->parent->user_id) continue;

            if (!isset($classParentsJson[$classId])) {
                $classParentsJson[$classId] = [];
            }

            $userId  = $student->parent->user_id;
            $already = collect($classParentsJson[$classId])->contains('user_id', $userId);
            if (!$already) {
                $classParentsJson[$classId][] = [
                    'user_id'   => $userId,
                    'full_name' => $student->parent->full_name,
                ];
            }
        }

        return view('admin.report.rep-create', compact('teachers', 'parents', 'classes', 'classParentsJson'));
    }

     public function storeReport(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'content'        => 'required|string',
            'report_type'    => 'required|in:performance,behavior,attendance,general',
            'recipient_type' => 'required|in:teacher,parent',
            'recipient_id'   => 'required|integer',
        ]);

        Report::create([
            'sender_id'         => Auth::id(),
            'sender_role'       => 'admin',
            'title'             => $request->title,
            'content'           => $request->content,
            'report_type'       => $request->report_type,
            'recipient_user_id' => $request->recipient_id,
            'recipient_role'    => $request->recipient_type,
            'student_id'        => $request->student_id,
        ]);

        return redirect()->route('admin.reports.index')
            ->with('success', 'تم إرسال الرسالة بنجاح ✓');
    }

     public function destroyReport($id)
    {
        Report::where('id', $id)->where('sender_id', Auth::id())->delete();
        return back()->with('success', 'تم الحذف');
    }
}