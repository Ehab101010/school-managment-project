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
  
      

         return view('admin.dashboard');
   
  }
  
  

}