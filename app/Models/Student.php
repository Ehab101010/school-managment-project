<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'student_id';
    public $timestamps = false;

    protected $fillable = [
        'full_name',
        'mother_name',
        'birth_date',
        'gender',
        'nationality',
        'student_phone_number',
        'father_phone_number',
        'mother_phone_number',
        'class_id',
        'section_type',
        'notes',
    ];
 
     public function class()
    {
        return $this->belongsTo(\App\Models\ClassModel::class, 'class_id', 'class_id');
    }

     public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'section_id');
    }

     public function teacher()
    {
        return $this->hasOneThrough(
            Teacher::class,           
            ClassAssignment::class,    
            'class_id',              
            'teacher_id',              
            'class_id',               
            'teacher_id'              
        );
    }
    
}
