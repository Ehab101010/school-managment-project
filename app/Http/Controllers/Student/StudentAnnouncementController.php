<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AnnouncementRead;
use App\Models\ClassAssignment;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentAnnouncementController extends Controller
{
    public function index()
    {
        $userId    = Auth::user()->user_id;
        $studentId = Auth::user()->profile_id;

        $student = Student::find($studentId);
        $classId = $student?->class_id;

        $announcements = Announcement::with(['senderUser.teacher', 'targetClass'])
            ->whereIn('sender_role', ['admin', 'teacher', 'student_affairs'])
            ->where(function ($q) use ($classId, $studentId) {
                $q->whereIn('target_type', ['all', 'all_students']);

                if ($classId) {
                    $q->orWhere(function ($q2) use ($classId) {
                        $q2->where('target_type', 'class')
                           ->where('target_id', $classId);
                    });
                }

                $q->orWhere(function ($q2) use ($studentId) {
                    $q2->where('target_type', 'specific_student')
                       ->where('target_id', $studentId);
                });
            })
            ->latest()
            ->get()
            ->map(function ($ann) use ($userId, $classId) {
                $ann->is_read = $ann->reads()->where('user_id', $userId)->exists();

                $ann->teacher_name = null;
                $ann->subject_name = null;
                $ann->sender_label = 'غير معروف';

                if ($ann->sender_role === 'admin') {
                    $ann->sender_label = 'المدير';
                } elseif ($ann->sender_role === 'student_affairs') {
                    $ann->sender_label = 'شؤون الطلاب';
                } elseif ($ann->sender_role === 'teacher' && $ann->senderUser) {
                    $teacherId = $ann->senderUser->profile_id;
                    $ann->teacher_name  = $ann->senderUser->teacher?->full_name;
                    $ann->sender_label  = $ann->teacher_name ?? 'المعلم';

                     $subjects = ClassAssignment::with('subject')
                        ->where('teacher_id', $teacherId)
                        ->where('class_id', $classId)
                        ->get()
                        ->pluck('subject.subject_name')
                        ->filter()
                        ->unique()
                        ->values();

                    $ann->subject_name = $subjects->implode(' / ');
                }

                return $ann;
            });

        $unreadCount = $announcements->where('is_read', false)->count();

        foreach ($announcements->where('is_read', false) as $ann) {
            AnnouncementRead::firstOrCreate([
                'announcement_id' => $ann->id,
                'user_id'         => $userId,
            ], ['read_at' => now()]);
        }

        return view('student.announcements', compact('announcements', 'unreadCount'));
    }
}