<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassModel;

class ClassController extends Controller
{
    public function showClasses() { $classes = ClassModel::all(); return view('admin.classes.view-class-info', compact('classes')); }
    public function showCreateClassForm() { return view('admin.classes.create-class'); }
    public function storeClasses(Request $request)
    {
        $request->validate(['class_name'=>'required|string|max:255','section_type'=>'required|in:علمي,أدبي,عام']);
        ClassModel::create($request->all());
        return redirect()->back()->with('success','تم إنشاء الصف');
    }
}
