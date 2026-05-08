<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentParent;
use App\Models\Student;
use App\Models\ClassModel;

class AssignmentParentController extends Controller
{

     public function showParentAssignments()
    {
        $parents = StudentParent::orderBy('full_name')->get();

         $classes = ClassModel::select('class_name')
            ->distinct()
            ->orderBy('class_name')
            ->get();

         $sections = ClassModel::orderBy('class_name')
            ->orderBy('section_name')
            ->get();

        return view('admin.assignments.assign-parent',
            compact('parents','classes','sections')
        );
    }
     public function getStudentsByClass(Request $request)
    {
        $students = Student::where('class_id', $request->class_id)
            ->orderBy('full_name')
            ->get();

        return response()->json($students);
    }


 public function storeParentAssignment(Request $request)
{
    $request->validate([
        'parent_id'  => 'required|exists:parents,id',
        'student_id' => 'required|exists:students,student_id',
    ]);

    $student = Student::findOrFail($request->student_id);

     if ($student->parent_id && $student->parent_id != $request->parent_id) {
        return back()->with('error', '⚠️ هذا الطالب مرتبط بالفعل بولي أمر آخر، لا يمكن تعيين ولي أمر جديد له.');
    }

    // شرط 2: نفس ولي الأمر مرتبط بهذا الطالب مسبقاً
    if ($student->parent_id == $request->parent_id) {
        return back()->with('error', '⚠️ ولي الأمر هذا مرتبط بالفعل بهذا الطالب.');
    }

    $student->parent_id = $request->parent_id;
    $student->save();

    return back()->with('success', '✅ تم ربط ولي الأمر بالطالب بنجاح.');
}
}