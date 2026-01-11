<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $table = 'timetables';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'day',
        'period',
        'time_from',
        'time_to',
        'class_id',
        'subject_id',
        'teacher_id',
        'room'
    ];

     public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }

     public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
    }

     public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }
 
}
