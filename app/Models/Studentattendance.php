<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    protected $table = 'student_attendance';

    protected $fillable = [
        'student_id', 'class_id', 'subject_id', 'teacher_id',
        'timetable_id', 'date', 'status', 'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

     public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }

    public function classRoom()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
    }

    public function timetable()
    {
        return $this->belongsTo(Timetable::class, 'timetable_id', 'id');
    }

    /* ─── Scopes ─── */
    public function scopePresent($q)  { return $q->where('status', 'present'); }
    public function scopeAbsent($q)   { return $q->where('status', 'absent'); }
    public function scopeLate($q)     { return $q->where('status', 'late'); }
}