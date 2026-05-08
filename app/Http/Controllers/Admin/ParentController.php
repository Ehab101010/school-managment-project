<?php
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentParent;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
 class ParentController extends Controller
{ 
     public function showCreateParentForm()
    {
        $students = Student::all();  
        return view('admin.parents.add-parent', compact('students'));
    }

 public function getParentStudents($parentId)
{
    $students = Student::where('parent_id', $parentId)
        ->with('class')
        ->orderBy('full_name')
        ->get(['student_id', 'full_name', 'class_id']);

    return response()->json($students);
}
public function storeParent(Request $request)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'birth_date'  => 'required|date',
        'gender'=> 'required|in:ذكر,أنثى',
        'phone_mobile' => 'required|string|max:20',
        'additional_phone_number' => 'nullable|string|max:20',
        'phone_home' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'job' => 'nullable|string|max:255',
        'student_ids' => 'nullable|array',
        'student_ids.*' => 'exists:students,student_id',
    ]);

     $parent = StudentParent::create([
        'full_name' => $request->full_name,
        'birth_date'  => $request->birth_date,
        'gender'=> $request->gender,
        'phone_mobile' => $request->phone_mobile,
        'additional_phone_number' => $request->additional_phone_number,
        'phone_home' => $request->phone_home,
        'address' => $request->address,
        'job' => $request->job,
    ]);

     $username = "parent_" . $parent->id;
    $tempPassword = "123456";

    $user = User::create([
        'username'   => $username,
    'password'   => $tempPassword,  
        'role'       => 'parent',
        'profile_id' => $parent->id,
        'email'      => null,
        'phone'      => $request->phone_mobile,
        'status'     => 1,
    ]);

     if ($request->has('student_ids')) {
        foreach ($request->student_ids as $student_id) {
            $student = Student::find($student_id);
            if ($student) {
                $student->parent_id = $parent->id;
                $student->save();
            }
        }
    }

     session()->flash('username', $username);
    session()->flash('password', $tempPassword);

    return redirect()->back()->with('success', 'تم إضافة ولي الأمر بنجاح');
}

     public function showParents(Request $request)
    {
        $query = $request->input('query');

        $parents = StudentParent::query();

         if ($query) {
            $parents->where('full_name', 'like', "%{$query}%");
        }

         $parents = $parents->orderBy('full_name')->paginate(10)->withQueryString();

        return view('admin.parents.view-parents-info', compact('parents'));
    }
    public function showEditParentsList(Request $request)
    {
        $query = $request->input('query');

        $parents = StudentParent::query();

         if ($query) {
            $parents->where('full_name', 'like', "%{$query}%");
        }

         $parents = $parents->orderBy('full_name')->paginate(10)->withQueryString();

        return view('admin.parents.edit-parent', compact('parents'));
    }
    public function getParent($id)
{
    $parent = StudentParent::findOrFail($id);
    return response()->json($parent);
}
    public function deleteParent($id)
    {
        $parent = StudentParent::findOrFail($id);
        $parent->delete();

        return redirect()->back()->with('success', 'تم حذف ولي الأمر بنجاح');
    }
    public function updateParent(Request $request, $id)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'birth_date' => 'required|date',
        'gender' => 'required|in:ذكر,أنثى',
        'phone_mobile' => 'required|string|max:20',
        'additional_phone_number' => 'nullable|string|max:20',
        'phone_home' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'job' => 'nullable|string|max:255',
    ]);

    $parent = StudentParent::findOrFail($id);

    $parent->update([
        'full_name' => $request->full_name,
        'birth_date' => $request->birth_date,
        'gender' => $request->gender,
        'phone_mobile' => $request->phone_mobile,
        'additional_phone_number' => $request->additional_phone_number,
        'phone_home' => $request->phone_home,
        'address' => $request->address,
        'job' => $request->job,
    ]);

    return redirect()->back()->with('success', 'تم تعديل البيانات بنجاح');
}

}