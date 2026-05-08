<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AnnouncementRead;
use App\Models\ClassAssignment;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class ParentAnnouncementController extends Controller
{
    public function index()
    {
        $userId   = Auth::user()->user_id;
        $parentId = Auth::user()->profile_id;

        $children   = Student::where('parent_id', $parentId)->get(['student_id', 'class_id']);
        $studentIds = $children->pluck('student_id');
        $classIds   = $children->pluck('class_id')->unique();

        $announcements = Announcement::with(['senderUser.teacher', 'targetClass'])
            ->where(function ($q) use ($studentIds, $classIds) {
                $q->whereIn('target_type', ['all', 'all_parents']);

                if ($classIds->isNotEmpty()) {
                    $q->orWhere(function ($q2) use ($classIds) {
                        $q2->where('target_type', 'class')
                           ->whereIn('target_id', $classIds);
                    });
                }

                if ($studentIds->isNotEmpty()) {
                    $q->orWhere(function ($q2) use ($studentIds) {
                        $q2->where('target_type', 'specific_student')
                           ->whereIn('target_id', $studentIds);
                    });
                }
            })
            ->latest()
            ->get()
            ->map(function ($ann) use ($userId) {
                $ann->is_read = $ann->reads()->where('user_id', $userId)->exists();

                 $ann->teacher_name = null;
                $ann->subject_name = null;
                $ann->sender_label = 'غير معروف';

                if ($ann->sender_role === 'admin') {
                    $ann->sender_label = 'الإدارة';
                } elseif ($ann->sender_role === 'student_affairs') {
                    $ann->sender_label = 'شؤون الطلاب';
                } elseif ($ann->sender_role === 'teacher' && $ann->senderUser) {
                    $teacherId = $ann->senderUser->profile_id;
                    $ann->teacher_name  = $ann->senderUser->teacher?->full_name;
                    $ann->sender_label  = $ann->teacher_name ?? 'المعلم';

                     $classId = $ann->target_type === 'class' ? $ann->target_id : null;

                    $query = ClassAssignment::with('subject')
                        ->where('teacher_id', $teacherId);

                    if ($classId) {
                        $query->where('class_id', $classId);
                    }

                    $subjects = $query->get()
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

        return view('parent.announcements', compact('announcements', 'unreadCount'));
    }
}