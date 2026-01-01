<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';
    protected $primaryKey = 'teacher_id';

    protected $fillable = [
         'full_name',
        'mother_name',
        'birth_date',
        'gender',
        'nationality',
        'address',
        'phone',
        'email',
        'notes'
    ];

     public $timestamps = false;
}
