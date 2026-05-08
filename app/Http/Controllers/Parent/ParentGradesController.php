<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Grade;

class ParentGradesController extends Controller
{
    public function index()
    {
        $parentId = auth()->user()->profile_id;

         if (!session('selected_child_id')) {
            return redirect()->route('parent.dashboard');
        }

        $child = Student::where('parent_id', $parentId)
                        ->where('student_id', session('selected_child_id'))
                        ->with('class')
                        ->firstOrFail();

        $grades = Grade::where('student_id', $child->student_id)
                       ->with('subject')
                       ->get();

         $totalAvg = null;
        if ($grades->count() > 0) {
            $totalAvg = $grades->avg(function ($grade) {
                return $grade->final_exam;
            });
        }

        return view('parent.grades', compact('child', 'grades', 'totalAvg'));
    }
}