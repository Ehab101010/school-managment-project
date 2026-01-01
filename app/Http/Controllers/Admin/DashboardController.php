<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Models\Teacher;
use App\Models\ClassModel;  
use App\Models\Subject;
use App\Models\Student;

class DashboardController extends Controller
{   
  public function adminHomepage()
  {
  
         $studentsCount = Student::count();
        $teachersCount = Teacher::count();
        $classesCount = ClassModel::count();
        $subjectsCount = Subject::count();

 

         return view('admin.dashboard', compact(
            'studentsCount',
            'teachersCount',
            'classesCount',
            'subjectsCount',
         ));
   
  }
  
  

}