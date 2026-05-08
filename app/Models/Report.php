<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    protected $primaryKey = 'id';

    protected $fillable = [
        'sender_id', 'sender_role', 'recipient_user_id', 'recipient_role',
        'student_id', 'title', 'content', 'report_type', 'period',
        'is_read', 'read_at',
    ];

    protected $dates = ['read_at', 'created_at', 'updated_at'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'user_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_user_id', 'user_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function getReportTypeLabelAttribute(): string
    {
        return match($this->report_type) {
            'behavior'   => 'سلوك',
            'attendance' => 'حضور وغياب',
            'general'    => 'عام',
            default      => 'أداء أكاديمي',
        };
    }

    public static function unreadCountFor(int $userId): int
    {
        return static::where('recipient_user_id', $userId)
            ->where('is_read', 0)
            ->count();
    }
 

    public function senderUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'sender_id', 'user_id');
    }

}