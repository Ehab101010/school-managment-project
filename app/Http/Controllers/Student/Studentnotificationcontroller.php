<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassAssignment;
use App\Models\NotificationRecipient;
use App\Models\Report;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentNotificationController extends Controller
{
    public function index()
    {
        $userId    = Auth::id();
        $studentId = Auth::user()->profile_id;

        $student = Student::find($studentId);
        $classId = $student?->class_id;

        $unreadCount = Report::where('recipient_user_id', $userId)
            ->where('is_read', 0)->count();

        Report::where('recipient_user_id', $userId)
            ->where('is_read', 0)
            ->update(['is_read' => 1, 'read_at' => now()]);

        $reports = Report::where('recipient_user_id', $userId)
            ->with(['senderUser.teacher'])
            ->latest()
            ->paginate(20)
            ->through(function ($r) use ($classId) {
                 $r->teacher_name = null;
                $r->subject_name = null;

                if ($r->sender_role === 'teacher' && $r->senderUser) {
                    $teacherId = $r->senderUser->profile_id;
                    $r->teacher_name = $r->senderUser->teacher?->full_name;

                    if ($classId) {
                        $subjects = ClassAssignment::with('subject')
                            ->where('teacher_id', $teacherId)
                            ->where('class_id', $classId)
                            ->get()
                            ->pluck('subject.subject_name')
                            ->filter()->unique()->values();

                        $r->subject_name = $subjects->implode(' / ');
                    }
                }

                return $r;
            });

        $notifications = NotificationRecipient::where('recipient_user_id', $userId)
            ->with(['notification.senderUser'])
            ->latest('created_at')
            ->paginate(20);

        return view('student.notifications', compact('reports', 'notifications', 'unreadCount'));
    }
}