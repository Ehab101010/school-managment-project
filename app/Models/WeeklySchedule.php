<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklySchedule extends Model
{
    use HasFactory;

    protected $fillable = ['day_of_week','period_number','time_start','time_end','class_id','section_id','subject_id','teacher_id','room'];

    public function class() {
        return $this->belongsTo(ClassModel::class,'class_id');
    }

    public function section() {
        return $this->belongsTo(Section::class,'section_id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class,'subject_id');
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }
}
