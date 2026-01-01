<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function ShowSubjects(Request $request)
    {
        $query = $request->input('search');
        $subjects = Subject::query();
        if($query) $subjects->where('subject_name','LIKE',"%{$query}%");
        $subjects = $subjects->get();
        return view('admin.subjects.view-subjects-info', compact('subjects'));
    }

    public function showCreateSubjectForm() { return view('admin.subjects.add-subject'); }

    public function storeSubject(Request $request)
    {
        $request->validate(['subject_name'=>'required|string|max:255']);
        Subject::create($request->all());
        return redirect()->back()->with('success','تمت إضافة المادة');
    }
}
