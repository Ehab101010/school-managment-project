<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';  
    protected $primaryKey = 'subject_id';  
    public $timestamps = true;  

    protected $fillable = [
        'subject_name',
        'description',
        'subject_type'
    ];
}
