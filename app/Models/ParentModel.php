<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    protected $table = 'parents';
    protected $fillable = ['user_id','full_name','relation','phone','email','address'];

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function children() {
        return $this->hasMany(Student::class,'father_parent_id'); // أو mother_parent_id حسب الحاجة
    }
}
