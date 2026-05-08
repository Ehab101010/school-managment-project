<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\NotificationRecipient;

class SchoolNotification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';

    protected $fillable = [
        'sender_id', 'sender_role', 'title', 'body',
        'type', 'priority', 'target_type', 'target_id',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'user_id');
    }
    public function senderUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'sender_id', 'user_id');
    }

 
    public function recipients()
    {
        return $this->hasMany(NotificationRecipient::class, 'notification_id');
    }

    // Scope: unread count for a user
    public static function unreadCountFor(int $userId): int
    {
        return NotificationRecipient::where('recipient_user_id', $userId)
            ->where('is_read', 0)
            ->count();
    }

    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            'urgent' => 'عاجل',
            'high'   => 'مهم',
            'low'    => 'عادي',
            default  => 'عام',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'report'       => 'تقرير',
            'announcement' => 'إعلان',
            default        => 'إشعار',
        };
    }
}