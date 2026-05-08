<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificationRecipient;
use App\Models\Report;
use App\Models\Announcement;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // ── Teacher Sidebar ─────────────────────────────────────────
        // Badge = رسائل (Reports) غير مقروءة مُرسلة للمعلم
        //       + إعلانات admin/sa موجّهة لـ all أو all_teachers لم يقرأها
        View::composer('includes.teacher-sidebar', function ($view) {
            if (!Auth::check()) return;

            $userId = Auth::id();

            $reportUnread = Report::where('recipient_user_id', $userId)
                ->where('is_read', 0)
                ->count();

            $annUnread = Announcement::whereIn('sender_role', ['admin', 'student_affairs'])
                ->whereIn('target_type', ['all', 'all_teachers'])
                ->whereDoesntHave('reads', fn($q) => $q->where('user_id', $userId))
                ->count();

            $view->with([
                'sidebarReportUnread' => $reportUnread,
                'sidebarAnnUnread'    => $annUnread,
                'sidebarTotalUnread'  => $reportUnread + $annUnread,
            ]);
        });

        // ── Student Sidebar ─────────────────────────────────────────
        // Badge = إعلانات لم تُقرأ + رسائل (Reports) لم تُقرأ
        View::composer('includes.student-sidebar', function ($view) {
            if (!Auth::check()) return;

            $userId    = Auth::id();
            $studentId = Auth::user()->profile_id;

            $student = \App\Models\Student::find($studentId);
            $classId = $student?->class_id;

            $annUnread = Announcement::whereIn('sender_role', ['admin', 'teacher', 'student_affairs'])
                ->where(function ($q) use ($classId) {
                    $q->whereIn('target_type', ['all', 'all_students']);
                    if ($classId) {
                        $q->orWhere(fn($q2) => $q2->where('target_type', 'class')->where('target_id', $classId));
                    }
                })
                ->whereDoesntHave('reads', fn($q) => $q->where('user_id', $userId))
                ->count();

            $reportUnread = Report::where('recipient_user_id', $userId)
                ->where('is_read', 0)
                ->count();

            $view->with([
                'sidebarAnnUnread'   => $annUnread,
                'sidebarMsgUnread'   => $reportUnread,
                'sidebarTotalUnread' => $annUnread + $reportUnread,
            ]);
        });

        // ── Parent Sidebar ──────────────────────────────────────────
        // Badge = إعلانات لم تُقرأ + رسائل (Reports) لم تُقرأ
        View::composer('includes.parent-sidebar', function ($view) {
            if (!Auth::check()) return;

            $userId   = Auth::id();
            $parentId = Auth::user()->profile_id;

            $children = \App\Models\Student::where('parent_id', $parentId)
                ->get(['student_id', 'class_id']);
            $classIds   = $children->pluck('class_id')->unique();
            $studentIds = $children->pluck('student_id');

            $annUnread = Announcement::where(function ($q) use ($classIds, $studentIds) {
                    $q->whereIn('target_type', ['all', 'all_parents']);
                    if ($classIds->isNotEmpty()) {
                        $q->orWhere(fn($q2) => $q2->where('target_type', 'class')->whereIn('target_id', $classIds));
                    }
                    if ($studentIds->isNotEmpty()) {
                        $q->orWhere(fn($q2) => $q2->where('target_type', 'specific_student')->whereIn('target_id', $studentIds));
                    }
                })
                ->whereDoesntHave('reads', fn($q) => $q->where('user_id', $userId))
                ->count();

            $reportUnread = Report::where('recipient_user_id', $userId)
                ->where('recipient_role', 'parent')
                ->where('is_read', 0)
                ->count();

            $view->with([
                'sidebarAnnUnread'    => $annUnread,
                'sidebarReportUnread' => $reportUnread,
                'sidebarTotalUnread'  => $annUnread + $reportUnread,
            ]);
        });

        // ── Student Affairs Sidebar ─────────────────────────────────
        // Badge = إعلانات admin لم تُقرأ موجّهة لـ all
        View::composer('includes.student-affairs-sidebar', function ($view) {
            if (!Auth::check()) return;

            $userId = Auth::id();

            $annUnread = Announcement::where('sender_role', 'admin')
                ->whereIn('target_type', ['all'])
                ->whereDoesntHave('reads', fn($q) => $q->where('user_id', $userId))
                ->count();

            $view->with(['sidebarAnnUnread' => $annUnread]);
        });
    }
}
