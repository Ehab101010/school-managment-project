<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\ClassAssignment;
use App\Models\Report;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentMessageController extends Controller
{
    public function index(Request $request)
    {
        $userId   = Auth::user()->user_id;
        $parentId = Auth::user()->profile_id;

        Report::where('recipient_user_id', $userId)
            ->where('recipient_role', 'parent')
            ->where('is_read', 0)
            ->update(['is_read' => 1, 'read_at' => now()]);

        $sender = $request->input('sender', '');

        $query = Report::with(['student', 'senderUser.teacher'])
            ->where('recipient_user_id', $userId)
            ->where('recipient_role', 'parent');

        if ($sender) {
            $query->where('sender_role', $sender);
        }

        $messages = $query->orderBy('created_at', 'desc')->get()
            ->map(function ($r) {
                 $teacherName = null;
                $subjectName = null;

                if ($r->sender_role === 'teacher' && $r->senderUser) {
                    $teacherId   = $r->senderUser->profile_id;
                    $teacherName = $r->senderUser->teacher?->full_name;

                     $classId = $r->student?->class_id;

                    if ($classId) {
                        $subjects = ClassAssignment::with('subject')
                            ->where('teacher_id', $teacherId)
                            ->where('class_id', $classId)
                            ->get()
                            ->pluck('subject.subject_name')
                            ->filter()->unique()->values();

                        $subjectName = $subjects->implode(' / ');
                    }
                }

                return [
                    'id'           => $r->id,
                    'title'        => $r->title,
                    'body'         => $r->content,
                    'sender_role'  => $r->sender_role,
                    'sender_name'  => $teacherName ?? ($r->sender_role === 'admin' ? 'الإدارة' : 'معلم'),
                    'subject_name' => $subjectName,
                    'report_type'  => $r->report_type,
                    'period'       => $r->period,
                    'student'      => $r->student?->full_name ?? null,
                    'created_at'   => $r->created_at,
                ];
            });

        $total       = $messages->count();
        $fromAdmin   = $messages->where('sender_role', 'admin')->count();
        $fromTeacher = $messages->where('sender_role', 'teacher')->count();

        return view('parent.messages', compact('messages', 'sender', 'total', 'fromAdmin', 'fromTeacher'));
    }
}