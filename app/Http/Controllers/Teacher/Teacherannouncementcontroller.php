<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AnnouncementRead;
use App\Models\ClassAssignment;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherAnnouncementController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->user_id;

        $received = Announcement::with('senderUser')
            ->whereIn('sender_role', ['admin', 'student_affairs'])
            ->whereIn('target_type', ['all', 'all_teachers'])
            ->latest()
            ->get()
            ->map(function ($ann) use ($userId) {
                $ann->is_read = $ann->reads()->where('user_id', $userId)->exists();
                $ann->sender_label = $ann->sender_role === 'student_affairs' ? 'شؤون الطلاب' : 'المدير';
                return $ann;
            });

        foreach ($received->where('is_read', false) as $ann) {
            AnnouncementRead::firstOrCreate([
                'announcement_id' => $ann->id,
                'user_id'         => $userId,
            ], ['read_at' => now()]);
        }

        $sent = Announcement::with('targetClass')
            ->where('sender_id', $userId)
            ->latest()
            ->get();

        return view('teacher.announcements.index', compact('received', 'sent'));
    }

    public function create()
    {
        $teacherId = Auth::user()->profile_id;
        $classIds  = ClassAssignment::where('teacher_id', $teacherId)->pluck('class_id');
        $classes   = ClassModel::whereIn('class_id', $classIds)->orderBy('class_name')->get();

        return view('teacher.announcements.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'body'      => 'required|string',
            'target_id' => 'required|integer',
        ]);

        $teacherId = Auth::user()->profile_id;
        $classIds  = ClassAssignment::where('teacher_id', $teacherId)->pluck('class_id');
        abort_unless($classIds->contains($request->target_id), 403);

        Announcement::create([
            'sender_id'   => Auth::user()->user_id,
            'sender_role' => 'teacher',
            'title'       => $request->title,
            'body'        => $request->body,
            'target_type' => 'class',
            'target_id'   => $request->target_id,
        ]);

        return redirect()->route('teacher.announcements.index')
            ->with('success', 'تم نشر الإعلان بنجاح ✓');
    }

    public function destroy($id)
    {
        Announcement::where('sender_id', Auth::user()->user_id)->findOrFail($id)->delete();
        return back()->with('success', 'تم حذف الإعلان');
    }
}