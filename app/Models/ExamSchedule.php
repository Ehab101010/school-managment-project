<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['subject_id','class_id','exam_date','day_of_week','exam_time','room','notes','semester'];

    public function subject() {
        return $this->belongsTo(Subject::class,'subject_id');
    }

    public function class() {
        return $this->belongsTo(ClassModel::class,'class_id');
    }
}
