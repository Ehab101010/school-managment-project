<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class ParentDashboardController extends Controller
{
    public function showParentDashboard()
    {
        $parentId = auth()->user()->profile_id;

        $children = Student::where('parent_id', $parentId)->get();

        return view('parent.dashboard', compact('children'));
    }

    public function selectChild(Request $request)
    {
        $request->validate(['child_id' => 'required|integer']);

        $parentId = auth()->user()->profile_id;
        $child = Student::where('parent_id', $parentId)
                        ->where('student_id', $request->child_id)
                        ->firstOrFail();

        session(['selected_child_id' => $child->student_id]);

         return redirect()->route('parent.children');
    }

    public function clearChild()
    {
        session()->forget('selected_child_id');
         return redirect()->route('parent.dashboard');
    }
}