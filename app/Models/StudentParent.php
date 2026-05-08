<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    use HasFactory;

    protected $table = 'parents'; 

    protected $fillable = [
        'user_id',
        'full_name',
        'birth_date',
        'gender',
        'phone_mobile',
        'additional_phone_number',
        'phone_home',
        'address',
        'job',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

     public function students()
    {
        return $this->hasMany(Student::class, 'parent_id', 'id');
    }
}