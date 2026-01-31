<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function showTeacher(Request $request)
    {
        $query = $request->input('search');
        $teachers = Teacher::query();
        if($query) $teachers->where('full_name','LIKE',"%{$query}%");
        $teachers = $teachers->paginate(10)->withQueryString();
        return view('admin.teachers.view-teacher-info', compact('teachers','query'));
    }

    public function showCreateTeacherForm() { return view('admin.teachers.add-teacher'); }

  public function storeTeacher(Request $request)
{
     $teacher = Teacher::create([
        'full_name'    => $request->full_name,
        'mother_name'  => $request->mother_name,
        'birth_date'   => $request->birth_date,
        'gender'       => $request->gender,
        'nationality'  => $request->nationality,
        'address'      => $request->address,
        'phone'        => $request->phone,
        'email'        => $request->email,
        'notes'        => $request->notes
    ]);

     $username = 'teacher_' . $teacher->teacher_id;
    $tempPassword = '123456';

    $user = \App\Models\User::create([
        'username'  => $username,
'password' => $tempPassword,   
        'role'      => 'teacher',
        'profile_id'=> $teacher->teacher_id,
        'email'     => $teacher->email,
        'phone'     => $teacher->phone,
        'status'    => 1
    ]);
    session()->flash('username', $username);
    session()->flash('password', $tempPassword);
    return redirect()->back()->with('success', 'تم إضافة المعلم بنجاح');

}


    public function showEditTeachersList(Request $request)
    {
        $query = $request->input('search');
        $teachers = Teacher::query();
        if($query) $teachers->where('full_name','LIKE',"%{$query}%");
        $teachers = $teachers->paginate(10)->withQueryString();
        return view('admin.teachers.edit-teacher', compact('teachers','query'));
    }

    public function deleteTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
    
        // حذف جميع التعيينات المرتبطة بالمعلم
        \App\Models\ClassAssignment::where('teacher_id', $teacher->teacher_id)->delete();
    
        // حذف الحساب المرتبط إذا موجود
        \App\Models\User::where('role', 'teacher')
            ->where('profile_id', $teacher->teacher_id)
            ->delete();
    
        // حذف المعلم نفسه
        $teacher->delete();
    
        return redirect()->back()->with('success', 'تم حذف المعلم  بنجاح');
    }
    
        public function getTeacher($id)
{
    $teacher = Teacher::findOrFail($id);
    return response()->json($teacher);
}
public function updateTeacher(Request $request, $id)
{
    $teacher = Teacher::findOrFail($id);

    $teacher->update([
        'full_name'   => $request->full_name,
        'mother_name' => $request->mother_name,
        'birth_date'  => $request->birth_date,
        'gender'      => $request->gender,
        'nationality' => $request->nationality,
        'subject'     => $request->subject,
        'address'     => $request->address,
        'phone'       => $request->phone,
        'email'       => $request->email,
        'notes'       => $request->notes,
    ]);

    return back()->with('success', 'تم تحديث بيانات المعلم بنجاح');
}

}
