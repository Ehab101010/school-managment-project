<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassAssignment;
use App\Models\Teacher;
use App\Models\ClassModel;
use App\Models\Subject;
use DB;

class AssignmentController extends Controller
{
    public function showAssignments(Request $request)
    {
        $search = $request->input('search');

        $assignments = ClassAssignment::with(['teacher', 'class', 'subject'])
            ->when($search, function ($query, $search) {
                $query->whereHas('teacher', function ($q) use ($sea9rch) {
                    $q->where('full_name', 'LIKE', "%$search%");
                })
                ->orWhereHas('subject', function ($q) use ($search) {
                    $q->where('subject_name', 'LIKE', "%$search%");
                })
                ->orWhereHas('class', function ($q) use ($search) {
                    $q->where('class_name', 'LIKE', "%$search%");
                });
            })
            ->get();

        return view('admin.assignments.view-assignment', compact('assignments'));
    }

    public function showCreateAssignmentForm()
    {
        $teachers = Teacher::all();

        $classes = ClassModel::select(
            'class_id',
            'class_name',
            'section_name',
            DB::raw("CONCAT(class_name, ' - ', section_name) AS full_class_name")
        )->get();

        $subjects = Subject::all();

        return view('admin.assignments.assign-teacher', compact('teachers', 'classes', 'subjects'));
    }

    public function storeAssignment(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required',
            'class_id'   => 'required',
            'subject_id' => 'required',
        ]);
    
         $exists = ClassAssignment::where('teacher_id', $request->teacher_id)
            ->where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->exists();
    
        if ($exists) {
            return redirect()->back()
                ->with('error', '❌ هذا المعلم معين مسبقاً لهذا الصف وهذه المادة!');
        }
    
         ClassAssignment::create($request->all());
    
        return redirect()->route('admin.add-assignment')
            ->with('success', '✅ تم تعيين المعلم بنجاح!');
    }
    
    
}
