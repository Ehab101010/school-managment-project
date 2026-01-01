<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';
    protected $primaryKey = 'section_id';
    public $timestamps = false;  
    protected $fillable = ['section_name', 'description'];
}
