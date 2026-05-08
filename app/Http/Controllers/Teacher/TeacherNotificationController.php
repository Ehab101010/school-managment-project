<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\User;
use App\Models\ClassModel;
use App\Models\ClassAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherNotificationController extends Controller
{
    // ── Inbox ──────────────────────────────────────────────────────────────
    public function inbox()
    {
        $unreadReports = Report::where('recipient_user_id', Auth::id())
            ->where('is_read', 0)->count();

        Report::where('recipient_user_id', Auth::id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        $reports = Report::where('recipient_user_id', Auth::id())
            ->with(['student'])
            ->latest()
            ->paginate(10);

        return view('teacher.notification.notif-inbox', compact('reports', 'unreadReports'));
    }

    // ── Sent ───────────────────────────────────────────────────────────────
    public function sent()
    {
        $sentReports = Report::where('sender_id', Auth::id())
            ->where('sender_role', 'teacher')
            ->with(['student'])
            ->latest()
            ->paginate(10);

        return view('teacher.notification.notif-sent', compact('sentReports'));
    }

    // ── create ────────────────────────────────────────────────────────
    public function createReport()
    {
        $teacherId = auth()->user()->profile_id;

        $classIds = ClassAssignment::where('teacher_id', $teacherId)
            ->pluck('class_id')->unique();

        $classes = ClassModel::whereIn('class_id', $classIds)
            ->orderBy('class_name')
            ->get(['class_id', 'class_name', 'section_name', 'section_type']);

        $classNames = $classes->pluck('class_name')->unique()->values();

        $studentsData = Student::whereIn('class_id', $classIds)
            ->with(['parent'])
            ->orderBy('full_name')
            ->get()
            ->map(fn($s) => [
                'student_id'  => $s->student_id,
                'full_name'   => $s->full_name,
                'class_id'    => $s->class_id,
                'has_parent'  => (bool) $s->parent_id,
                'parent_name' => $s->parent?->full_name ?? '',
            ]);

        return view('teacher.report.rep-create', compact('classes', 'classNames', 'studentsData'));
    }

    // ── save ────────────────────────────────────────────────────────
    public function storeReport(Request $request)
    {
        $request->validate([
            'target_type' => 'required|in:student,parent',
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'report_type' => 'required|in:performance,behavior,attendance,general',
            'period'      => 'nullable|string|max:100',
            'student_id'  => 'required_if:target_type,student|nullable|integer',
            'parent_id'   => 'required_if:target_type,parent|nullable|integer',
        ]);

        $common = [
            'sender_id'   => Auth::id(),
            'sender_role' => 'teacher',
            'title'       => $request->title,
            'content'     => $request->content,
            'report_type' => $request->report_type,
            'period'      => $request->period,
        ];

        if ($request->target_type === 'student') {
            $student = Student::findOrFail($request->student_id);

            $classIds = ClassAssignment::where('teacher_id', auth()->user()->profile_id)->pluck('class_id');
            abort_unless($classIds->contains($student->class_id), 403);

            $parentUser = null;
            if ($student->parent_id) {
                $parentUser = User::where('role', 'parent')
                    ->where('profile_id', $student->parent_id)
                    ->first();
            }

            if (!$parentUser) {
                return back()->with('error', 'لا يوجد حساب ولي أمر مرتبط بهذا الطالب');
            }

            Report::create(array_merge($common, [
                'recipient_user_id' => $parentUser->user_id,
                'recipient_role'    => 'parent',
                'student_id'        => $student->student_id,
            ]));

            $studentUser = User::where('role', 'student')
                ->where('profile_id', $student->student_id)
                ->first();

            if ($studentUser) {
                Report::create(array_merge($common, [
                    'recipient_user_id' => $studentUser->user_id,
                    'recipient_role'    => 'student',
                    'student_id'        => $student->student_id,
                ]));
            }
        }

        if ($request->target_type === 'parent') {
            $parent = StudentParent::findOrFail($request->parent_id);

            $parentUser = User::where('role', 'parent')
                ->where('profile_id', $parent->id)
                ->first();

            if (!$parentUser) {
                return back()->with('error', 'لا يوجد حساب مرتبط بولي الأمر');
            }

            Report::create(array_merge($common, [
                'recipient_user_id' => $parentUser->user_id,
                'recipient_role'    => 'parent',
                'student_id'        => null,
            ]));
        }

        return redirect()->route('teacher.notifications.sent')
            ->with('success', 'تم إرسال الرسالة بنجاح ✓');
    }

     public function destroyReport($id)
    {
        $deleted = Report::where('id', $id)
            ->where('sender_id', Auth::id())
            ->where('sender_role', 'teacher')
            ->delete();

        abort_unless($deleted, 403);

        return back()->with('success', 'تم حذف الرسالة');
    }
}