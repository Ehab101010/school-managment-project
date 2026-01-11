<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningContent extends Model
{
    use HasFactory;

    protected $table = 'learning_contents';

     protected $fillable = [
        'subject_id',
        'class_id',
        'title',
        'content_type',
        'description',
        'file_path',
        'teacher_id',
    ];
 
 
 
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

  
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
