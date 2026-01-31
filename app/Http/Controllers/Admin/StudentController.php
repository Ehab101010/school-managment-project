<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function showStudents(Request $request)
    {
        $query = $request->input('query');
        $students = Student::with('class');

        if ($query) {
            $students->where('full_name', 'LIKE', "%{$query}%");
        }

        $students = $students->paginate(10)->withQueryString();
        return view('admin.students.view-student-info', compact('students'));
    }

    public function showCreateStudentForm()
    {
        $classes = ClassModel::all();
        return view('admin.students.add-student', compact('classes'));
    }

    public function storeStudent(Request $request)
    {
         $request->validate([
            'full_name'            => 'required|string|max:255',
            'mother_name'          => 'required|string|max:255',
            'birth_date'           => 'required|date',
            'gender'               => 'required|in:ذكر,أنثى',
            'nationality'          => 'required|string|max:255',
            'student_phone_number' => 'required|string|max:20',
            'father_phone_number'  => 'required|string|max:20',
            'mother_phone_number'  => 'required|string|max:20',
            'class_id'             => 'required|exists:classes,class_id',
            'notes'                => 'nullable|string',
        ]);

         $class = ClassModel::findOrFail($request->class_id);

         $student = Student::create([
            'full_name'            => $request->full_name,
            'mother_name'          => $request->mother_name,
            'birth_date'           => $request->birth_date,
            'gender'               => $request->gender,
            'nationality'          => $request->nationality,
            'student_phone_number' => $request->student_phone_number,
            'father_phone_number'  => $request->father_phone_number,
            'mother_phone_number'  => $request->mother_phone_number,
            'class_id'             => $request->class_id,
            'section_type'         => $class->section_type,  
            'notes'                => $request->notes,
        ]);
         
         $username = "student_" . $student->student_id;
        $tempPassword = "123456";

        $user = \App\Models\User::create([
            'username'   => $username,
            'password'   => $tempPassword,  
            'role'       => 'student',
            'profile_id' => $student->student_id,
            'email'      => null,
            'phone'      => $request->student_phone_number,
            'status'     => 1,
        ]);

         session()->flash('username', $username);
        session()->flash('password', $tempPassword);

        return redirect()->back()->with('success', 'تم إضافة الطالب بنجاح');
    }

    public function showEditTeachersList(Request $request)
    {
        $query = $request->input('query');
        $students = Student::with('class');

        if ($query) {
            $students->where('full_name', 'LIKE', "%{$query}%");
        }

        $students = $students->paginate(10)->withQueryString();
        return view('admin.students.edit-student', compact('students'));
    }
    
    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
    
        // حذف كل الدرجات المرتبطة بالطالب
        \App\Models\Grade::where('student_id', $student->student_id)->delete();
    
        // حذف الحساب المرتبط
        \App\Models\User::where('role', 'student')
            ->where('profile_id', $student->student_id)
            ->delete();
    
        // حذف الطالب نفسه
        $student->delete();
    
        return redirect()->back()->with('success', 'تم حذف الطالب بنجاح');
    }
    
    
    public function getStudent($id)
{
    $student = Student::findOrFail($id);
    return response()->json($student);
}
public function updateStudent(Request $request, $id)
{
    $student = Student::findOrFail($id);

    $student->update([
        'full_name'            => $request->full_name,
        'mother_name'          => $request->mother_name,
        'birth_date'           => $request->birth_date,
        'gender'               => $request->gender,
        'nationality'          => $request->nationality,
        'student_phone_number' => $request->student_phone_number,
        'father_phone_number'  => $request->father_phone_number,
        'mother_phone_number'  => $request->mother_phone_number,
        'notes'                => $request->notes,
    ]);

    return redirect()->back()->with('success', 'تم تحديث بيانات الطالب بنجاح');
}

}
