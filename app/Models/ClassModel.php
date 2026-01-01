<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';  
    protected $primaryKey = 'class_id';
    public $timestamps = false;

    protected $fillable = [
        'class_name',
        'expected_students',
        'academic_year',
        'section_name',
        'section_type',
     ];
}
