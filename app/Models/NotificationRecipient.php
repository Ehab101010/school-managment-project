<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SchoolNotification;

class NotificationRecipient extends Model
{
    protected $table = 'notification_recipients';
    public $timestamps = false;

    protected $fillable = [
        'notification_id', 'recipient_user_id', 'recipient_role',
        'is_read', 'read_at',
    ];

    protected $dates = ['read_at', 'created_at'];

    public function notification()
    {
        return $this->belongsTo(SchoolNotification::class, 'notification_id');
    }

    public function recipientUser()
    {
        return $this->belongsTo(User::class, 'recipient_user_id', 'user_id');
    }
    
}