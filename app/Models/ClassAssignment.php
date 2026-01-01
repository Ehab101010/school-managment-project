<?php
 namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassAssignment extends Model
{
    use HasFactory;

    protected $table = 'class_assignments';
    protected $primaryKey = 'assignment_id';
    public $timestamps = false;
    protected $fillable = ['teacher_id','class_id','subject_id'];

    public function teacher() {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
    }

    public function class() {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }
}
