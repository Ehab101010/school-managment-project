<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAffairsStaff extends Model
{
    use HasFactory;

    protected $table = 'student_affairs_staff';
    public $timestamps = false;

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'gender',
        'nationality',
        'address',
        'birth_date',
        'notes',
    ];
}
