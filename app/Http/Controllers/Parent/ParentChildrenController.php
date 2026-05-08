<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class ParentChildrenController extends Controller
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

        return view('parent.children', compact('child'));
    }
}