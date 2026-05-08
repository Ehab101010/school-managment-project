<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id', 'sender_role',
        'title', 'body', 'priority',
        'target_type', 'target_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

     public function senderUser()
    {
        return $this->belongsTo(User::class, 'sender_id', 'user_id');
    }

    public function targetClass()
    {
        return $this->belongsTo(ClassModel::class, 'target_id', 'class_id');
    }

    public function reads()
    {
        return $this->hasMany(AnnouncementRead::class, 'announcement_id');
    }

     public function scopeForUser($query, int $userId, ?int $classId = null)
    {
        return $query->where(function ($q) use ($classId) {
            $q->whereIn('target_type', ['all', 'all_parents', 'all_students']);
            if ($classId) {
                $q->orWhere(function ($q2) use ($classId) {
                    $q2->where('target_type', 'class')
                       ->where('target_id', $classId);
                });
            }
        });
    }

    public function isReadBy(int $userId): bool
    {
        return $this->reads()->where('user_id', $userId)->exists();
    }
 
}