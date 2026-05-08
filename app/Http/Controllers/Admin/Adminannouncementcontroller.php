<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::where('sender_role', 'admin')
            ->with(['senderUser', 'targetClass'])
            ->latest()
            ->paginate(15);

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $classes = ClassModel::orderBy('class_name')->get();
        return view('admin.announcements.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'required|string',
            'target_type' => 'required|in:all,class,all_parents,all_students,all_teachers',
            'target_id'   => 'nullable|integer|required_if:target_type,class',
        ]);

        Announcement::create([
            'sender_id'   => Auth::user()->user_id,
            'sender_role' => 'admin',
            'title'       => $request->title,
            'body'        => $request->body,
            'target_type' => $request->target_type,
            'target_id'   => $request->target_type === 'class' ? $request->target_id : null,
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'تم نشر الإعلان بنجاح ✓');
    }

    public function destroy($id)
    {
        Announcement::where('id', $id)
            ->where('sender_role', 'admin')
            ->delete();
        return back()->with('success', 'تم حذف الإعلان');
    }
}