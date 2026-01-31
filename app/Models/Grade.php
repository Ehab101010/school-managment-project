<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    public $timestamps = false;  
    protected $fillable = ['student_id','subject_id','class_id','first_exam','second_exam','activity','final_exam','semester'];

    public function student() {
        return $this->belongsTo(Student::class,'student_id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class,'subject_id');
    }

    public function class() {
        return $this->belongsTo(ClassModel::class,'class_id');
    }
}
