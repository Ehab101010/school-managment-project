<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Grade;

class GradeController extends Controller
{
     public function create()
    {
        return view('teacher.add-grades');
    }

   
}
