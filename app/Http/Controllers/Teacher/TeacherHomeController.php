<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// 🟦 استدعاء المودلز الصحيحة
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Timetable;
use App\Models\LearningContent;

class TeacherHomeController extends Controller
{
     public function showTeacherDashboard()
    {
        return view('teacher.dashboard');
    }

    public function showStudentInformation(Request $request)
    {
        $teacherId = auth()->user()->profile_id; // المعلم الحالي
    
        // جلب جميع الصفوف والمواد التي يدرسها هذا المعلم
        $assignments = DB::table('class_assignments')
            ->where('teacher_id', $teacherId)
            ->select('class_id', 'subject_id')
            ->get();
    
        // استخراج الصفوف فقط
        $classIds = $assignments->pluck('class_id')->unique();
    
        // الطلاب في هذه الصفوف فقط
        $students = Student::with('class')
            ->whereIn('class_id', $classIds);
    
        // تطبيق البحث لو كان موجود
        if ($request->input('query')) {
            $query = $request->input('query');
            $students->where('full_name', 'LIKE', "%{$query}%");
        }
    
        $students = $students->paginate(10)->withQueryString();
    
        return view('teacher.view-stu-info', compact('students'));
    }
    

     public function showTeacherTimetable()
    {
        $teacherId = auth()->user()->profile_id; 

        $timetable = DB::table('timetables')
            ->join('classes', 'timetables.class_id', '=', 'classes.class_id')
            ->join('subjects', 'timetables.subject_id', '=', 'subjects.subject_id')
            ->where('timetables.teacher_id', $teacherId)
            ->select(
                'timetables.*',
                'classes.class_name',
                'subjects.subject_name'
            )
            ->orderBy('day')
            ->orderBy('period')
            ->get();

        return view('teacher.teacher-timetable', compact('timetable'));
    }

     public function showAddGradesForm(Request $request)
    {
        $teacherId = auth()->user()->profile_id;  

         $classes = DB::table('timetables')
            ->join('classes', 'timetables.class_id', '=', 'classes.class_id')
            ->where('timetables.teacher_id', $teacherId)
            ->select('classes.class_id', 'classes.class_name', 'classes.section_name', 'classes.section_type')
            ->distinct()
            ->get();

         $sections = [];
        if ($request->class_name) {
            $sections = $classes->where('class_name', $request->class_name);
        }

         $subjects = [];
        if ($request->class_id) {
            $subjects = DB::table('timetables')
                ->join('subjects', 'timetables.subject_id', '=', 'subjects.subject_id')
                ->where('teacher_id', $teacherId)
                ->where('class_id', $request->class_id)
                ->select('subjects.subject_id', 'subjects.subject_name')
                ->distinct()
                ->get();
        }

         $students = [];
        if ($request->class_id && $request->subject_id) {
            $students = DB::table('students')
                ->where('class_id', $request->class_id)
                ->select('student_id', 'full_name')
                ->get();
        }

        return view('teacher.add-grades',
            compact('classes', 'sections', 'subjects', 'students')
        );
    }

     public function storeStudentGrades(Request $request)
    {
        foreach ($request->grades as $student_id => $g) {
            DB::table('grades')->insert([
                'student_id'   => $student_id,
                'subject_id'   => $request->subject_id,
                'class_id'     => $request->class_id,
                'first_exam'   => $g['first'],
                'second_exam'  => $g['second'],
                'activity'     => $g['activity'],
                'final_exam'   => $g['final'],
                'created_at'   => now()
            ]);
        }

        return back()->with('success', 'تم حفظ الدرجات بنجاح');
    }

 

     public function showCreateContentForm()
    {
        $teacherId = auth()->user()->profile_id;  

        $subjects = DB::table('class_assignments')
            ->join('subjects', 'subjects.subject_id', '=', 'class_assignments.subject_id')
            ->where('class_assignments.teacher_id', $teacherId)
            ->select('subjects.subject_id', 'subjects.subject_name')
            ->distinct()
            ->get();

            $classes = DB::table('class_assignments')
            ->join('classes', 'classes.class_id', '=', 'class_assignments.class_id')
            ->where('class_assignments.teacher_id', $teacherId)
            ->select(
                'classes.class_id',
                'classes.class_name',
                'classes.section_name',
                'classes.section_type'
            )
            ->distinct()
            ->get();
        

        return view('teacher.create-content', compact('subjects', 'classes'));
    }

     public function showEducationalContent()
    {
        $teacherId = auth()->user()->profile_id;  


        $content = LearningContent::with(['subject', 'class'])
            ->where('teacher_id', $teacherId)
            ->orderBy('created_at', 'DESC')
            ->get();
        
            return view('teacher.view_content', compact('content'));
        }
 
        public function deleteEducationalContent($id)
        {
            DB::table('learning_contents')->where('id', $id)->delete();
        
            return redirect()->back()->with('success', 'تم حذف المحتوى بنجاح');
        }
        
 public function storeEducationalContent(Request $request)
{
    $request->validate([
        'subject_id'    => 'required|integer',
        'class_id'      => 'required|integer',
        'title'         => 'required|string|max:255',
        'content_type'  => 'required|in:video,pdf,excel,assignment,link',
'description'   => 'required|string',
         'pdf_file'      => 'nullable|mimes:pdf|max:20480',        
        'excel_file'    => 'nullable|mimes:xls,xlsx|max:20480',   
'external_link' => 'nullable|string',
    ]);

    $teacherId = auth()->user()->profile_id;
    $filePath = null;

     if ($request->content_type === 'pdf' && $request->hasFile('pdf_file')) {
        $file = $request->file('pdf_file');
        $filePath = $file->storeAs('teacher_content', time().'_'.$file->getClientOriginalName(), 'public');
    }

     if ($request->content_type === 'excel' && $request->hasFile('excel_file')) {
        $file = $request->file('excel_file');
        $filePath = $file->storeAs('teacher_content', time().'_'.$file->getClientOriginalName(), 'public');
    }

    DB::table('learning_contents')->insert([
        'teacher_id'    => $teacherId,
        'subject_id'    => $request->subject_id,
        'class_id'      => $request->class_id,
        'title'         => $request->title,
        'content_type'  => $request->content_type,
        'description'   => $request->description,
        'file_path'     => $filePath,
        'external_link' => $request->external_link,
        'created_at'    => now(),
    ]);

    return back()->with('success', 'تم إضافة المحتوى بنجاح');
}

    
}
