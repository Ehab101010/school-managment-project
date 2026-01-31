<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        return view('teacher.dashboard');
    }

    public function showStudentInformation(Request $request)
    {
        $teacherId = auth()->user()->profile_id;
    
        $assignments = ClassAssignment::where('teacher_id', $teacherId)
        ->select('class_id', 'subject_id')
        ->get();
    
        $classIds = $assignments->pluck('class_id')->unique();
    
        $students = Student::with('class')
            ->whereIn('class_id', $classIds);
    
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
        $timetable = Timetable::with(['class', 'subject'])
        ->where('teacher_id', $teacherId)
        ->orderBy('day')
        ->orderBy('period')
        ->get();

        return view('teacher.teacher-timetable', compact('timetable'));
    }

     public function showAddGradesForm(Request $request)
    {
        $teacherId = auth()->user()->profile_id;  
        $classes = Timetable::where('teacher_id', $teacherId)
        ->with('class') 
        ->get()
        ->pluck('class')   
        ->unique('class_id')  
        ->values(); 

         $sections = [];
        if ($request->class_name) {
            $sections = $classes->where('class_name', $request->class_name);
        }

         $subjects = [];
        if ($request->class_id) {
            $subjects = Timetable::with('subject')
            ->where('teacher_id', $teacherId)
            ->where('class_id', $request->class_id)
            ->get()
            ->pluck('subject')
            ->unique('subject_id')
            ->values();
        }

         $students = [];
        if ($request->class_id && $request->subject_id) {
            $students = Student::where('class_id', $request->class_id)
            ->select('student_id', 'full_name')
            ->get();
        }

        return view('teacher.add-grades',
            compact('classes', 'sections', 'subjects', 'students')
        );
    }

     public function storeStudentGrades(Request $request)
    {
        $gradesData = [];

        foreach ($request->grades as $student_id => $g) {
            $gradesData[] = [
                'student_id'   => $student_id,
                'subject_id'   => $request->subject_id,
                'class_id'     => $request->class_id,
                'first_exam'   => $g['first'],
                'second_exam'  => $g['second'],
                'activity'     => $g['activity'],
                'final_exam'   => $g['final'],
       
            ];
        }
        
        Grade::insert($gradesData);
        
        return back()->with('success', 'تم حفظ الدرجات بنجاح');
    }

 

     public function showCreateContentForm()
    {
        $teacherId = auth()->user()->profile_id;  

        $subjects = ClassAssignment::with('subject')
        ->where('teacher_id', $teacherId)
        ->get()
        ->pluck('subject')      
        ->unique('subject_id')  
        ->values(); 

        $classes = ClassAssignment::with('class')
        ->where('teacher_id', $teacherId)
        ->get()
        ->pluck('class')     
        ->unique('class_id')  
        ->values(); 
        

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
            $content = LearningContent::findOrFail($id);
            $content->delete();
        
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

    $filePath = null;

    if ($request->content_type === 'pdf' && $request->hasFile('pdf_file')) {
        $filePath = $request->file('pdf_file')
            ->store('teacher_content', 'public');
    }

    if ($request->content_type === 'excel' && $request->hasFile('excel_file')) {
        $filePath = $request->file('excel_file')
            ->store('teacher_content', 'public');
    }

    LearningContent::create([
        'teacher_id'    => auth()->user()->profile_id,
        'subject_id'    => $request->subject_id,
        'class_id'      => $request->class_id,
        'title'         => $request->title,
        'content_type'  => $request->content_type,
        'description'   => $request->description,
        'file_path'     => $filePath,
        'external_link' => $request->external_link,
    ]);

    return back()->with('success', 'تم إضافة المحتوى بنجاح');
}

    
}
