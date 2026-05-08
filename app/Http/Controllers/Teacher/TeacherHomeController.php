<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;
use App\Models\ClassAssignment;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Timetable;
use App\Models\LearningContent;

class TeacherHomeController extends Controller
{
    public function showTeacherDashboard()
    {
        $user    = auth()->user();
        $teacher = \DB::table('teachers')->where('teacher_id', $user->profile_id)->first();
        return view('teacher.dashboard', compact('teacher'));
    }

    public function showStudentInformation(Request $request)
    {
        $teacherId  = auth()->user()->profile_id;
        $assignments = ClassAssignment::where('teacher_id', $teacherId)
            ->select('class_id', 'subject_id')->get();
        $classIds   = $assignments->pluck('class_id')->unique();
        $students   = Student::with('class')->whereIn('class_id', $classIds);

        if ($request->input('query')) {
            $students->where('full_name', 'LIKE', '%' . $request->input('query') . '%');
        }

        $students = $students->paginate(10)->withQueryString();
        return view('teacher.view-stu-info', compact('students'));
    }

    public function showTeacherTimetable()
    {
        $teacherId = auth()->user()->profile_id;
        $timetable = Timetable::with(['class', 'subject'])
            ->where('teacher_id', $teacherId)
            ->orderBy('day')->orderBy('period')->get();
        return view('teacher.teacher-timetable', compact('timetable'));
    }

    public function showAddGradesForm(Request $request)
    {
        $teacherId = auth()->user()->profile_id;
        $classes   = Timetable::where('teacher_id', $teacherId)
            ->with('class')->get()->pluck('class')->unique('class_id')->values();

        $sections = [];
        if ($request->class_name) {
            $sections = $classes->where('class_name', $request->class_name);
        }

        $subjects = [];
        if ($request->class_id) {
            $subjects = Timetable::with('subject')
                ->where('teacher_id', $teacherId)
                ->where('class_id', $request->class_id)
                ->get()->pluck('subject')->unique('subject_id')->values();
        }

        $students = [];
        if ($request->class_id && $request->subject_id) {
            $students = Student::where('class_id', $request->class_id)
                ->select('student_id', 'full_name')->get();
        }

        return view('teacher.add-grades', compact('classes', 'sections', 'subjects', 'students'));
    }

    public function storeStudentGrades(Request $request)
    {
        $gradesData = [];
        foreach ($request->grades as $student_id => $g) {
            $gradesData[] = [
                'student_id'  => $student_id,
                'subject_id'  => $request->subject_id,
                'class_id'    => $request->class_id,
                'first_exam'  => $g['first'],
                'second_exam' => $g['second'],
                'activity'    => $g['activity'],
                'final_exam'  => $g['final'],
            ];
        }
        Grade::insert($gradesData);
        return back()->with('success', 'تم حفظ الدرجات بنجاح');
    }

    // ─────────────────────────────────────────────────────────────
    //  EDUCATIONAL CONTENT
    // ─────────────────────────────────────────────────────────────

    public function showCreateContentForm()
    {
        $teacherId = auth()->user()->profile_id;

        $subjects = ClassAssignment::with('subject')
            ->where('teacher_id', $teacherId)->get()
            ->pluck('subject')->unique('subject_id')->values();

        $classes = ClassAssignment::with('class')
            ->where('teacher_id', $teacherId)->get()
            ->pluck('class')->unique('class_id')->values();

        return view('teacher.create-content', compact('subjects', 'classes'));
    }

    public function showEducationalContent()
    {
        $teacherId = auth()->user()->profile_id;
        $content   = LearningContent::with(['subject', 'class'])
            ->where('teacher_id', $teacherId)
            ->orderBy('created_at', 'DESC')->get();
        return view('teacher.view_content', compact('content'));
    }

    public function storeEducationalContent(Request $request)
    {
        $request->validate([
            'subject_id'      => 'required|integer',
            'class_id'        => 'required|integer',
            'title'           => 'required|string|max:255',
            'content_type'    => 'required|in:pdf,excel,powerpoint,link',
            'description'     => 'required|string',
            'pdf_file'        => 'nullable|file|mimes:pdf|max:20480',
            'excel_file'      => 'nullable|file|mimes:xls,xlsx|max:20480',
            'powerpoint_file' => 'nullable|file|mimes:ppt,pptx|max:51200',
            'external_link'   => 'nullable|url',
        ]);

        $filePath     = null;
        $externalLink = null;

        // ── رفع الملف حسب النوع ──
        $fileMap = [
            'pdf'        => 'pdf_file',
            'excel'      => 'excel_file',
            'powerpoint' => 'powerpoint_file',
        ];

        if (isset($fileMap[$request->content_type])) {
            $fieldName = $fileMap[$request->content_type];

            if (!$request->hasFile($fieldName)) {
                return back()->withInput()
                    ->withErrors(['file' => 'يرجى رفع الملف المطلوب.']);
            }

            $file     = $request->file($fieldName);
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // ✅ storeAs بدل store — أوضح وأكثر تحكماً
            $filePath = $file->storeAs('teacher_content', $fileName, 'public');

            if (!$filePath) {
                return back()->withInput()
                    ->withErrors(['file' => 'فشل رفع الملف، يرجى المحاولة مجدداً.']);
            }

        } elseif ($request->content_type === 'link') {
            if (!$request->filled('external_link')) {
                return back()->withInput()
                    ->withErrors(['external_link' => 'يرجى إدخال الرابط الخارجي.']);
            }
            $externalLink = $request->external_link;
        }

        LearningContent::create([
            'teacher_id'    => auth()->user()->profile_id,
            'subject_id'    => $request->subject_id,
            'class_id'      => $request->class_id,
            'title'         => $request->title,
            'content_type'  => $request->content_type,
            'description'   => $request->description,
            'file_path'     => $filePath,
            'external_link' => $externalLink,
        ]);

        return back()->with('success', 'تم نشر المحتوى التعليمي بنجاح ✓');
    }

    public function updateEducationalContent(Request $request, $id)
    {
        $request->validate([
            'subject_id'   => 'required|integer',
            'title'        => 'required|string|max:255',
            'content_type' => 'required|in:pdf,excel,powerpoint,link,video,assignment',
            'description'  => 'required|string',
        ]);

        $content = LearningContent::where('id', $id)
            ->where('teacher_id', auth()->user()->profile_id)
            ->firstOrFail();

        $content->update([
            'subject_id'   => $request->subject_id,
            'title'        => $request->title,
            'content_type' => $request->content_type,
            'description'  => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'تم تحديث المحتوى بنجاح']);
    }
public function serveContentFile($id)
{
    $content = LearningContent::where('id', $id)
        ->where('teacher_id', auth()->user()->profile_id)
        ->firstOrFail();

    if (!$content->file_path) {
        abort(404);
    }

    $fullPath = storage_path('app/public/' . $content->file_path);

    if (!file_exists($fullPath)) {
        abort(404, 'الملف غير موجود');
    }

    return response()->file($fullPath);
}
    public function deleteEducationalContent($id)
    {
        $content = LearningContent::where('id', $id)
            ->where('teacher_id', auth()->user()->profile_id)
            ->firstOrFail();

        // ✅ حذف الملف من Storage قبل حذف السجل
        if ($content->file_path && Storage::disk('public')->exists($content->file_path)) {
            Storage::disk('public')->delete($content->file_path);
        }

        $content->delete();
        return redirect()->back()->with('success', 'تم حذف المحتوى بنجاح');
    }
}